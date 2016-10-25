<?php
/**
 * Transfer (click out) controller
 */
class Transfer extends Controller
{
    protected $container;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->model('admin');
        $this->load->helper('url_helper');
        $this->load->model('emailer');
        $is_user = $this->user->login_status();
        if ($is_user) {
            $this->user_id = $this->user->get_field('id');
        } else {
            $this->user_id = $this->admin->getDefault();
        }
        $this->load->helper('bridge');
        $this->container = silex();
    }

    public function _remap()
    {
        $type = $this->uri->segment(2);
        if ($type=="login") {
            $this->login();
        } elseif ($type=="register") {
            $this->register();
        } else {
            $id = $this->uri->segment(3);
            $logged_in = $this->user->login_status();
            $skip = $this->uri->segment(4);
            if ($skip || $logged_in) {
                $this->store($id, $skip);
            } else {
                $this->guest($id);
            }
        }
    }

    public function login()
    {
        $type = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        $email = $this->input->post('email');
        $pass = sha1($this->input->post('password'));
        $error = $this->user->login($email, $pass);
        if ($error) {
            $code = $error['code'];
            redirect("/transfer/$type/$id?codes=$code");
        } else {
            redirect("/transfer/$type/$id");
        }
    }

    public function register()
    {
        $this->load->helper('string');
        $type = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        $email = $this->input->post("email");
        $referral = $this->input->post("referral");
        $password = random_string('alnum', 8);
        $pass = sha1($password);

        #Error check
        $errors = array();
        if (filter_var($email, FILTER_VALIDATE_EMAIL)==FALSE) {
            $errors[] = $this->code->get_code('invalid_email');
            $email = "";
        }
        if(empty($referral) || !$rid = $this->user->check_referral($referral))
            $errors[] = $this->code->get_code('invalid_referral');
        if (empty($errors)) {
            $error = $this->user->add_user($email, $rid, $pass);
            if($error)
                $errors[] = $this->code->get_code('general_login');
        }
        #Show page
        if (empty($errors)) {
            $this->user->login($email,$pass);
            $data = array('email'=>$email, 'password'=>$password);
            $msg = $this->parser->parse('email/joininfo', $data, True);
            $txtmsg = $this->parser->parse('email/joininfot', $data, True);
            $this->emailer->sendMessage($msg, $txtmsg, $data['email'], "BeeSavy - Welcome to BeeSavy");
            redirect("/transfer/$type/$id");
        } else {
            $error_str = implode(",",$errors);
            redirect("/transfer/$type/$id?codes=$error_str");
        }
    }

    public function guest($id)
    {
        $data = $this->getMerchantData($id);

        if ($data === null) {
            show_404();
        }

        $data['code'] = $this->input->get('codes');
        $data['codes'] = explode(",",$this->input->get('codes'));
        $data['errors'] = $this->code->get_errors($data['codes']);
        $data['type']= 'store';
        $data['type_id'] = $id;
        $data['referral'] = $this->db_session->userdata('referral');
        $this->parser->parse('transfer/guest', $data);
    }

    public function store($id, $skip = null)
    {
        $data = $this->getMerchantData($id);

        if ($data === null) {
            show_404();
        }

        if ($skip === 'out') {
            redirect($data['url']);
        }

        $this->parser->parse('transfer/store', $data);
    }

    protected function getMerchantData($id)
    {
        $merchant = $this->container['orm.em']->getRepository('App\Entity\Merchant')->getActiveMerchant($id);

        if ($merchant === null) {
            return;
        }

        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();
        $subid = create_subid($this->user_id);

        return current(result_merchants([$merchant], $rate, $subid));
    }
}
