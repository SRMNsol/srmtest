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

    public function __construct()
    {
        $ci = get_instance();
        $ci->load->database();
        $this->db = $ci->db;
    }

    public function getUser($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }

    protected function getUserRawData($id, $type)
    {
        $user = $this->getUser($id);
        $raw_data = json_decode($user['raw_data'], true);

        return $raw_data[$type];
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
        $cashback = $this->getUserRawData($id, 'stats');

        $total = $cashback['total'];
        $total[0]['UserPending'] = sprintf("%01.2f",(float) $total[0]['pending']);
        $total[0]['UserAvailable'] = sprintf("%01.2f",(float) $total[0]['available']);
        $total[0]['pending'] = sprintf("%01.2f",(float) $total[0]['pending']+(float) $total[0]['referralpending']);
        $total[0]['available'] = sprintf("%01.2f",(float) $total[0]['available']+(float) $total[0]['referralavailable']);
        $total[0]['processing'] = sprintf("%01.2f",(float) $total[0]['referralprocessing']+(float) $total[0]['processing']);
        $total[0]['paid'] = sprintf("%01.2f",(float) $total[0]['referralpaid']+(float) $total[0]['paid']);
        $total[0]['referralpending'] = sprintf("%01.2f",(float) $total[0]['referralpending']);
        $total[0]['referralavailable'] = sprintf("%01.2f",(float) $total[0]['referralavailable']);
        $purchases = $cashback['purchases'];
        $index= 0 ;
        for ($i = 0; $i<count($cashback['reftransactions']); $i++) {
            $sum = 0;
            $sum += (float) $cashback['reftransactions'][$i]['referralpaid'];
            $sum += (float) $cashback['reftransactions'][$i]['referralcommissiondirect'];
            $sum += (float) $cashback['reftransactions'][$i]['referralcommissionindirect'];
            if ($sum == 0) {
                unset($cashback['reftransactions'][$i]);
            }
        }

        return array_merge(array(
            'type'  => 'all',
            'total' => $total,
        ), array(
            'transactions'    => $purchases,
            'reftransactions' => $cashback['reftransactions']
        ));
    }
}
