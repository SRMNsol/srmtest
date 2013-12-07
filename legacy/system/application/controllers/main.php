<?php
/**
 */
class Main extends Controller
{
    protected $container;

    public function Main()
    {
        parent::Controller();
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
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();
        $subid = create_subid($this->user_id);

        $data['stores'] = random_slice(result_merchants($client->findMerchants($catalogs['all_stores'])->getMerchants(), $rate, $subid), $num_stores);
        $data['coupons'] = random_slice(result_deals($client->findDeals($catalogs['hot_coupons'])->getDeals(), $rate, $subid), 5);
        $data['deals'] = random_slice(result_deals($client->findDeals($catalogs['hot_deals'])->getDeals(), $rate, $subid), 2);
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

    public function deal()
    {
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();
        $subid = create_subid($this->user_id);

        $data = $this->blocks->getBlocks();
        $data['deals'] = random_slice(result_deals($client->findDeals($catalogs['hot_deals'])->getDeals(), $rate, $subid), 24);
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
