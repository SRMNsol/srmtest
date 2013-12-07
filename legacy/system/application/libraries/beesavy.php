<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BeeSavy Library
 *
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		Jonny Simkin
*/

class Beesavy
{
    protected $db;
    protected $container;

    public function __construct()
    {
        $ci = get_instance();
        $ci->load->database();
        $this->db = $ci->db;
        $ci->load->helper('bridge');
        $this->container = silex();
    }

    public function getUser($idOrEmail, $password, $noAuth = False)
    {
        $user = null;

        if (strpos($idOrEmail, '@') > 0) {
            $user = $this->db->get_where('user', ['email' => $idOrEmail])->row_array();
        } elseif (is_numeric($idOrEmail)) {
            $user = $this->db->get_where('user', ['uid' => $idOrEmail])->row_array();
        }

        if (is_array($user)) {
            unset($user['first_name']); // temporarily use value from raw_user_data
            unset($user['raw_data']);
            $raw_user_data = json_decode($user['raw_user_data'], true);
            unset($user['raw_user_data']);
            $user = $user + (array) $raw_user_data;

            if ($noAuth || $password === $user['password']) {
                return $user;
            }
        }

        return false;
    }

    protected function getUserRawData($id, $type)
    {
        $row = $this->db
            ->select('raw_data')
            ->get_where('user', ['uid' => $id])
            ->row_array();

        $raw_data = json_decode($row['raw_data'], true);

        return isset($raw_data[$type]) ? $raw_data[$type] : [];
    }

    public function getUserReferrals($id)
    {
        return $this->getUserRawData($id, 'referrals');
    }

    public function getUserReport($id)
    {
        return $this->getUserRawData($id, 'report');
    }

    public function getUserStats($id)
    {
        $em = $this->container['orm.em'];
        $user = $em->getReference('App\Entity\User', $id);
        $summary = $em->getRepository('App\Entity\Payable')->calculateUserSummary($user);
        $cashback = $em->getRepository('App\Entity\Cashback')->calculateUserSummary($user);
        $referral = $em->getRepository('App\Entity\Referral')->calculateUserSummary($user);

        $data['type'] = 'all';

        $total = [];
        $total[0]['pending'] = sprintf('%.2f', $summary['pending']);
        $total[0]['available'] = sprintf('%.2f', $summary['available']);
        $total[0]['processing'] = sprintf('%.2f', $summary['processing']);
        $total[0]['paid'] = sprintf('%.2f', $summary['paid']);
        $total[0]['UserPending'] = sprintf('%.2f', $cashback['pending']);
        $total[0]['UserAvailable'] = sprintf('%.2f', $cashback['available']);
        $total[0]['referralpending'] = sprintf('%.2f', $referral['pending']);
        $total[0]['referralavailable'] = sprintf('%.2f', $referral['available']);
        $total[0]['referralcountdirect'] = $user->countDirectReferrals();
        $total[0]['referralcountindirect'] = $user->countIndirectReferrals();

        $data['total'] = $total;
        $data['transactions'] = [];
        $data['reftransactions'] = [];

        return $data;
    }
}
