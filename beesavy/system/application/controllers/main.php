<?php
/**
 */
class Main extends Controller
{
    protected $container;

    public function Main()
    {
        parent::Controller();
        $this->load->library('beesavy');
        $this->load->model('user');
        $this->load->helper('bridge');
        $this->load->helper('escape');
        $this->container = silex();
    }

    public function index()
    {
        $home = $this->user->get_home(0);
        $num_stores = $home['vars']['stores'];
        $num_deals = $home['vars']['deals'];

        $data = $this->blocks->getBlocks();
        $data = array_merge($home['vars'], $data);

        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];

        $data['stores'] = random_slice(serialize_merchants($client->getMerchantsAndDeals($catalogs['all_stores'])), $num_stores);
        $data['coupons'] = random_slice(serialize_deals($client->findDeals($catalogs['hot_coupons'])->getDeals()), 5);
        $data['deals'] = random_slice(serialize_deals($client->findDeals($catalogs['hot_deals'])->getDeals()), 2);
        $data['home'] = $home['vars'];
        $data['referral'] = $this->input->get('referral');
        if(!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }
        if (isset($data['id'])) {
            $data['user_id'] = $data['id'];
            unset($data['id']);
        }
        $this->parser->parse($home['page'], $data);
    }

    public function test()
    {
        $id = 86558;
        $this->beesavy->processPayment($id);
    }

    public function deal()
    {
        $deals = $this->beesavy->get_daily_rand(24);
        $this->beesavy->abreviate($deals, 'name', 25);
        $data = $this->blocks->getBlocks();
        $data['deals'] = $deals;
        $this->parser->parse('/home/deal', $data);
    }

    public function signin()
    {
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

    public function joinnow()
    {
        $data = $this->blocks->getBlocks();
        $data['email'] = $this->input->get('email');
        $data['referral'] = $this->input->get('referral');
        if(!$data['referral']) {
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

    public function forgot($success= False, $email = "")
    {
        if ($this->user->login_status()) {
            redirect('');
        }
        $data = $this->blocks->getBlocks();
        if ($success) {
            $data['success'] = "An email has been sent to $email";
        }
        if ($this->input->get('errors')) {
            $data['codes'] = explode(",",$this->input->get('errors'));
        } else {
            $data['codes'] = array();
        }
        $data['errors'] = $this->code->get_errors($data['codes']);
        $data['referral'] = $this->input->get('referral');
        if(!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }
        $this->parser->parse('/home/forgot', $data);
    }
}
