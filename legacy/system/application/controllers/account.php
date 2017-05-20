<?php

use App\Entity\User;

/**
 */
class Account extends Controller
{
 

    public function Account()
    {
		

        parent::Controller();

		
        $this->load->library('beesavy');        
		 $this->load->library('EmailSender');
        $this->load->model('user');
        $this->load->helper('bridge');
        $this->load->model('code'); 
        $this->load->model('facebook');
        $this->load->model('twitter');
    	
        $this->error = array();
        $this->user_id = $this->user->get_field('id');
		
		
		
    }

    public function __get_header()
    {
        $data = $this->blocks->getBlocks();
        $data = array_merge($data, $this->__get_user());

        return $data;
    }

    public function __get_user()
    {
        if (!$this->user->login_status()) {
           redirect('main/signin?user=&code=20');
        }

        $settings = $this->beesavy->getUserStats($this->user_id);

        $settings = array_merge($settings, $this->user->eb_info());
        $settings = array_merge($settings, $this->user->info());

        return $settings;
    }
    public function checkpopup()
    {
       
        $data['popupstatus']= $this->user->popupstatus(); 
        return $data['popupstatus'];         
    }

    public function procestoavail()
    {
		 
		$data['message']=$this->user->updatepayment($this->user_id);
		
    }
    public function index($success = False, $notice=False, $error = "")
    {
		 if(!$this->db_session->userdata('login')['login']){
			 
			  redirect('main/joinlogin');

 }
		
		
        $data = $this->__get_header();
        $data['errors'] = $this->code->get_errors($this->error);
		
        if ($success && empty($this->error)) {
            $data['success'] = "Account settings updated";
        }
        if ($notice==1) {
            $data['notice'] = "Welcome to BeeSavy! Update your account settings below or <a href=''>start ".
                "shopping</a> now!";
        }
        if ($notice==2 && $data['payment_method']) {
            $data['notice'] = "Verify your payment method below and then click the REQUEST A PAYMENT button on the right.";
        } elseif ($notice==2) {
            $data['notice'] = "Select your payment method below and then click the REQUEST A PAYMENT button on the right.";
        }
        if ($notice==3) {
            $data['notice'] = "Your cash back is being processed and should arrive in 10-14 days.";
        }
        if ($notice==4) {
            $data['success'] = "Your payment is being processed";
        }
        if ($notice==5) {
            $data['errors'][] = array('message'=>"There was a problem processing your payment, please check that you have selected and filled out a payment method");
        }
        if ($notice==6) {
            $data['errors'][] = array('message'=>"You must have $10 in available cash back and a confirmed purchase to request a payment.");
        }

        $container = silex();
        $data['charities'] = $container['orm.em']->getRepository('App\Entity\Charity')->findBy([], ['name' => 'ASC']);
	$categories = cached_categories();
        $data['categories'] = $categories;
		
        $this->parser->parse('account/account', $data);
    }

    public function payment()
    {
        $data = $this->__get_header();
        $payment = $this->beesavy->processPayment($this->user_id);

        if ($payment === Beesavy::PAYMENT_INSUFFICIENT_CASHBACK) {
            redirect("/account/index/0/6/");
        } elseif($payment === Beesavy::PAYMENT_MISSING_DATA) {
            redirect("/account/index/0/2/");
        } elseif($payment === Beesavy::PAYMENT_REQUEST_FAILURE) {
            redirect("/account/index/0/5/");
        } elseif ($payment instanceof App\Entity\Payment) {
            $data = [
                'user_id' => $payment->getUser()->getId(),
                'email' => $payment->getUser()->getEmail(),
                'date' => $payment->getRequestedAt()->format('m/d/Y'),
                'amount' => number_format($payment->getAmount(), 2),
            ];
            $subject = sprintf('[Payment Requested] %s', $payment->getUser()->getEmail());
            $message = $this->parser->parse('email/paymentreqt', $data, true);
            $to = 'help@beesavy.com';
            $this->emailsender->send($to, $subject,$message);
			
            redirect('/account/index/0/4');
        }
    }
		
		
    public function joinnow()
    {
	

	
        $data = $this->blocks->getBlocks();
		
		
        $data['email'] = $this->input->get('email');
        $data['referral'] = $this->input->get('referral');
        if (!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }

        if ($this->input->get('errors')) {
            $data['codes'] = explode(",",$this->input->get('errors'));
        } else {
            $data['codes'] = array();
        }
        $data['errors'] = $this->code->get_errors($data['codes']);
        $this->parser->parse('/home/joinnow', $data);
    }
		

    public function register()
    {
		

        $email = $this->input->post("email");
        $referral = $this->input->post("referral");
        $porig = $this->input->post("password");
        $pass  = User::passwordHash($this->input->post("password"));
        $passC = User::passwordHash($this->input->post("password_confirm"));
		

 		$data = $this->user->checklogin($email);
		
		 if($data['status']=='inactive')
		 {
			$abc['statussign']='inactive';
			$error= array('code'=>20, 'user'=>$email);
			 $this->load->view('home/joinlogin',$abc);
		}
		else {
			

        #Error check
        $errors = array();
        if(strlen($this->input->post("password"))<6)
            $errors[] = $this->code->get_code('invalid_password');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)==FALSE) {
            $errors[] = $this->code->get_code('invalid_email');
            $email = "";
        }
        if($pass != $passC)
            $errors[] = $this->code->get_code('password_mismatch');
        $data= $this->user->onreffral();


       if($data['referral_status']==1) {

        if (empty($referral) || !$rid = $this->user->check_referral($referral)) {
            $errors[] = $this->code->get_code('invalid_referral');
        }
		
        }

            $refcode=trim($referral);
        if ($rid == 1) {
            $rid = 0;
        }

        if (empty($errors)) {
            $error = $this->user->add_user($email, $rid, $pass,$refcode, $data['referral_status']);
            if ($error) {
                //return;
                $errors[] = $this->code->get_code('fail');
            }
        }
        #Show page
        if (empty($errors)) {
            $this->user->login($email,$pass);
            $data = array('email'=>$email);
            $msg = $this->parser->parse('email/join', $data, true);


              //print_r($msg); exit;     


			$this->emailsender->send($email,'BeeSavy - Welcome to BeeSavy!',$msg);
            redirect('/account/index/0/1?email='.$email);
        } else {
            $error_str = implode(",",$errors);
            redirect("/main/joinnow?email=$email&referral=$referral&errors=$error_str");
        }
		}
    }

    public function logout()
    {
        $this->user->logout();
        redirect("");
    }

    public function forgot()
    {
        $email = $this->input->post('email');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                if ($this->user->last_password_reset($email, '15 minutes ago')) {
                    $newPassword = $this->user->reset_password($email);
                    if (false !== $newPassword) {
                        $data = array('email' => $email, 'password' => $newPassword);
                        $msg = $this->parser->parse('email/newpassword', $data, True);
                        $txtmsg = $this->parser->parse('email/newpasswordt', $data, True);
						$this->emailsender->send($data['email'],'BeeSavy - New password request',$msg);
                        redirect("/main/forgot/1/$email");
                        return;
                    }
                } else {
                    redirect("/main/forgot?errors=26");
                    return;
                }
            } catch (Exception $e) {
                redirect("/main/forgot?errors=24");
                return;
            }
        }
        redirect("/main/forgot?errors=24");
    }

    public function login()
    { 
        $data = $this->blocks->getBlocks();

        $email = $this->input->post('email');
        $password = User::passwordHash($this->input->post('password'));
		
		 $data = $this->user->checklogin($email);
		
		 if($data['status']=='inactive')
		 {
			$error= array('code'=>20, 'user'=>$email);

            $this->parser->parse('/home/joinlogin', $data);


			 //$this->load->view('home/joinlogin',$data);
		}
		else {
			
        	$error = $this->user->login($email,$password);
			
		}
		
        if ($error) {



            $user = urlencode($error['user']);
            $code = $error['code'];
                   redirect("main/forgotp");
                   // $this->parser->parse('/home/forgot', $data);

            //redirect("main/forgot");
         
        } else {
        redirect("");
        }
    }

    public function edit_payment()
    {
        $method = $this->input->post('pmethod');
        if (!empty($method)) {
            $method = "__$method";
            $this->$method();
        }
        $this->index(1);
    }

    public function __check()
    {
        $fname = $this->input->post('firstName');
        $lname = $this->input->post('lastName');
        $addr = $this->input->post('street');
        $city = $this->input->post('city');
        $state =$this->input->post('state');
        $zip =$this->input->post('zip');
        if (!($fname && $lname && $addr && $city && $state && $zip)) {
            $this->error[] = $this->code->get_code('check_error');
        } else {
            $this->user->set_setting('payment_method', 'CHECK');
            $this->user->set_setting('first_name', $fname);
            $this->user->set_setting('last_name', $lname);
            $this->user->set_setting('address', $addr);
            $this->user->set_setting('city', $city);
            $this->user->set_setting('state', $state);
            $this->user->set_setting('zip', $zip);
        }
    }

    public function __paypal()
    {
        $email =$this->input->post('paypalEmail');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)==FALSE) {
            $this->error[] = $this->code->get_code('paypal_error');
        } else {
            $this->user->set_setting('paypal_email', $email);
            $this->user->set_setting('payment_method', 'PAYPAL');
        }
    }

    public function __charity()
    {
        $charity =$this->input->post('charity_id');
        if ($charity) {
            $this->user->set_setting('payment_method', 'CHARITY');
            $this->user->set_setting('charity_id', $charity);
        } else {
            $this->error[] = $this->code->get_code('charity_error');
        }
    }

    public function set_alias()
    {
        $new =$this->input->post('email');
        $conf=$this->input->post('email_confirm');
        if (strlen($new)<3 || preg_match("/\D/", $new)==0) {
            $this->error[] = $this->code->get_code('alias_format');
        } elseif ($new==$conf) {
            if (empty($this->error)) {
                $e = $this->user->set_setting('alias', $new);
                if ($e) {
                $this->error[] = $this->code->get_code($e);
                }
            }
        } else {
            $this->error[] = $this->code->get_code('alias_mismatch');
        }

        $this->index(1);
    }
/*	public function flogin()
		{
		 $this->load->library('facebook');
			$data['user'] = array();
	
			
			if ($this->facebook->is_authenticated())
			{
				
				
				$user = $this->facebook->request('get', '/me?fields=id,name,email');
				if (!isset($user['error']))
				{
					$data['user'] = $user;
				}
	
			}
			
		$this->load->view('home/joinnow', $data);
	} */
	
    public function set_email()
    {
        $new =$this->input->post('email');
        $to =$this->input->post('oldemail');
        $conf=$this->input->post('email_confirm');
        if (filter_var($new, FILTER_VALIDATE_EMAIL)==FALSE) {
            $this->error[] = $this->code->get_code('invalid_email');
        } else {
            if ($new==$conf) {
                $e = $this->user->set_setting('email', $new);



                if($e!='in_use') {
                  

                $msg = $this->parser->parse('email/setemail', $data, true);
                //$msg = $this->parser->parse('email/setreferal', $data, true);
                

              //print_r($msg); exit;


                $this->emailsender->send($to,'BeeSavy - Change email!',$msg);
                //$this->emailsender->send($to,'BeeSavy - Change email!',$msg);

                }


                if ($e) {
                $this->error[] = $this->code->get_code($e);
                }
            } else {
                $this->error[] = $this->code->get_code('email_mismatch');;
            }
        }
        $this->index(1);
    }

    public function set_password()
    {
         $current = User::passwordHash($this->input->post('password_current'));
         $to = $this->input->post('passemail');
        
         $new = User::passwordHash($this->input->post('password_new'));
        $conf= User::passwordHash($this->input->post('password_confirm'));
        $info = $this->user->info();
        if ($current !== $info['password']) {
			
            $this->error[] = $this->code->get_code('invalid_password');
        } elseif (strlen($this->input->post("password_new"))<6) {
			
            $this->error[] = $this->code->get_code('invalid_password');
        } elseif ($new !== $conf) {
			
            $this->error[] = $this->code->get_code('password_mismatch');
        } else {
			
            $this->user->set_password($new, $current);


                $subject = 'Change password';
                $message = 'Your password has been changed successfully  ';
                $this->emailsender->send($to, $subject,$message);


        }
        $this->index(1);
    }

    public function set_setting()
    {

         $setting='facebook_auto';
         $value=1;
        if ($setting == "facebook_auto" && $value) {

            $rurai = "http://dev.nsol.sg/projects/beesavy_new/legacy/public/account/add_facebook";
            $url = $this->facebook->request_permissions( $rurai, $this->user_id);
            if ($url) {
                redirect($url);
            }
        }


        $this->user->set_setting($setting, $value);
        $this->index();

    }

    public function sett_setting()
    {

         $setting='twitter_auto';
         $value=1;
        if ($setting == "twitter_auto" && $value) {

         // echo base_url(); exit();
         // http://dev.nsol.sg/projects/beesavy_new/legacy/public/
        $bas_ur="https://dev.nsol.sg/projects/beesavy_new/legacy/public/account/add_twitter";
                      

            $url = $this->twitter->request_permissions($bas_ur, $this->user_id);
            if ($url) {
                redirect($url);
            }
        }

        $this->user->set_setting($setting, $value);
        $this->index();

    }

    public function add_facebook()
    {

        $clientid = "117040755037895";
        $clientsecret = '04ced89742cf2754a630775cdc956081';
        $code = $this->input->get('code');
        if($this->input->get('code')){


            $ruri = "http://dev.nsol.sg/projects/beesavy_new/legacy/public/account/add_facebook";
            $ruri = urlencode($ruri);
            $url = "https://graph.facebook.com/oauth/access_token?client_id=$clientid&redirect_uri=".$ruri."&client_secret=$clientsecret&code=$code";

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TRUE);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);


            $data = curl_exec($ch);


           
            $arr = array();
            parse_str($data, $arr);
           $retunface=json_decode($data);
          
              
      }  if($retunface->access_token){
            $uid= $this->user_id;

            $this->db->where('uid', $uid);
            $this->db->update('user', array('fb_access_token'=>$retunface->access_token));
            $success= True;

        }else{
            $success= False;
        }


        if (!$success) {
            

            $error = '5';
            redirect("/account");
        } else {
            


            $setting = "facebook_auto";
            $value = 1;
            $this->user->set_setting($setting, $value);
            redirect("/account");
        }
    }

    public function add_twitter()
    {
        

        $success = $this->twitter->get_access_token($this->user_id);
        if (!$success) {
            $error = '5';
            redirect("/account");
        } else {
            $setting = "twitter_auto";
            $value = 1;
            $this->user->set_setting($setting, $value);
            redirect("/account");
        }
    }

    public function set_email_setting()
    {

        $send_updates = $this->input->post('send_updates');
        $send_reminders = $this->input->post('send_reminders');
        $this->user->set_setting("send_reminders", $send_reminders);
        $this->user->set_setting("send_updates", $send_updates);
        $this->index(1);
    }
	public function invite_multiple_friends(){
	
		$emails = $this->input->post('emails');
	
		$link = $this->input->post('link');
			if (empty($emails[0]) AND empty($emails[1]) AND empty($emails[2])) {
				
				echo 0;
			}else{
				
			foreach($emails as $key => $email){
				$subject = 'Beesavy Invitation';
                //$message = 'Link: '.$link;
				$msg = $this->parser->parse('email/setreferal', $data, true);
				$to = $emails[$key];
				$this->emailsender->send($to, $subject,$msg);
			}
			
				echo 1;
                return;
			}
	}
}
