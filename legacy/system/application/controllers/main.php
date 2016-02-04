<?php
/**
 * Homepage controller
 */
class Main extends Controller
{
    protected $container;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->helper('bridge');
        $this->container = silex();
    }

    public function index()
    {
        $home = $this->user->get_home(0);

        $data = $this->blocks->getBlocks();
        $data = array_merge($home['vars'], $data);

        if ($this->db_session->userdata('login')) {
            $data = array_merge(
                $this->defaultcache->library('beesavy', 'getUserStats', array($this->user->get_field('id')), 3600),
                $this->defaultcache->library('beesavy', 'getUser', array($this->user->get_field('id'),'', TRUE), 3600),
                $data
            );
        }

        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();
        $topStores = $this->container['orm.em']->getRepository('App\Entity\Merchant')->getTopStores();

        $data['stores'] = random_slice(result_merchants($topStores, $rate), 12);
        $data['home'] = $home['vars'];
        $data['referral'] = $this->input->get('referral');
        if (!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }
        if (isset($data['id'])) {
            $data['user_id'] = $data['id'];
            unset($data['id']);
        }
        $this->parser->parse($home['page'], $data);
    }

    public function signin()
    {
        $data = $this->blocks->getBlocks();
        $data['user'] = $this->input->get('user');
        $data['code'] = $this->input->get('code');
        $data['referral'] = $this->input->get('referral');
        $message = array();
        if (!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }
        if ($data['code']) {
            $message = $this->code->get_errors(array($data['code']));
        }
        $data['errors'] = $message;

        $this->parser->parse('/home/signin', $data);
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
        if (!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }
        $this->parser->parse('/home/forgot', $data);
    }
}
