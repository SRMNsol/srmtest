<?php
/**
 */
class Info extends Controller
{
    public function Info()
    {
        parent::Controller();
        $this->load->library('beesavy');
        $this->load->model('emailer');
        $this->data = array();
        $info = end($this->uri->segments);
        $this->data = $this->blocks->getBlocks();
        $this->data['side_nav'] = $this->parser->parse('blocks/side_bar',array('info'=>$info), TRUE);

        $this->load->helper('bridge');
        $this->load->helper('escape');
        $this->container = silex();
    }

    public function index()
    {
    }

    public function contact()
    {
        $success = $this->input->get('success');
        $this->data['success'] = $success;
        if ($success) {
            $this->data['success'] = "Your message has been sent";
        }

        $error = $this->input->get('error');
        $this->data['error'] = $error;
        if ($error == 1) {
            $this->data['error'] = "Incorrect Captcha - Please Try Again";
        }
        $store_list = $this->_get_list();
        $this->load->library('recaptcha');
        $this->data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
        $this->data['store_list'] = $store_list;
        $this->parser->parse('info/contact', $this->data);
    }

    public function j06242012_contact()
    {
        $success = $this->input->get('success');
            $this->data['success'] = $success;
        if ($success) {
            $this->data['success'] = "Your message has been sent";
        }
        $store_list = $this->_get_list();
        $this->data['store_list'] = $store_list;
        $this->parser->parse('info/j06242012_contact', $this->data);
    }

    public function faq()
    {
        $this->parser->parse('info/faq', $this->data);
    }
    public function privacy()
    {
        $this->parser->parse('info/privacy', $this->data);
    }
    public function aboutus()
    {
        $this->parser->parse('info/aboutus', $this->data);
    }
    public function how()
    {
        $this->parser->parse('info/how', $this->data);
    }
    public function terms()
    {
        $this->parser->parse('info/terms', $this->data);
    }
    public function lm_cashback()
    {
        $this->parser->parse('info/lm_cashback', $this->data);
    }
    public function lm_compare()
    {
        $this->parser->parse('info/lm_compare', $this->data);
    }
    public function lm_coupon()
    {
        $this->parser->parse('info/lm_coupon', $this->data);
    }
    public function lm_join()
    {
        $this->parser->parse('info/lm_join', $this->data);
    }
    public function lm_overview()
    {
        $this->parser->parse('info/lm_overview', $this->data);
    }
    public function lm_referral()
    {
        $this->parser->parse('info/lm_referral', $this->data);
    }
    public function lm_shop()
    {
        $this->parser->parse('info/lm_shop', $this->data);
    }
    public function makehome()
    {
        $this->parser->parse('info/makehome', array());
    }
    public function contact_submit()
    {
        $this->load->library('recaptcha');

        $this->recaptcha->recaptcha_check_answer($_SERVER['REMOTE_ADDR'],$this->input->post('recaptcha_challenge_field'),$this->input->post('recaptcha_response_field'));
        if ($this->recaptcha->is_valid) {
            $name = $this->input->post('name');
            $email =$this->input->post('email');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');
            $data = array(
                'name'=>$name,
                'email'=>$email,
                'subject'=>$subject,
                'message'=>$message
            );
            if ($subject == "Where is My Cash Back?") {
                $order_num = $this->input->post('order_number');
                $store = $this->input->post('store_name');
                $subtotal = $this->input->post('purchase_subtotal');
                $month = $this->input->post('month');
                $day = $this->input->post('day');
                $year = $this->input->post('year');
                $purchase_date = "$month $day, $year";
                $data['purchase_date'] = $purchase_date;
                $data['subtotal'] = $subtotal;
                $data['store'] = $store;
                $data['order_num'] = $order_num;
                $msg = $this->parser->parse('email/missing_cashback', $data, True);
                $tmsg = $this->parser->parse('email/missing_cashback', $data, True);
                $this->emailer->sendMessage($msg,$tmsg, $email,"Contact us: $subject");
                $this->emailer->sendMessage($msg,$tmsg, "help@beesavy.com","Contact us: $subject");
            } else {
                $msg = $this->parser->parse('email/incomplete', $data, True);
                $tmsg = $this->parser->parse('email/incompletet', $data, True);
                if ($subject == "Biz dev/advertising/media") {
                $this->emailer->sendMessage($msg,$tmsg, $email,"Contact us: $subject");
                $this->emailer->sendMessage($msg,$tmsg, "rhoner@beesavy.com","Contact us: $subject");
                } else {
                $this->emailer->sendMessage($msg,$tmsg, $email,"Contact us: $subject");
                $this->emailer->sendMessage($msg,$tmsg, "help@beesavy.com", "Contact us: $subject");
                }
            }
            redirect("info/contact?success=1");
        } else {
            redirect("info/contact?error=1");
        }
    }
    public function _get_list()
    {
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();

        $merchants = $client
            ->findMerchants($catalogs['all_stores'])
            ->getMerchants()
            ->sortByMerchantName();
        $stores = result_merchants($merchants, $rate);

        return $stores;
    }
}
