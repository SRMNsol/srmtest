<?php
/**
 */
class Transfer extends Controller
{
    protected $container;

    public function Transfer()
    {
        parent::Controller();
        $this->load->library('beesavy');
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
        $this->load->helper('escape');
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
                $this->$type($id);
            } else {
                $this->guest($type, $id);
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
        if(!$rid = $this->user->check_referral($referral))
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

    public function guest($type, $id)
    {
        if ($type == "store") {
            $data = $this->getMerchantData($id);
        } elseif ($type == "product") {
            $data = $this->getProductData($id);
        } elseif ($type == "coupon") {
            $data = $this->getDealData($id);
        } elseif ($type == "deal") {
            $data = $this->getDealData($id);
        } else {
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

    public function store($id)
    {
        $store = $this->getMerchantData($id);
        $store['cookie_url'] = $store['url'];
        $store['destination_url'] = $store['cookie_url'];
        $this->parser->parse('transfer/store', $store);
    }

    public function product($id)
    {
        $product = $this->getProductData($id);
        $product['cookie_url'] = $product['url'];
        $product['destination_url'] = $product['url'];
        $this->parser->parse('transfer/product', $product);
    }

    public function coupon($id)
    {
        $coupon = $this->getDealData($id);
        $coupon['cookie_url'] = $coupon['url'];
        $coupon['destination_url'] = $coupon['url'];
        $this->parser->parse('transfer/coupon', $coupon);
    }

    public function deal($id)
    {
        $deal = $this->getDealData($id);
        $deal['cookie_url'] = $deal['url'];
        $deal['destination_url'] = $deal['url'];
        $deal['final_amount'] = 0.00;
        $this->parser->parse('transfer/deal', $deal);
    }

    protected function getProductData($id)
    {
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];

        list($productGroupId, $productId) = explode('-', $id);
        $params = [];
        if (strpos($productGroupId, '0') === 0) {
            $params['product_id'] = $productId;
        } else {
            $params['product_group_id'] = $productGroupId;
        }

        $product = current(array_filter(comparison_result($client->findProducts($catalogs['all_stores'], null, $params)), function ($item) use ($productId) {
            if ($item['id'] == $productId) {
                return $item;
            }
        }));

        return $product;
    }

    protected function getMerchantData($id)
    {
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];

        $merchant = current(serialize_merchants($client->findMerchants($catalogs['all_stores'], ['merchant_id' => $id])->getMerchantDatas()));

        return $merchant;
    }

    protected function getDealData($id)
    {
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];

        list($dealId, $merchantId) = explode('-', $id);

        $deal = current(serialize_deals($client->findMerchants($catalogs['all_stores'], ['merchant_id' => $merchantId])->getDeals()->filter(function ($deal) use ($dealId) {
            if ($deal->getId() == $dealId) {
                return $deal;
            }
        })));

        return $deal;
    }
}
