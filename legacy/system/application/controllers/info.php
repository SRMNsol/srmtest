<?php
/**
 * Help pages controller
 */
class Info extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('beesavy');
        
        $this->load->library('EmailSender');
        $this->data = array();
         $this->load->model('user');
       $info = end($this->uri->segments);
        $this->data = $this->blocks->getBlocks();
        $this->data['side_nav'] = $this->parser->parse('blocks/side_bar', ['info' => $info], true);
		$categories = cached_categories();
        $this->data['categories'] = $categories;
        $this->load->helper('bridge');
        $this->container = silex();
		session_start();
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

        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();
        $merchants = $this->container['orm.em']->getRepository('App\Entity\Merchant')->getActiveMerchants();
        $stores = result_merchants($merchants, $rate);

        $this->load->library('recaptcha');
        $this->data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
        $this->data['store_list'] = $stores;
        $this->parser->parse('info/contact', $this->data);
    }

    public function faq()
    {
		$this->data['faqs']= $this->user->mfaq();
        $this->load->view('info/faq', $this->data);
    }
    public function checkpopup()
    {
       
        $data['popupstatus']= $this->user->popupstatus(); 
        return $data['popupstatus'];         
    }

    public function notfound()
    {
		
        $this->parser->parse('info/notfound', $this->data);
    }
    public function privacy()
    {
               $this->data['privacy']= $this->user->mprivacy();
        $this->load->view('info/privacy', $this->data);

}
    public function aboutus()
    {
       $this->data['about']= $this->user->mabout();
        $this->load->view('info/aboutus', $this->data);
    }

    public function how()
    {
        $this->data['how']= $this->user->mhelp();
        $this->load->view('info/how', $this->data);
    }


    public function terms()
    {

         $this->data['terms']= $this->user->mterms();
        $this->load->view('info/terms', $this->data);
       
    }

    public function lm_cashback()
    {
        $this->data['cashback']= $this->user->mcashback();
        $this->load->view('info/lm_cashback', $this->data);
    }

    public function lm_compare()
    {
        $this->data['compare']= $this->user->mcompare();
        $this->load->view('info/lm_compare', $this->data);
    }

    public function lm_guide()
    {
        $this->data['guide']= $this->user->mguide();
        $this->load->view('info/lm_guide', $this->data);
    }

    public function lm_join()
    {
        $this->data['join']= $this->user->mjoin();
        $this->load->view('info/lm_join', $this->data);
    }

    public function lm_overview()
    {
         $this->data['overview']= $this->user->moverview();
        $this->load->view('info/lm_overview', $this->data);
       
    }



    public function lm_referral()
    {
        $this->data['referel']= $this->user->mreferel();
        $this->load->view('info/lm_referral', $this->data);
    }

    public function lm_shop()
    {
        $this->parser->parse('info/lm_shop', $this->data);
    }

    public function makehome()
    {
        $this->parser->parse('info/makehome', array());
    }



  public function captcha() {
				
				$code=rand(1000,9999);
				$_SESSION["code"]=$code;
				$im = imagecreatetruecolor(50, 24);
				$bg = imagecolorallocate($im, 22, 86, 165);
				$fg = imagecolorallocate($im, 255, 255, 255);
				imagefill($im, 0, 0, $bg);
				imagestring($im, 5, 5, 5,  $code, $fg);
				header("Cache-Control: no-cache, must-revalidate");
				header('Content-type: image/png');
				imagepng($im);
				imagedestroy($im);
  }

    public function contact_submit()
    {

      //  $this->recaptcha->recaptcha_check_answer($_SERVER['REMOTE_ADDR'],$this->input->post('recaptcha_challenge_field'),$this->input->post('recaptcha_response_field'));
        if(isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"]) {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');
            $data = [
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message
            ];
            if ($subject === "Where is My Cash Back?") {
				
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
                $msg = $this->parser->parse('email/missing_cashback', $data, true);
                $tmsg = $this->parser->parse('email/missing_cashback', $data, true);
                $this->emailsender->send($email,"Contact us: $subject",$msg);
                $this->emailsender->send("help@beesavy.com","Contact us: $subject",$msg);
            } else {
				
                $msg = $this->parser->parse('email/incomplete', $data, True);
                $tmsg = $this->parser->parse('email/incompletet', $data, True);
                if ($subject == "Biz dev/advertising/media") {
					
                    $this->emailsender->send($email,"Contact us: $subject",$msg);
                    $this->emailsender->send("rhoner@beesavy.com", "Contact us: $subject",$msg);
                } else {
					
                    $this->emailsender->send($email,"Contact us: $subject",$msg);
				
                    $this->emailsender->send("help@beesavy.com", "Contact us: $subject",$msg);
					
                }
            }
			//echo 'ddddddddd'; exit;
		//	$data['msg']='success';
			 //$this->load->view('info/contact', $data);
            redirect("info/contact?success=1");
        } else {
			//$data['msg']='error';
			 //  $this->load->view('info/contact', $data);
            redirect("info/contact?error=1");
        }
    }
}
