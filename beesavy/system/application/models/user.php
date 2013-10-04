<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Model
 * A proxy for a user model until users are implemented
 * This model is responsible for tying user-authentication view
 * to the status of the authentication cookie
 */
class User extends Model {
    var $table = "user";
    var $uinterface = array(
        'id', 'email', 'facebook_auto', 'twitter_auto',
        'paypal_email', 'payment_method', 'alias', 'charity_id',
        'admin', 'send_reminders', 'send_updates','created','last_long',
        'last_refer','purchase_exempt','password',
    );
    function User(){
        parent::Model();
        $this->load->library('extrabux');
        $this->load->library('beesavy');
        $this->load->model('admin');
    }
    /*Content to show based on user login status*/
    function get_banner($auth){
        $login_status = $this->db_session->userdata('login');
        if($login_status){
            return array('page'=>'blocks/banner_user','vars'=>$login_status);
        }else{
            return array('page'=>'blocks/banner','vars'=>array());
        }
    }
    function get_home($auth){
        $login_status = $this->db_session->userdata('login');
        if($login_status){
            $info = $this->info();
            $login_status = $this->db_session->userdata('login');
            $id = $login_status['id'];
            $password = $login_status['password'];
            $user   = $this->beesavy->getUser($id, $password, TRUE);
            $stats = $this->beesavy->getUserStats($id);
            $data = array_merge($user, $stats, $info);
            $data['stores'] =12;
            $data['deals'] = 3;
            if(!strtotime($login_status['last_login'])){
            $data['last_login'] = '-';
            }else{
            $data['last_login'] = date("F j, Y", strtotime($login_status['last_login']));
            }
            $data['created'] =date("F j, Y", strtotime($data['created']));
            $lr = $data['last_refer'];
            if($lr == 0){
                $data['last_refer'] = "-";
            }else{
                $data['last_refer'] =date("F j, Y", strtotime($data['last_refer']));
            }

            return array('page'=>'home/home_user','vars'=>$data);
        }else{

            return array('page'=>'home/home','vars'=>array(
                'stores'=>6,
                'deals'=>3));
        }
    }

    //User login methods
    function login($email, $password){
        $res = $this->db->get_where('user', array('email'=>$email));
        $res = $res->result_array();
        if(empty($res)){
            $id = '';
        }else{
            $id = $res[0]['email'];
        }
        $response = $this->beesavy->getUser($id, $password);
        if($response){
            $id = $response['id'];
            $q = "UPDATE user set last_login = CURRENT_TIMESTAMP where email=?";
            $this->db->query($q, array($email));
            $q = "UPDATE user set password = ? where email=?";
            $this->db->query($q, array($password, $email));
            $q = "UPDATE user set id = ? where email=?";
            $this->db->query($q, array($id, $email));
            $last_login = $res[0]['last_login'];
            $this->db_session->set_userdata('login',
                array(
                    'last_login'=>$last_login,
                    'login'=>True,
                    'admin'=>$res[0]['admin'],
                    'email'=>$email,
                    'id'=>$response['id'], 
                    'first_name'=>$response['first_name'],
                    'password'=>$password)
                );
        }else{
            return array('code'=>20, 'user'=>$email);
        }
    }
    function logout(){
        $this->db_session->set_userdata('login','');
    }

    //User methods
    function add_user($email, $referral, $password){
        #Check if a referral was not given
        #If not given check if a user came to site through a referral
        echo $referral;
        if(!$referral){
            $ref = $this->db_session->userdata('referral');
            if($ref){
                $sql = "select * from user where alias = ? or id = ?";
                $q = $this->db->query($sql, array($referral, $referral));
                $q = $q->result_array();
                $user = $q[0];
                $referral = $user['id'];
            }else{
                $referral = $this->admin->getDefaultId();
            }
        }else{
                $sql = "select * from user where alias = ? or id = ?";
                $q = $this->db->query($sql, array($referral, $referral));
                $q = $q->result_array();
                if(!empty($q)){
                    $user = $q[0];
                    $referral = $user['id'];
                }
        }
        $id = $this->beesavy->createUser('','',$email,$password, $referral,$referral);
        if($id==0){
            return '20';
        }
        $id = addslashes($id);
        $this->db->insert('user',array('id'=>$id, 'email'=>$email,'alias'=>$id, 'password'=>$password));
    }
    function set_referral($alias){
        $this->db_session->set_userdata('referral',$alias);
    }
    function eb_info(){
        $login_status = $this->db_session->userdata('login');
        $id = $login_status['id'];
        $password = $login_status['password'];
        $response = $this->beesavy->getUser($id, $password);
        return $response;
    }
    function info(){
        $login_status = $this->db_session->userdata('login');
        $id = addslashes($login_status['id']);
        $q = "select * from user where id=$id;";
        $res = $this->db->query($q);
        $res = $res->result_array();
        $res = $res[0];
        return $res;
    }

    function info_user($id){
        $q = "select * from user where id=$id;";
        $res = $this->db->query($q);
        $res = $res->result_array();
        $res = $res[0];
        return $res;
    }
    function ebinfo_user($id){
        $id = $id;
        $response = $this->beesavy->getUser($id, '', True);
        return $response;
    }

    //User update methods
    function set_check($fname, $lname, $addr, $city, $state, $zip){
        $data = array(
            'first_name'=> $fname,
            'last_name'=> $lname,
            'street'=> $addr,
            'city'=> $city,
            'state'=> $state,
            'zip'=>$zip,
            'user_payment_method_type'=>'check',
            'user_payment_method_first_name'=> $fname,
            'user_payment_method_last_name'=> $lname,
            'user_payment_method_street'=> $addr,
            'user_payment_method_city'=> $city,
            'user_payment_method_state'=> $state,
            'user_payment_method_zip'=>$zip);
        $this->set_data_batch($data);
    }
    function set_data_batch($data){
        $login_status = $this->db_session->userdata('login');
        $email = $login_status['email'];
        $password = $login_status['password'];
        $id = $login_status['id'];
        $this->beesavy->updateUserBatch($id, $email, $password, $data);
    }
    function set_password($new, $current){
        $login_status = $this->db_session->userdata('login');
        $email = $login_status['email'];
        $password = $login_status['password'];
        if($password == $current){
            $this->set_setting("password", $new);
            $this->login($email, $new);
        }
    }
    function set_data($data){
        foreach($data as $setting=>$value){
            $this->set_setting($setting,$value);
        }
    }
    function set_setting($setting, $value){
        $login_status = $this->db_session->userdata('login');
        $email = $login_status['email'];
        $password = $login_status['password'];
        $id = $login_status['id'];
        $value=addslashes($value);
        $setting = addslashes($setting);
        if(in_array($setting,$this->extrabux->uinterface)){ 
            $this->beesavy->updateUser($id, $email, $password, $setting, $value);
        }
        if($setting == "alias" || $setting=="email"){
            $q = $this->db->query("select * from user where $setting = '$value';");
            $q = $q->result_array();
            if (file_exists(APPPATH.'controllers/'.$value.EXT))
            {
                return "in_use";
            }
            if ($value=="search"||is_dir($value)){
                return "in_use";
            }
            if(empty($q)){
               $this->db->update('user', array($setting=>$value), "id = $id");
            }else{
                return "in_use";
            }
        }elseif(in_array($setting, $this->uinterface)){
            $this->db->update('user', array($setting=>$value), "id = $id");
        }
        if($setting=="email")
            $email = $value;
        if($setting=="password")
            $password = $value;
        $this->login($email, $password);
    }

    function set_setting_user($setting, $value, $id){
        $info = $this->info_user($id);
        $ebinfo = $this->ebinfo_user($id);
        $email = $info['email'];
        $password = $info['password'];
        echo $password;
        echo "<br/>";
        echo $ebinfo['password'];
        echo "<br/>";
        print_r($info);
        print_r($ebinfo);
        if(in_array($setting,$this->extrabux->uinterface)){ 
            $this->beesavy->updateUser($id, $email, $password, $setting, $value);
        }
        if(in_array($setting, $this->uinterface)){
            $this->db->update('user', array($setting=>$value), "id = $id");
            echo $value;
        }
        if($setting=="email")
            $email = $value;
        if($setting=="password")
            $password = $value;
    }

    //User data access methods
    function get_field($field){
        $login_status = $this->db_session->userdata('login');
        if($login_status){
            return $login_status[$field];
        }else{
            return 0;
        }
    }

    function is_admin(){
        $login_status = $this->db_session->userdata('login');
        if($login_status){
            return $login_status['admin'];
        }else{
            return False;
        }
    }
    function login_status(){
        $login_status = $this->db_session->userdata('login');
        return $login_status;
    }
    function check_referral($id){
        if(!$id)
            return True;
        $q = "select * from user where id='$id' OR alias='$id';";
        $res = $this->db->query($q);
        $res = $res->result_array();
        if(!empty($res)){
            $res = $res[0];
            return $res['id'];
        }
        return False;
    }
}
?>
