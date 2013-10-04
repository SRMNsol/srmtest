<?php
/**
 */
class Account extends Controller {

	function Account()	{
		parent::Controller();
        $this->load->library('extrabux');
        $this->load->library('beesavy');
        $this->load->helper('url_helper');
        $this->load->model('user');
        $this->load->model('code');
        $this->load->model('facebook');
        $this->load->model('twitter');
        $this->load->model('emailer');
        $this->error = array();
        $this->user_id = $this->user->get_field('id');
	}

    function __get_header(){
        $data = $this->blocks->getBlocks();
        $data = array_merge($data, $this->__get_user());
        return $data;
    }

    function __get_user(){
        if(!$this->user->login_status()){
           redirect('main/signin?user=&code=20');
        }
		
		$settings = $this->beesavy->getUserStats($this->user_id);

        $settings = array_merge($settings, $this->user->eb_info());
        $settings = array_merge($settings, $this->user->info());
        return $settings;
    }

    function index($success = False, $notice=False, $error = ""){
        $data = $this->__get_header();
        //$data['errors'] = $this->code->get_errors($this->error);
        $data['errors'] = array();
        if($success && empty($this->error)){
            $data['success'] = "Account settings updated";
        }
        if($notice==1){
            $data['notice'] = "Welcome to BeeSavy! Update your account settings below or <a href=''>start ".
                "shopping</a> now!";
        }
        if($notice==2 && $data['payment_method']){
            $data['notice'] = "Verify your payment method below and then click the REQUEST A PAYMENT button on".
                " the right.";
        }elseif($notice==2) {
            $data['notice'] = "Select your payment method below and then click the REQUEST A PAYMENT button on the right.";
        }
        if($notice==3){
            $data['notice'] = "Your cash back is being processed and should arrive in 10-14 days.";
        }
        if($notice==4){
            $data['success'] = "Your payment is being processed";
        }
        if($notice==5){
            $data['errors'][] = array('message'=>"There was a problem processing your payment, please check that you have selected and filled out a payment method");
            //$data['errors'][] = array('message'=>urldecode($error));
        }
		if($notice==6){
            $data['errors'][] = array('message'=>"You must have $10 in available cash back and a confirmed purchase to request a payment.");
            //$data['errors'][] = array('message'=>urldecode($error));
        }
        $this->parser->parse('account/account', $data);
    }

    function payment(){
        $data = $this->__get_header();
        $fail = $this->beesavy->processPayment($this->user_id);
		
        if($fail){
			if($fail == "You must have $10 in available cash back and a confirmed purchase to request a payment.")
			{
				redirect("/account/index/0/6/".urlencode($fail));
			}
			else
			{
            	redirect("/account/index/0/5/".urlencode($fail));
			}
        }else{
            redirect('/account/index/0/4');
        }
    }

    function register(){
        $email = $this->input->post("email");
        $referral = $this->input->post("referral");
        $porig = $this->input->post("password");
        $pass  = sha1($this->input->post("password"));
        $passC = sha1($this->input->post("password_confirm"));

        #Error check
        $errors = array();
        if(strlen($this->input->post("password"))<6)
            $errors[] = $this->code->get_code('invalid_password');
        if(filter_var($email, FILTER_VALIDATE_EMAIL)==FALSE){
            $errors[] = $this->code->get_code('invalid_email');
            $email = "";
        }
        if($pass != $passC)
            $errors[] = $this->code->get_code('password_mismatch');
        if(!$rid = $this->user->check_referral($referral)){
            $errors[] = $this->code->get_code('invalid_referral');
        }
            if($rid == 1){
                $rid = 0;
            }
        if(empty($errors)){
            $error = $this->user->add_user($email, $rid, $pass);
            if($error){
                //return;
                $errors[] = $this->code->get_code('fail');
            }
        }
        #Show page
        if(empty($errors)){
            $this->user->login($email,$pass);
            $data = array('email'=>$email);
            $msg = $this->parser->parse('email/join', $data, True);
            $tmsg = $this->parser->parse('email/joint', $data, True);
            $this->emailer->sendMessage($msg, $tmsg, $data['email'], "BeeSavy - Welcome to BeeSavy!");
            redirect('/account/index/0/1');
        }else{
            $error_str = implode(",",$errors);  
            redirect("/main/joinnow?email=$email&referral=$referral&errors=$error_str");
        }
    }
    function logout(){
        $this->user->logout();
        redirect("");
    }

    function forgot(){
        $email = $this->input->post('email');
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $new = "bee".(string)mt_rand(1000000,9999999);
            $q = "select * from user where email = '$email';";
            $res = $this->db->query($q);
            $res = $res->result_array();
            if(!empty($res)){
                $res = $res[0];
                $id = $res['id'];
                $einfo = $this->beesavy->getUser($res['id'], '', True);
                $oldpass = $einfo['password'];
                $q = "update user set password = '".sha1($new)."' where id='$id';";
                $this->db->query($q);
                $this->beesavy->updateUser($res['id'], $email, $oldpass, 'password', sha1($new));
                $data = array('email'=>$email, 'password'=>$new);
                $msg = $this->parser->parse('email/newpassword', $data, True);
                $txtmsg = $this->parser->parse('email/newpasswordt', $data, True);
                $q = "select * from user where id='$id';";
                $res = $this->db->query($q);
               $this->emailer->sendMessage($msg, $txtmsg, $data['email'], "BeeSavy - New password request");
                redirect("/main/forgot/1/$email");
                return;
            }else{
                redirect("/main/forgot?errors=24");
            }
        }
        redirect("/main/forgot?errors=24");
    }

    function login(){
        $email = $this->input->post('email');
        $password = sha1($this->input->post('password'));
        $error = $this->user->login($email,$password);
        if($error){
            $user = urlencode($error['user']);
            $code = $error['code'];
            redirect("/main/signin?user=$user&code=$code");
        }else{
            redirect("");
        }
    }

    function edit_payment(){
        $method = $this->input->post('pmethod');
        if(!empty($method)){
        $method = "__$method";
        $this->$method();
        }
        $this->index(1);
    }
    function __check(){
        $fname = $this->input->post('firstName');
        $lname = $this->input->post('lastName');
        $addr = $this->input->post('street');
        $city = $this->input->post('city');
        $state =$this->input->post('state');
        $zip =$this->input->post('zip');
        if(!($fname && $lname && $addr && $city && $state && $zip)){
            $this->error[] = $this->code->get_code('check_error');
        }else{
            $this->user->set_setting('user_payment_method_type', 'check');
            $this->user->set_setting('payment_method', 'CHECK');
            $this->user->set_check($fname, $lname, $addr, $city, $state, $zip);
        }
    }
    function __paypal(){
        $email =$this->input->post('paypalEmail');
        if(filter_var($email, FILTER_VALIDATE_EMAIL)==FALSE){
            $this->error[] = $this->code->get_code('paypal_error');
        }else{
            $this->user->set_setting('paypal_email', $email);
            $this->user->set_setting('payment_method', 'PAYPAL');
            $this->user->set_data_batch(array(
                'user_payment_method_type'=>'paypal',
                'user_payment_method_paypal_email'=>$email));
        }
    }
    function __charity(){
        $charity =$this->input->post('charity_id');
        if($charity){
            $this->user->set_setting('payment_method', 'CHARITY');
            $this->user->set_data_batch(array(
                'user_payment_method_type'=>'charity',
                'user_payment_method_charity_id'=>$charity));
        }else{
            $this->error[] = $this->code->get_code('charity_error');
        }
    }
    function set_alias(){
        $new =$this->input->post('email');
        $conf=$this->input->post('email_confirm');
        if(strlen($new)<3 || preg_match("/\D/", $new)==0){
            $this->error[] = $this->code->get_code('alias_format');
        }
        else if($new==$conf){
            if(empty($this->error)){
                $e = $this->user->set_setting('alias', $new);
                if($e){
                $this->error[] = $this->code->get_code($e);
                }
            }
        }else{
            $this->error[] = $this->code->get_code('alias_mismatch');
        }

        $this->index(1);
    }
    function set_email(){
        $new =$this->input->post('email');
        $conf=$this->input->post('email_confirm');
        if(filter_var($new, FILTER_VALIDATE_EMAIL)==FALSE){
            $this->error[] = $this->code->get_code('invalid_email');
        }else{
            if($new==$conf){
                $e = $this->user->set_setting('email', $new);
                if($e){
                $this->error[] = $this->code->get_code($e);
                }
            }else{
                $this->error[] = $this->code->get_code('email_mismatch');;
            }
        }
        $this->index(1);
    }
    function set_password(){
        $current =sha1($this->input->post('password_current'));
        $new =sha1($this->input->post('password_new'));
        $conf=sha1($this->input->post('password_confirm'));
        $info = $this->user->info();
        if(strlen($this->input->post("password_new"))<6){
            $errors[] = $this->code->get_code('invalid_password');
        }else{
            if($new==$conf){
                $this->user->set_password($new, $current);
            }else{
                $this->error[] = $this->code->get_code('password_mismatch');
            }
        }
        $this->index(1);
    }
    function set_setting(){
        $setting =$this->input->post('setting');
        $value =$this->input->post('value');
        if($setting == "facebook_auto" && $value){
            $url = $this->facebook->request_permissions(base_url()."account/add_facebook", $this->user_id);
            if($url){
                redirect($url);
            }
        }
        if($setting == "twitter_auto" && $value){
            $url = $this->twitter->request_permissions(base_url()."account/add_twitter", $this->user_id);
            if($url){
                redirect($url);
            }
        }
        
            $this->user->set_setting($setting, $value);
        $this->index();
        
    }
    function add_facebook(){
        $success = $this->facebook->get_access_token($this->user_id);
        if(!$success){
            $error = '5';
            redirect("/account");
        }else{
        $setting = "facebook_auto";
        $value = 1;
        $this->user->set_setting($setting, $value);
        redirect("/account");
        }
    }
    function add_twitter(){
        $success = $this->twitter->get_access_token($this->user_id);
        if(!$success){
            $error = '5';
            redirect("/account");
        }else{
        $setting = "twitter_auto";
        $value = 1;
        $this->user->set_setting($setting, $value);
        redirect("/account");
        }
    }
    function set_email_setting(){
        $send_updates = $this->input->post('send_updates');
        $send_reminders = $this->input->post('send_reminders');
        $this->user->set_setting("send_reminders", $send_reminders);
        $this->user->set_setting("send_updates", $send_updates);
        $this->index(1);
    }

}
?>
