<?php
/**
 */
class Main extends Controller {

	function Main()	{
		parent::Controller();
        $this->load->library('beesavy');
        $this->load->model('user');
	}

    function index(){
        $hot_product = array();
        $home = $this->user->get_home(0);
        $num_stores = $home['vars']['stores'];
        $num_deals = $home['vars']['deals'];
		$store = $this->cache->library('beesavy', 'get_hot_stores_rand', array($num_stores), 3600);
		$deals = $this->cache->library('beesavy', 'get_daily_rand', array($num_deals), 1);
        $this->beesavy->abreviate($deals, 'name', 25);
		$coupon = $this->cache->library('beesavy', 'get_hot_coupons', array(5), 3600);
        $deal_keys = array('deal_first', 'deal_second', 'deal_third');
        $i = 0;
        $data = $this->blocks->getBlocks();
        foreach($deal_keys as $index=>$key){
            if(array_key_exists($index, $deals)){
                $data[$key] = array($deals[$index]);
            }else{
                $data[$key] = array();
            }
        }
        $data = array_merge($home['vars'], $data);
        $this->beesavy->abreviate($coupon, 'name', 20);
        $data['stores'] = $store['stores'];
        $data['coupons'] = $coupon;
        $data['home'] = $home['vars'];
        $data['referral'] = $this->input->get('referral');
        if(!$data['referral'])
            $data['referral'] = $this->db_session->userdata('referral');
        if(isset($data['id'])){
        $data['user_id'] = $data['id'];
        unset($data['id']);
        }
        $this->parser->parse($home['page'], $data);
    }
    function test(){
        $id = 86558;
        $this->beesavy->processPayment($id);
    }

    function deal(){
        $deals = $this->beesavy->get_daily_rand(24);
        $this->beesavy->abreviate($deals, 'name', 25);
        $data = $this->blocks->getBlocks();
        $data['deals'] = $deals;
        $this->parser->parse('/home/deal', $data);
    }
    function signin(){
        $data = $this->blocks->getBlocks();
        $data['user'] = $this->input->get('user');
        $data['code'] = $this->input->get('code');
        $data['referral'] = $this->input->get('referral');
        $message = array();
        if(!$data['referral'])
            $data['referral'] = $this->db_session->userdata('referral');
        if($data['code'])
            $message = $this->code->get_errors(array($data['code']));
        $data['errors'] = $message;

        $this->parser->parse('/home/signin', $data);
    }
    function joinnow(){
        $data = $this->blocks->getBlocks();
        $data['email'] = $this->input->get('email');
        $data['referral'] = $this->input->get('referral');
        if(!$data['referral'])
            $data['referral'] = $this->db_session->userdata('referral');
        if($this->input->get('errors')){
            $data['codes'] = explode(",",$this->input->get('errors'));
        }else{
            $data['codes'] = array();
        }
        $data['errors'] = $this->code->get_errors($data['codes']);
        $this->parser->parse('/home/joinnow', $data);
    }
    function forgot($success= False, $email = ""){
        if($this->user->login_status()){
            redirect('');
        }
        $data = $this->blocks->getBlocks();
        if($success){
            $data['success'] = "An email has been sent to $email";
        }
        if($this->input->get('errors')){
            $data['codes'] = explode(",",$this->input->get('errors'));
        }else{
            $data['codes'] = array();
        }
        $data['errors'] = $this->code->get_errors($data['codes']);
        $data['referral'] = $this->input->get('referral');
        if(!$data['referral'])
            $data['referral'] = $this->db_session->userdata('referral');
        $this->parser->parse('/home/forgot', $data);
    }
}
?>
