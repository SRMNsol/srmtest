<?php
/**
 */
class Transfer extends Controller {

	function Transfer()	{
		parent::Controller();
        $this->load->library('beesavy');
        $this->load->model('user');
        $this->load->model('admin');
        $this->load->helper('url_helper');
        $this->load->model('emailer');
        $is_user = $this->user->login_status();
        if($is_user){
            $this->user_id = $this->user->get_field('id');
        }else{
            $this->user_id = $this->admin->getDefault();
        }
	}

    public function _remap(){
        $type = $this->uri->segment(2);
        if($type=="login"){
            $this->login();
        }elseif($type=="register"){
            $this->register();
        }else{
            $id = $this->uri->segment(3);
            $logged_in = $this->user->login_status();
            $skip = $this->uri->segment(4);
            if($skip || $logged_in){
                $this->$type($id);
            }else{
                $this->guest($type, $id);
            }
        }
    }

    function login(){
        $type = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        $email = $this->input->post('email');
        $pass = sha1($this->input->post('password'));
        $error = $this->user->login($email, $pass);
        if($error){
            $code = $error['code'];
            redirect("/transfer/$type/$id?codes=$code");
        }else{
            redirect("/transfer/$type/$id");
        }
    }
    function register(){
        $this->load->helper('string');
        $type = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        $email = $this->input->post("email");
        $referral = $this->input->post("referral");
        $password = random_string('alnum', 8);
        $pass = sha1($password);

        #Error check
        $errors = array();
        if(filter_var($email, FILTER_VALIDATE_EMAIL)==FALSE){
            $errors[] = $this->code->get_code('invalid_email');
            $email = "";
        }
        if(!$rid = $this->user->check_referral($referral))
            $errors[] = $this->code->get_code('invalid_referral');
        if(empty($errors)){
            $error = $this->user->add_user($email, $rid, $pass);
            if($error)
                $errors[] = $this->code->get_code('general_login');
        }
        #Show page
        if(empty($errors)){
            $this->user->login($email,$pass);
            $data = array('email'=>$email, 'password'=>$password);
            $msg = $this->parser->parse('email/joininfo', $data, True);
            $txtmsg = $this->parser->parse('email/joininfot', $data, True);
            $this->emailer->sendMessage($msg, $txtmsg, $data['email'], "BeeSavy - Welcome to BeeSavy");
            redirect("/transfer/$type/$id");
        }else{
            $error_str = implode(",",$errors);  
            redirect("/transfer/$type/$id?codes=$error_str");
        }
    }

    function guest($type, $id){
        if($type == "store"){
			$data = $this->cache->library('beesavy', 'getStore', array($id), 3600);
        }elseif($type == "product"){
			$data = $this->cache->library('beesavy', 'compareprices', array($id), 3600);
            $data = $data[0];
        }elseif($type == "coupon"){
			$data = $this->cache->library('beesavy', 'getCoupon', array($id), 3600);
        }elseif($type == "deal"){
			$data = $this->cache->library('beesavy', 'getDailyDeals', array($id), 3600);
        }else{
            show_404();
        }
        $data['code'] = $this->input->get('codes');
        $data['codes'] = explode(",",$this->input->get('codes'));
        $data['errors'] = $this->code->get_errors($data['codes']);
        $data['type']= $type;
        $data['type_id'] = $id;
            $data['referral'] = $this->db_session->userdata('referral');
        $this->parser->parse('transfer/guest', $data);

    }

    function store($id){
		$store = $this->cache->library('beesavy', 'getStore', array($id), 3600);
        $merchant_id = $store['id'];
        $store['cookie_url'] = $this->beesavy->click($merchant_id, $this->user_id, False);
        $store['destination_url'] = $store['cookie_url'];
        $this->parser->parse('transfer/store', $store);
    }
    function product($id){
		$products = $this->cache->library('beesavy', 'compareprices', array($id), 3600);
        $product = $products[0];
        $merchant_id = $product['merchant_id'];
        $product_id = $product['id'];
        $product['cookie_url'] = $this->beesavy->click($merchant_id, $this->user_id, $product_id);
        $product['destination_url'] = $product['product_url'];
        $this->parser->parse('transfer/product', $product);
    }
    function coupon($id){
		$coupon = $this->cache->library('beesavy', 'getCoupon', array($id), 3600);
        $merchant_id = $coupon['merchant_id'];
        $coupon['cookie_url'] = $this->beesavy->click($merchant_id, $this->user_id, False);
        $coupon['destination_url'] = $coupon['cookie_url'];
        $this->parser->parse('transfer/coupon', $coupon);
    }
    function deal($id){
		$deal = $this->cache->library('beesavy', 'getDailyDeals', array($id), 3600);
        $merchant_id = $deal['merchant_id'];
        $deal['cookie_url'] = $this->beesavy->click($merchant_id, $this->user_id, False);
        $deal['destination_url'] = $deal['product_url'];
        $deal['final_amount'] = number_format((float)$deal['final_amount']-(float)$deal['cashback_amount'], 2);
        $this->parser->parse('transfer/deal', $deal);
    }
}
?>
