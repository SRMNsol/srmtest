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

    const PAYMENT_INSUFFICIENT_CASHBACK = 'insufficient';
    const PAYMENT_MISSING_DATA = 'incomplete';
    const PAYMENT_REQUEST_FAILURE = 'failure';

    public function __construct()
    {


    $ci = get_instance();

   // $ci->load->library('facebook');


/*
            $config = array();
            $config['appId'] = '117040755037895';
            $config['secret'] = '04ced89742cf2754a630775cdc956081';
            $config['fileUpload'] = false; // optional

            $fb = new Facebook($config);
           // $query = 'SELECT * FROM user WHERE uid="11952"';


$params = array(
  "access_token" => "EAABqcqyg1scBABdPOd3wAzUZArqYyd7rJt4fj2I1G66AymhPyDeXf75MbrcTuvxfpDvIDr01HdQidBXupevnkpN1IyDlZCRocB6r9Tf0cfGZB1nEl1nAr2JMBgNnKZAL62ewCT7t21k9qzB8VPrWp7G7ZAZCJcKFIZD",
  "message" => "ddddddddddddd",
  "description" => "aaaaaaaaaaaaaa."
);

 
try {
  $ret = $fb->api('/YOUR_FACEBOOK_ID/feed', 'POST', $params);
  echo 'Successfully posted to Facebook';
} catch(Exception $e) {
  echo $e->getMessage();
}

*/


     
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
        $user = $this->container['orm.em']->find('App\Entity\User', $id);
        $criteria = Doctrine\Common\Collections\Criteria::create()
            ->orderBy(['createdAt' => 'DESC']);

        $referrals = $user->getReferredUsers()->matching($criteria)->map(function (App\Entity\User $user) {
            return [
                'ref_email' => $user->getEmail(),
                'ref_created' => $user->getCreatedAt()->format('m/d/Y'),
                'sort_date' => (int) $user->getCreatedAt()->format('U'),
            ];
        })->toArray();

        return ['referrals' => $referrals];
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
        
        $extra = $em->getRepository('App\Entity\Payable')->calculateExtraUserSummary($user);
        $referral = $em->getRepository('App\Entity\Referral')->calculateUserSummary($user);

        $data['type'] = 'all';

        $total = [];
        $total[0]['pending'] = sprintf('%.2f', $summary['pending']);
        $total[0]['available'] = sprintf('%.2f', $summary['available']);
        $total[0]['processing'] = sprintf('%.2f', $summary['processing']);
        $total[0]['paid'] = sprintf('%.2f', $summary['paid']);
        $total[0]['UserPending'] = sprintf('%.2f', $cashback['pending'] + $extra['pending']);
        $total[0]['UserAvailable'] = sprintf('%.2f', $cashback['available'] + $extra['available']);
        $total[0]['referralpending'] = sprintf('%.2f', $referral['pending']);
        $total[0]['referralavailable'] = sprintf('%.2f', $referral['available']);
        $total[0]['referralcountdirect'] = $user->countDirectReferrals();
        $total[0]['referralcountindirect'] = $user->countIndirectReferrals();

        $data['total'] = $total;
        $data['transactions'] = [];
        $data['reftransactions'] = [];

        return $data;
    }

    public function processPayment($userId)
    {
        try {
            $em = $this->container['orm.em'];
            $user = $em->find('App\Entity\User', $userId);
            if ($user === null) {
                throw new Exception('User not found');
            }

            $summary = $em->getRepository('App\Entity\Payable')->calculateUserSummary($user);
            if ($summary['available'] < 10) {
                return self::PAYMENT_INSUFFICIENT_CASHBACK;
            }

            if ($user->hasRequiredPaymentInfo() === false) {
                return self::PAYMENT_MISSING_DATA;
            }


          


            $payment = $em->getRepository('App\Entity\Payment')->createPaymentForUser($user);





            return $payment;
        } catch (Exception $e) {
            return self::PAYMENT_REQUEST_FAILURE;
        }
    }
}
