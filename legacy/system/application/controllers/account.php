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
        $this->load->model('user');
        $this->load->model('code');
        $this->load->model('facebook');
        $this->load->model('twitter');
        $this->load->model('emailer');
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

    public function index($success = False, $notice=False, $error = "")
    {
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

        $this->parser->parse('account/account', $data);
    }

    public function payment()
    {
        $data = $this->__get_header();
        $status = $this->beesavy->processPayment($this->user_id);

        if ($status === Beesavy::PAYMENT_INSUFFICIENT_CASHBACK) {
            redirect("/account/index/0/6/");
        } elseif($status === Beesavy::PAYMENT_REQUEST_FAILURE) {
            redirect("/account/index/0/5/");
        } else {
            redirect('/account/index/0/4');
        }
    }

    public function register()
    {
        $email = $this->input->post("email");
        $referral = $this->input->post("referral");
        $porig = $this->input->post("password");
        $pass  = User::passwordHash($this->input->post("password"));
        $passC = User::passwordHash($this->input->post("password_confirm"));

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
        if (!$rid = $this->user->check_referral($referral)) {
            $errors[] = $this->code->get_code('invalid_referral');
        }
            if ($rid == 1) {
                $rid = 0;
            }
        if (empty($errors)) {
            $error = $this->user->add_user($email, $rid, $pass);
            if ($error) {
                //return;
                $errors[] = $this->code->get_code('fail');
            }
        }
        #Show page
        if (empty($errors)) {
            $this->user->login($email,$pass);
            $data = array('email'=>$email);
            $msg = $this->parser->parse('email/join', $data, True);
            $tmsg = $this->parser->parse('email/joint', $data, True);
            $this->emailer->sendMessage($msg, $tmsg, $data['email'], "BeeSavy - Welcome to BeeSavy!");
            redirect('/account/index/0/1');
        } else {
            $error_str = implode(",",$errors);
            redirect("/main/joinnow?email=$email&referral=$referral&errors=$error_str");
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

            $newPassword = $this->user->reset_password($email);
            if (false !== $newPassword) {
                $data = array('email' => $email, 'password' => $newPassword);
                $msg = $this->parser->parse('email/newpassword', $data, True);
                $txtmsg = $this->parser->parse('email/newpasswordt', $data, True);
                $this->emailer->sendMessage($msg, $txtmsg, $data['email'], "BeeSavy - New password request");
                redirect("/main/forgot/1/$email");

                return;
            } else {
                redirect("/main/forgot?errors=24");
            }
        }
        redirect("/main/forgot?errors=24");
    }

    public function login()
    {
        $email = $this->input->post('email');
        $password = User::passwordHash($this->input->post('password'));
        $error = $this->user->login($email,$password);
        if ($error) {
            $user = urlencode($error['user']);
            $code = $error['code'];
            redirect("/main/signin?user=$user&code=$code");
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

    public function set_email()
    {
        $new =$this->input->post('email');
        $conf=$this->input->post('email_confirm');
        if (filter_var($new, FILTER_VALIDATE_EMAIL)==FALSE) {
            $this->error[] = $this->code->get_code('invalid_email');
        } else {
            if ($new==$conf) {
                $e = $this->user->set_setting('email', $new);
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
        }
        $this->index(1);
    }

    public function set_setting()
    {
        $setting =$this->input->post('setting');
        $value =$this->input->post('value');

        if ($setting == "facebook_auto" && $value) {
            $url = $this->facebook->request_permissions(base_url()."account/add_facebook", $this->user_id);
            if ($url) {
                redirect($url);
            }
        }

        if ($setting == "twitter_auto" && $value) {
            $url = $this->twitter->request_permissions(base_url()."account/add_twitter", $this->user_id);
            if ($url) {
                redirect($url);
            }
        }

        $this->user->set_setting($setting, $value);
        $this->index();

    }

    public function add_facebook()
    {
        $success = $this->facebook->get_access_token($this->user_id);
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
}
