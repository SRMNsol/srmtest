<?php
/**
 */
class Social extends Controller
{
    public function Social()
    {
        parent::Controller();
        $this->load->library('beesavy');
        $this->load->model('refer');
        $this->load->model('user');
        $this->id = $this->user->get_field('id');
    }

    public function store($type, $id)
    {
        $store =  $this->cache->library('beesavy', 'getStore', array($id), 3600);
        $image = $store['logo_thumb'];
        $title = "Earn ".$store['cashback_text']." cash back at ".$store['name'];
        $description = $store['description'];
        $link = $store['link'];
        $id = $this->refer->createReferral($link, $this->id);
        $rurl = base_url()."refer/r/$id";

        //Make message for specific plugin
        $redirect = $this->$type($title, $description, $this->id, $image, $rurl);
        if($type!="email")
        redirect($redirect);
        echo $redirect;
    }


    public function checkpopup()
    {
       
        $data['popupstatus']= $this->user->popupstatus(); 
        return $data['popupstatus'];         
    }
    public function product($type, $id)
    {
        $products = $this->cache->library('beesavy', 'compareprices', array($id), 3600);
        $product = $products[0];
        $image = $product['thumb'];
        $title = $product['name']." for $".$product['final_amount'];
        $description = $product['description'];
        $link = $product['link'];
        $id = $this->refer->createReferral($link, $this->id);
        $rurl = base_url()."refer/r/$id";

        //Make message for specific plugin
        $redirect = $this->$type($title, $description, $this->id, $image, $rurl);
        if($type!="email")
        redirect($redirect);
        echo $redirect;
    }
    public function coupon($type, $id)
    {
        $coupon = $this->cache->library('beesavy', 'getCoupon', array($id), 3600);
        $image = $coupon['merchant_logo'];
        $title = $coupon['name'];
        $description = $coupon['restrictions'];
        $cid = $coupon['id'];
        $link = $coupon['link'];
        $id = $this->refer->createReferral($link, $this->id);
        $rurl = base_url()."refer/r/$id";

        //Make message for specific plugin
        $redirect = $this->$type($title, $description, $this->id, $image, $rurl);
        if($type!="email")
        redirect($redirect);
        echo $redirect;
    }

    //Implemented social networking types
    public function facebook($title, $description, $refid, $image, $link)
    {
        $ch = curl_init();
        $url = "https://www.facebook.com/dialog/feed?"
            ."app_id=117040755037895&"
            ."link=$link&"
            ."picture=$image&"
            ."name=".urlencode($title)."&"
            ."description=Save time. Save money. BeeSavy. Save at thousands of stores like this one with coupons and cash back!<center></center><center></center>$description&"
            ."redirect_uri=$link";

        return $url;
    }

    public function twitter($title, $description, $refid,$image, $link)
    {
        $tweet = str_replace("%20", " ", urlencode("Save time. Save money. BeeSavy. Save at thousands of stores like this one")." - ".$link);
        $url = "https://twitter.com/?status="
            .$tweet;

        return $url;
    }
    public function email($title, $description, $refid, $image, $link)
    {
        $message = $description." - ".$link;
        $url = "mailto:?subject=".($title)."&body=".("Check out this deal I found on BeeSavy. BeeSavy scours the internet to find me the best price at thousands of top online stores including coupons and cash back! %0A%0A $message");

        return $url;
    }
}
