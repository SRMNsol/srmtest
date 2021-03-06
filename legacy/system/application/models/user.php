<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use App\Entity\User as UserEntity;

/**
 * User Model
 * A proxy for a user model until users are implemented
 * This model is responsible for tying user-authentication view
 * to the status of the authentication cookie
 */
class User extends Model
{
   public $table = "user";

    public $uinterface = array(
        'uid', 'email', 'first_name', 'last_name', 'facebook_auto', 'twitter_auto',
        'paypal_email', 'payment_method', 'alias', 'charity_id',
        'admin', 'send_reminders', 'send_updates','created','last_long',
        'address', 'city', 'state', 'zip',
        'last_refer','purchase_exempt','password', 'last_reset'
    );

    public function User()
    {
        parent::Model();
        $this->load->library('beesavy');
        $this->load->model('admin');
    }

    /*Content to show based on user login status*/
    public function get_banner($auth)
    {
        $login_status = $this->db_session->userdata('login');
        if ($login_status) {
            return array('page'=>'blocks/banner_user','vars'=>$login_status);
        } else {
            return array('page'=>'blocks/banner','vars'=>array());
        }
    }

    public function checklogin($email){

       $sql = 'SELECT status FROM user WHERE email ='.'"'.$email.'"'.' ';
        
		$query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];
		//return $result[0];

        }

    public function newaccount()
    {
       /*
      $date=date('Y-m-d');

           $prev_date = date("Y-m-d H:i:s", strtotime($date .' -14 day'));



          
      
        echo $sql = 'SELECT email FROM user WHERE created >= '.'"'.$prev_date.'"'.'';
       exit;
        $query = $this->db->query($sql);
        $result = $query->result_array();
        print_r($result[0]); exit;
        return $result[0];
        */
        //return $result[0]; 
        

    } 
    public function popupstatus()
    {
       $sql = 'SELECT popup_status FROM user WHERE uid = 10';
        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];
        //return $result[0];

    }     
	public function updatepayment($user_id){
		

		$sql = "SELECT processing , sum(available) as totalavail FROM Payable where user_id=$user_id";
  		$query = $this->db->query($sql);
        $result = $query->result_array();
		//$total=$result[0]);
		$abc=$result[0];
		$cdf=$abc['totalavail'];
		$sql = "UPDATE Payable set processing=processing+$cdf where user_id=$user_id limit 1";
	
		$query = $this->db->query($sql);

       
		$sql = "UPDATE Payable set available='0' where user_id=$user_id";
	
		$query = $this->db->query($sql);

		$sql = "SELECT email , first_name FROM user where uid=$user_id";
	
		$query = $this->db->query($sql);
		$result = $query->result_array();
	
		$email=$result[0];
		

		$this->load->library('email');
		$this->email->from($email['email']);
		$this->email->to('developer@gmail.com');
		$this->email->subject('Payment Request');
		$this->email->message('Payment Request');
		$this->email->send();

        }	
		
	
    public function onreffral(){

        $sql = 'SELECT referral_status FROM user WHERE id = 157476 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];

        }

    public function loadReffral($limit)
    {       
$q =$this->db->query("SELECT u.*, Count(r.ref_id) as countid FROM user u JOIN refer r on u.uid = r.ref_id  GROUP BY ref_id ORDER BY u.uid DESC limit
    $limit");
        return $q->result_array();
    }


    public function mprivacy(){

        $sql = 'SELECT *  FROM pages WHERE page_id = 1 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];


        }

  public function moverview(){

        $sql = 'SELECT *  FROM pages WHERE page_id = 7 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];


        }

public function mreferel(){

        $sql = 'SELECT *  FROM pages WHERE page_id = 9 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];


        }

public function mfaq(){

        $sql = 'SELECT *  FROM Faqs INNER JOIN Faq_cate  ON Faqs.faq_cate= Faq_cate.cate_id';

        $query = $this->db->query($sql);
        $result = $query->result_array();

       return $result;
    
    // /    return $result[0];


        }






public function mguide(){

        $sql = 'SELECT *  FROM pages WHERE page_id = 2 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];


        }

public function mcompare(){

        $sql = 'SELECT *  FROM pages WHERE page_id = 11 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];


        }


public function mjoin(){

        $sql = 'SELECT *  FROM pages WHERE page_id = 10 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];


        }


    public function mterms(){

        $sql = 'SELECT *  FROM pages WHERE page_id = 4 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];


        }
    public function mabout(){

        $sql = 'SELECT *  FROM pages WHERE page_id = 3 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];


        }
    public function mhelp(){

        $sql = 'SELECT *  FROM pages WHERE page_id = 6 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];


        }
        public function mcashback(){

        $sql = 'SELECT *  FROM pages WHERE page_id = 5 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];


        }

    public function get_home($auth)
    {
        $login_status = $this->db_session->userdata('login');
        if ($login_status) {
            $data = $this->info();
            $data['stores'] =12;
            $data['deals'] = 3;
            if (!strtotime($login_status['last_login'])) {
            $data['last_login'] = '-';
            } else {
            $data['last_login'] = date("F j, Y", strtotime($login_status['last_login']));
            }
            $data['created'] =date("F j, Y", strtotime($data['created']));
            $lr = $data['last_refer'];
            if ($lr == 0) {
                $data['last_refer'] = "-";
            } else {
                $data['last_refer'] =date("F j, Y", strtotime($data['last_refer']));
            }

            return array('page'=>'home/home_user','vars'=>$data);
        } else {
            return array('page'=>'home/home','vars'=>array(
                'stores'=>6,
                'deals'=>3));
        }
    }

    
    //User login methods
    public function login($email, $password)
    {
        $res = $this->db->get_where('user', array('email'=>$email));
        $res = $res->result_array();
		
		
		
        if (empty($res)) {
            $id = '';
        } else {
            $id = $res[0]['email'];
        }
        $response = $this->beesavy->getUser($id, $password);
        if ($response) {
            $id = $response['id'];
            $timestamp = date('Y-m-d H:i:s');
            $q = "UPDATE user set last_login = '$timestamp' where email=?";
            $this->db->query($q, array($email));
            $q = "UPDATE user set password = ? where email=?";
            $this->db->query($q, array($password, $email));
            $last_login = $res[0]['last_login'];
            $this->db_session->set_userdata('login',
                array(
                    'last_login'=>$last_login,
                    'login'=>True,
                    'admin'=>$res[0]['admin'],
                    'email'=>$email,
                    'id'=>$response['uid'],
                    'first_name'=>$response['first_name'],
                    'password'=>$password)
                );
        } else {
            return array('code'=>20, 'user'=>$email);
        }
    }

    public function logout()
    {
        $this->db_session->set_userdata('login','');
    }

   //User methods
    public function add_user($email, $referral, $password,$refcode,$refstatus)
    {
        
        #Check if a referral was not given
        #If not given check if a user came to site through a referral
        if (!$referral) {
            $ref = $this->db_session->userdata('referral');
            if ($ref) {
                $sql = "select * from user where alias = ? or uid = ?";
                $q = $this->db->query($sql, array($referral, $referral));
                $q = $q->result_array();
                $user = $q[0];
                $referral = $user['uid'];
            } else {
                $referral = $this->admin->getDefaultId();
            }
        } else {
                $sql = "select * from user where alias = ? or uid = ?";
                $q = $this->db->query($sql, array($referral, $referral));
                $q = $q->result_array();
                if (!empty($q)) {
                    $user = $q[0];
                    $referral = $user['uid'];
                }
        }

             $this->db->insert('user', array(
            'email' => $email,
            'password' => $password,
            'created' => date('Y-m-d H:i:s'),
            'ref_uid' => $referral,
            'status' => 'active',
        ));

        $userId =$this->db->insert_id(); 

        if($refstatus==1)
        {
            $sql = 'SELECT bonus , status, bonus_thems, id FROM user WHERE alias = '.'"'.$refcode.'"';
            $query = $this->db->query($sql);
            $result = $query->result_array();
			//print_r($result[0]['bonus']); exit;
            $userstatus=$result[0];
			
			 $idd=$userstatus['id'];
			
			
			
		   if($userstatus['status']=='active')
		   if($userstatus['bonus']=='active')
          {
	
			  
            $this->db->insert('Payment', array(
            'user_id' => $userId,
            'amount' => 5,
            'requestedAt' => date('Y-m-d H:i:s'),
            'status' => 'pending',
        ));
		  }
		  if($userstatus['status']=='active')
		  if($userstatus['bonus_thems']=='active')
		  {
			  
		     $this->db->insert('Payment', array(
            'user_id' => $idd,
            'amount' => 5,
            'requestedAt' => date('Y-m-d H:i:s'),
            'status' => 'pending',
        ));
		
			
          }
  
	    }
		





        $this->db->where('uid', $userId);
        $this->db->update('user', array(
            'alias' => sprintf('U%d', $userId)
        ));
    }


    public function last_password_reset($email, $timelength)
    {
        $sql = 'SELECT * FROM user WHERE email = ?';
        $query = $this->db->query($sql, array($email));
        $result = $query->result_array();

        if (!empty($result)) {
            $row = $result[0];
            if ($row['last_reset'] === null) {
                return true;
            }
            $lastReset = new \DateTime($row['last_reset']);
            return $lastReset < new \DateTime($timelength);
        }

        throw new Exception('Invalid email'); // no records associated with $email
    }

    public function reset_password($email)
    {
        $sql = 'SELECT * FROM user WHERE email = ?';
        $query = $this->db->query($sql, array($email));
        $result = $query->result_array();
        if (!empty($result)) {
            $newPassword = "bee".(string) mt_rand(1000000,9999999);
            $this->db->where('email', $email);
            $this->db->update('user', array(
                'password' => UserEntity::passwordHash($newPassword),
                'last_reset' => date('Y-m-d H:i:s'),
            ));
            return $newPassword;
        }

        throw new Exception('Invalid email'); // no records associated with $email
    }

    public function set_referral($alias)
    {
        $this->db_session->set_userdata('referral',$alias);
    }

    public function eb_info()
    {
        $login_status = $this->db_session->userdata('login');
        $id = $login_status['id'];
        $password = $login_status['password'];
        $response = $this->beesavy->getUser($id, $password);

        return $response;
    }

    public function info()
    {
        $login_status = $this->db_session->userdata('login');
        $id = addslashes($login_status['id']);
        $q = "select * from user where uid=$id;";
        $res = $this->db->query($q);
        $res = $res->result_array();
        $res = $res[0];

        return $res;
    }

    public function info_user($id)
    {
        $q = "select * from user where uid=$id;";
        $res = $this->db->query($q);
        $res = $res->result_array();
        $res = $res[0];

        return $res;
    }
	
	
	
	public function morestore($offset, $limit)
    {

		$q =$this->db->query("SELECT * FROM Merchant WHERE id BETWEEN '$offset' AND '$limit'");
		return $q->result_array();
    }
	
	
	public function getReffral()
    {		
		$q =$this->db->query("SELECT u.*, Count(r.ref_id) as countid FROM user u JOIN refer r on u.uid = r.ref_id  GROUP BY ref_id ORDER BY u.uid DESC limit 4");
		return $q->result_array();
    }
	public function checksign($email)
    {		
		$q =$this->db->query("SELECT * FROM user WHERE email='$email'");
		return  $q->num_rows;

    }	
	 public function recentOrder()
    {		//echo 'sssssss'; exit;
		$q =$this->db->query("SELECT c.* , m.logoPath ,m.id FROM cashback c INNER JOIN Merchant m ON c.merchant_id=m.id ORDER BY c.merchant_id DESC limit 2"  );
		return $q->result_array();
    }	
	
 
	
	public function allOrder()
    {		
		$q =$this->db->query("SELECT c.* , m.logoPath FROM cashback c INNER JOIN Merchant m ON c.merchant_id=m.id");
		return $q->result_array();
    }	
    public function ebinfo_user($id)
    {
        $id = $id;
        $response = $this->beesavy->getUser($id, '', True);

        return $response;
    }

    public function set_password($new, $current)
    {
        $login_status = $this->db_session->userdata('login');
        $email = $login_status['email'];
        $password = $login_status['password'];
        if ($password == $current) {
            $this->set_setting("password", $new);
            $this->login($email, $new);
        }
    }

    public function set_data($data)
    {
        foreach ($data as $setting=>$value) {
            $this->set_setting($setting,$value);
        }
    }

    public function set_setting($setting, $value)
    {
        $login_status = $this->db_session->userdata('login');
        $email = $login_status['email'];
        $password = $login_status['password'];
        $id = $login_status['id'];
        $value=addslashes($value);
        $setting = addslashes($setting);
        if ($setting == "alias" || $setting=="email") {
            $q = $this->db->query("select * from user where $setting = '$value';");
            $q = $q->result_array();
            if (file_exists(APPPATH.'controllers/'.$value.EXT)) {
                return "in_use";
            }
            if ($value=="search"||is_dir($value)) {
                return "in_use";
            }
            if (empty($q)) {
               $this->db->update('user', array($setting=>$value), "uid = $id");
            } else {
                return "in_use";
            }
        } elseif (in_array($setting, $this->uinterface)) {
            $this->db->update('user', array($setting=>$value), "uid = $id");
        }
        if($setting=="email")
            $email = $value;
        if($setting=="password")
            $password = $value;
        $this->login($email, $password);
    }

    public function set_setting_user($setting, $value, $id)
    {
        $info = $this->info_user($id);
        $ebinfo = $this->ebinfo_user($id);
        $email = $info['email'];
        $password = $info['password'];
        if (in_array($setting, $this->uinterface)) {
            $this->db->update('user', array($setting=>$value), "uid = $id");
        }
        if($setting=="email")
            $email = $value;
        if($setting=="password")
            $password = $value;
    }

    //User data access methods
    public function get_field($field)
    {
        $login_status = $this->db_session->userdata('login');
        if ($login_status) {
            return $login_status[$field];
        } else {
            return 0;
        }
    }

    public function is_admin()
    {
        $login_status = $this->db_session->userdata('login');
        if ($login_status) {
            return $login_status['admin'];
        } else {
            return False;
        }
    }

    public function login_status()
    {
        $login_status = $this->db_session->userdata('login');

        return $login_status;
    }

    public function check_referral($id)
    {
			$id=trim($id);
		
        if (!$id) {
            return True;
        }

        $q = "select * from user where uid='$id' OR alias='$id';";
        $res = $this->db->query($q);
        $res = $res->result_array();
		//print_r($res); exit;

        if (count($res)) {
            $res = $res[0];
            return $res['uid'];
        }

        return False;
    }

}
