<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Extrabux Library
 *
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		Jonny Simkin
*/
include 'simple.php';
class Extrabux extends Simple {

    var $key ="key=873EB2C9E87A6D612058169AB0DF6404";
    var $pub = "publisher_id=1";
    var $publisher = "1";
    var $publisher_tag = "beesavy";
    var $base_key ="873EB2C9E87A6D612058169AB0DF6404";
    var $baseurl2 = "ec2-174-129-223-81.compute-1.amazonaws.com/sandbox/api";
    //var $baseurl = "ec2-50-16-13-103.compute-1.amazonaws.com/api";
    var $baseurl ="http://www.extrabux.com/api";

    //Extrabux API Interfaces
    //User-stats
    var $usinterface = array(
        'id'=>'id',
        'order_id'=>'order_id',
        'user_id'=>'user_id',
        'merchant_id'=>'merchant_id',
        'click_id'=>'click_id',
        'publisher_id'=>'publisher_id',
        'publisher_tag'=>'publisher_tag',
        'date'=>'date',
        'amount'=>'amount',
        'cashback'=>'cashback',
        'take'=>'take',
        'report_date'=>'report_date',
        'available_date'=>'available_date',
        'status'=>'status',
        'created'=>'created',
        'modified'=>'modified',
        'merchant'=>'merchant',
        'merchant_slug'=>'merchant_slug'
    );
    var $usformat = array(
        'amount'=>'money',
        'cashback'=>'money',
        'take'=>'money',
        'report_date'=>'shortdate',
        'date'=>'month',
        'available_date'=>'date',
        'created'=>'shortdate'
    );
    var $ustotalinterface = array(
        'pending'=>'Pending',
        'available'=>'Available',
        'processing'=>'Processing',
        'paid'=>'Paid',
        'referralpending'=>'ReferralPending',
        'referralavailable'=>'ReferralAvailable',
        'referralprocessing'=>'ReferralProcessing',
        'referralpaid'=>'ReferralPaid',
        'referralcommissiondirect'=>'ReferralCommissionDirect',
        'referralcommissionindirect'=>'ReferralCommissionIndirect',
        'referralcountdirect'=>'ReferralCountDirect',
        'referralcountindirect'=>'ReferralCountIndirect',
        );

    //Coupon
    var $cinterface = array(
        'id'=>'id',
        'cid'=>'id',
        'merchant_id'=>'merchant_id',
        'name'=>'name',
        'code'=>'code',
        'link'=>'link',
        'cashback_flat'=>'cashback_flat',
        'cashback_percent'=>'cashback_percent',
        'logo'=>'logo',
        'logo_thumb'=>'logo_thumb',
        'merchant_name'=>'merchant_name',
        'merchant_logo'=>'merchant_logo',
        'end_date'=>'end_date',
        'restrictions'=>'restrictions'
    );
    var $cformat = array('end_date'=>'date');

    //Daily Deals
    var $dinterface = array(
            'id'=>'id',
            'name'=>'name',
            'short_name'=>'name',
            'code'=>'code',
            'merchant_id'=>'merchant_id',
            'merchant_url'=>'merchant_url',
            'merchant_name'=>'merchant_name',
            'product_url'=>'link',
            'full_url'=>'link',
            'retail_amount'=>'retail_amount',
            'final_amount'=>'final_amount',
            'cashback_type'=>'discount_type',
            'cashback_percent'=>'cashback',
            'cashback_flat'=>'discount_amount',
            'cashback_amount'=>'discount_amount',
            'deal_expiration'=>'deal_expiration',
            'product_image'=>'images/image[2]',
            'product_thumb'=>'images/image[1]',
            'merchant_thumb'=>'merchant_logo',
            'discount_limitation'=>'discount_limitation',
            'discount_amount'=>'discount_amount',
            'discount_type'=>'discount_type',
            'discount_percent'=>'discount_percent',
            'discount_cash'=>'discount_cash',
            'description'=>'description',
            'expires'=>'end_date',
            'short_desc'=>'description',
            'restrictions'=>'restrictions',
            'exp_date_short'=>'end_date'
        );
    var $dcouponinterface = array(
        'id'=>'id',
        'merchant_id'=>'merchant_id',
        'name'=>'name',
        'restrictions'=>'restrictions',
        'code'=>'code',
        'link'=>'link',
        'start_date'=>'start_date',
        'end_date'=>'end_date',
        'discount_type'=>'discount_type',
        'discount_amount'=>'discount_amount',
        'discount_limitation'=>'discount_limitation',
        'new_customers_only'=>'new_customers_only',
        'description'=>'description'
        );
    var $dformat = array(
            'retail_amount'=>'money',
            'final_amount'=>'money',
            'deal_expiration'=>'date'
            );


    //Categories
    var $catinterface= array(
        'id'=>'id',
        'parent_id'=>'parent_id',
        'name'=>'name');
    var $catstoreinterface = array(
        'id'=>'id',
        'name'=>'name',
        'slug'=>'slug',
        'description'=>'description',
        'store_url'=>'store_url',
        'cashback_percent'=>'cashback_percent',
        'cashback_flat'=>'cashback_flat',
        'days_available'=>'days_available',
        'rank'=>'rank',
        'logo'=>'logo',
        'logo_thumb'=>'logo_thumb',
        'web_object_id'=>'web_object_id',
        );
    var $catformat = array(
            'name'=>'name',
            'parent_id'=>'parent_id');

    //User
    var $uinterface = array(
                    'id'=>'id',
                    'first_name'=>'first_name',
                    'last_name'=>'last_name',
                    'email'=>'email',
                    'role'=>'role',
                    'password_old'=>'password_old',
                    'password'=>'password',
                    'address'=>'street',
                    'city'=>'city',
                    'state'=>'state',
                    'zip'=>'zip',
                    'status'=>'status',
                    'user_payment_method_id'=>'user_payment_method_id',
                    'affiliate_id'=>'affiliate_id',
                    'send_reminders'=>'receive_newsletter',
                    'send_updates'=>'receive_dailydeals',
                    'ip_address'=>'ip_address',
                    'giftcard_balance'=>'giftcard_balance',
                    'publisher_id'=>'publisher_id',
                    'publisher_tag'=>'publisher_tag',
                    'parent_id'=>'parent_id',
                    //'purchase_exempt'=>'purchase_exempt',
        'user_payment_method_first_name',
        'user_payment_method_last_name',
        'user_payment_method_street',
        'user_payment_method_city',
        'user_payment_method_state',
        'user_payment_method_zip',
        'user_payment_method_paypal_email',
        'user_payment_method_charity_id',
        'user_payment_method',
        'user_payment_method_type'
                );

    //Products
    var $pinterface = array(
        'groupID'=>'group_id',
        'name'=>'name',
        'description'=>'description',
        'category_id'=>'category_id',
        'category_name'=>'category_name',
        'parent_category_id'=>'parent_category_id',
        'parent_category_name'=>'parent_category_name',
        'grandparent_category_name'=>'grandparent_category_name',
        'grandparent_category_id'=>'grandparent_category_id',
        'lowprice'=>'lowest_price_half',
        'numchildproducts'=>'num_child_products',
        'sales_rank'=>'sales_rank',
        'score'=>'score'
    );
    var $pformat = array(
        'lowprice'=>'money'
        );
    var $pbinterface = array(
        'name'=>'name',
        'label'=>'label',
        'hits'=>'hits');
    var $pcinterface = array(
        'name'=>'name',
        'label'=>'label',
        'hits'=>'hits');
    var $compinterface = array(
        'id'=>'id',
        'name'=>'name',
        'parent_id'=>'parent_id',
        'brand'=>'brand',
        'description'=>'description',
        'manufacturer_model'=>'manufacturer_model',
        'upc'=>'upc',
        'sku'=>'sku',
        'availability'=>'availability',
        'condition'=>'condition',
        'group_id'=>'group_id',
        'lowest_price'=>'lowest_price',
        'highest_price'=>'highest_price',
        'num_child_products'=>'num_child_products',
        'product_url'=>'product_url',
        'retail_amount'=>'retail_amount',
        'cashback_amount'=>'cashback_amount',
        'final_amount'=>'final_amount',
        'cashback_amount_half'=>'cashback_amount_half',
        'final_amount_half'=>'final_amount_half',
        'lowest_price_half'=>'lowest_price_half',
        'highest_price_half'=>'highest_price_half',
        'merchant_id'=>'merchant_id',
        'merchant_name'=>'merchant_name',
        'shipping_amount'=>'shipping_amount',
        'tax_amount'=>'tax_amount',
        'coupon_discount'=>'coupon_discount',
        'coupon_id'=>'coupon_id',
        'code'=>'code',
        'expiration'=>'end_date',
        'name'=>'name'
        );
    var $compformat = array(
        'lowest_price'=>'money',
        'coupon_discount'=>'money',
        'highest_price'=>'money',
        'retail_amount'=>'money',
        'final_amount'=>'money',
        'cashback_amount'=>'money',
        'cashback_amount_half'=>'money',
        'final_amount_half'=>'money',
        'lowest_price_half'=>'money',
        'highest_price_half'=>'money',
        'tax_amount'=>'money',
        'shipping_amount'=>'money',
        'expiration'=>'date'
        );

    function processPayment($id){
        $url = $this->baseurl."/user/$id?$this->key&method=requestPayment&$this->pub";
        $response = $this->simpleGetRequest($url);
        $xml = $this->simplexml_load_string($response);

		$xmlarray = print_r($xml,TRUE);
		mail('erik@rehatched.com','beesavy',$xmlarray);

		if(isset($xml->error))
		{
			return (string)$xml->error;
		}
		else
		{
       	 	return FALSE;
		}
    }

	 function getUserReferrals($id){
        $url = $this->baseurl."/user-referrals/$id?$this->key&$this->pub";
        $response = $this->simpleGetRequest($url);
        $xml = $this->simplexml_load_string($response);
        $data = array();
		$rxml = $xml->referrals;

        foreach($rxml->referral as $r)
		{
			$date = (string)$r->created;
			$sortdate = strtotime($date);
			$date = date("m/d/Y",strtotime($date));
			$data[] = array('ref_email' => (string)$r->email, 'ref_created' => $date, 'sort_date' => $sortdate);
		}

		aasort($data,"sort_date");

		$data = array_reverse($data);

		return array('referrals' => $data);
    }

    function getUserReport($id){
        $url2 = $this->baseurl;
        $start = "2000-01-01";
        $end = "2050-01-01";
        $url2 .= "/reports/referralSummary?$this->key&start&start_data=$start&end_data=$end&user_id=$id&publisher_id=1";//$this->pub";
        $response = $this->simpleGetRequest($url2);
        $xml = $this->simplexml_load_string($response);
        $rxml = $xml->xpath("//month");
        $data = array();
        foreach($rxml as $r){
            $atr = $r->attributes();

            $date = $atr['date'];
            $v = array();
            $date = DateTime::createFromFormat('Y-m',(string)$date);
            $date = $date->format('m/Y');
            $v['date'] = $date;
            $v['referralpending']            = number_format((float)(string)$r->ReferralPending, 2);
            $v['referralavailable']          = number_format((float)(string)$r->ReferralAvailable, 2);
            $v['referralprocessing']         = number_format((float)(string)$r->ReferralProcessing, 2);
            $v['referralpaid']               = number_format((float)(string)$r->ReferralPaid, 2);
            $v['referralcommissiondirect']   = number_format((float)(string)$r->ReferralCommissionDirect / 100, 2);
            $v['referralcommissionindirect'] = number_format((float)(string)$r->ReferralCommissionIndirect / 100, 2);
            $data[] = $v;
        }
        return $data;
    }

    function getUserStats($id){
        $ref = $this->getUserReport($id);
        $url = $this->baseurl;
        $start = "2000-01-01";
        $end = "2050-01-01";
        $url .= "/user-stats/$id?$this->key&start&start_data=$start&end_data=$end&$this->pub";
        $response = $this->simpleGetRequest($url);

        //Parse the response
        $xml = $this->simplexml_load_string($response);
        $purchases = $this->simpleAPI("purchase", $this->usinterface, $xml);
        $total = $this->simpleAPI("totals", $this->ustotalinterface, $xml);
        if(count($total)==0){
            $total = array();
        }else{
        $total = $total[0];
        $total['available'] = number_format((float)$total['available'],2);
        $total['processing'] = number_format((float)$total['processing'],2);
        $total['paid'] = number_format((float)$total['paid'],2);
        }
        foreach($purchases as &$purchase){
            $purchase['amount'] = number_format($purchase['amount'], 2);
        }
        foreach($total as &$t){
            if(!$t){
                $t = "0";
            }
        }
        //Format the result
        $this->simpleFormat($purchases, $this->usformat);

        return array('reftransactions'=>$ref,'purchases'=>$purchases, 'total'=>array($total));
    }

    function dailyDeals(){
        $url = $this->baseurl;
        $url .= "/deal?$this->key";
        //$url .= "/dailydeals?$this->key";

        $results = array();
        $attempts = 5;
        while(empty($results)){
            $attempts = $attempts - 1;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TRUE);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);

            $data = curl_exec($ch);
            $meta = curl_getinfo($ch);
            $response = $data;
            $xml = $this->simplexml_load_string($response);
            $results = $this->simpleAPI("deal", $this->dinterface, $xml);
            $url = $this->baseurl;
            //$url .= "/coupon/".$results['id']."?$this->key";
            //$response = $this->simpleGetRequest($url);
            //$xml = $this->simplexml_load_string($response);
            //$couponresults = $this->simpleAPI("coupon", $this->dcouponinterface, $xml);

            curl_close($ch);
            if(empty($results)){
                $attempts = $attempts-1;
                usleep(300);
            }
            if($attempts<0){
                break;
            }
            //$fh = fopen("/home/ubuntu/test.txt", 'a');
            //fwrite($fh, $data);
        }
        for($i = 0;$i < count($results);$i++)
        {
            $couponresults = array();
            $url = $this->baseurl;
            $url .= "/coupon/".$results[$i]['id']."?$this->key";
            $response = $this->simpleGetRequest($url);
            $xml = $this->simplexml_load_string($response);
            $couponresults = $this->simpleAPI("coupon", $this->dcouponinterface, $xml);
            //echo "url: ".$couponresults[0]["link"]."<br/>";
            $results[$i]["product_url"] = $couponresults[0]['link'];
            $results[$i]["description"] = $couponresults[0]['description'];
            $results[$i]["code"] = $couponresults[0]['code'];
            $exp = new DateTime($results[$i]['expires']);
            $curdate = new DateTime();
            $interval = $exp->diff($curdate);
            $results[$i]['exp_date_short'] = $interval->days + 1;
            if(strlen($results[$i]['short_name']) > 30)
            {
                $results[$i]['short_name'] = substr($results[$i]['short_name'],0,30)."...";
            }
            if(strlen($couponresults[0]['code']) > 0)
            {
                $results[$i]['code'] = '<div class="btnCouponCode"><a class="BtnBlackTxt" href="/transfer/deal/'.$results[$i]['id'].'">Coupon: '.$results[$i]['code']."</a></div>";
            }
			if($results[$i]['exp_date_short'] > 30)
            {
                $results[$i]['exp_date_short'] = "";
            }
            elseif($results[$i]['exp_date_short'] > 1)
            {
                $results[$i]['exp_date_short'] = "Expires in ".$results[$i]['exp_date_short']." days";
            }
            elseif($results[$i]['exp_date_short'] == 1)
            {
                $results[$i]['exp_date_short'] = "<span class=\"urgentExpire\">Expires Today!</span>";
            }
            elseif($results[$i]['exp_date_short'] == 0)
            {
                $results[$i]['exp_date_short'] = "<span class=\"urgentExpire\">Expires Tomorrow!</span>";
            }
            else
            {
                $results[$i]['exp_date_short'] = "<span class=\"urgetExpire\">Expires Today!</span>";
            }

            $results[$i]['expires'] = date_format($exp,'m/d/y');
            if(strlen($results[$i]['description']) > 100)
            {
                $results[$i]['short_desc'] = substr($results[$i]['description'],0,130).'...';
            }
            else
            {
                $results[$i]['short_desc'] = $results[$i]['description'];
            }
            //$diff = abs(strtotime(date('m/d/Y', time())) - strtotime($results[i]['exp_date_short']));
            //$results[i]['exp_date_short'] = ($diff / (60 * 60 * 24));

        }

        //Format the result
        $this->simpleFormat($results, $this->dformat);

        //Choose cashback message
        $this->cashback($results);

        //Micro adjustrments
        $this->savetext($results);

        return $results;
    }

    function getDailyDeals($id){
        $url = $this->baseurl;
        $url .= "/deal/$id?$this->key";
        //$url .= "/dailydeals/$id?$this->key";
        $response = $this->simpleGetRequest($url);

        //Parse the response
        $xml = $this->simplexml_load_string($response);
        $results = $this->simpleAPI("deal", $this->dinterface, $xml);

        //Format the result
        $this->simpleFormat($results, $this->dformat);

        //Choose cashback message
        $this->cashback($results);
        //Micro adjustrments
        $this->savetext($results);

        $results = $results[0];
        if($results['discount_type'] != '%'){
            $damt = $results['discount_amount'];
            $results['discount_amount'] = (float)$damt * 1.0 / 100;
            $results['discount_percent'] = "";
            $results['discount_cash'] = '$';
        }else{
            $results['discount_percent'] = '%';
            $results['discount_cash'] = "";
        }
        if($results['cashback_type'] == '$'){
            $cbrate = $results['cashback_amount'];
            $results['cashback_amount'] = $cbrate;
        }else{
            $final = $results['cashback_amount'];
            $cbrate = $results['cashback'];
            $results['cashback_amount'] = (float)$final * (float)$cbrate * 1.0 / 100;
        }

        //$diff = abs(strtotime(date('m/d/Y', time())) - strtotime($results['exp_date_short']));
        //$results['exp_date_short'] = ($diff / (60 * 60 * 24));

        $cb = $results['cashback_amount'];
        //Mult by 100 to make money formating easier
        $cb = round($cb, 2)*100;
        $results['cashback_amount'] = substr_replace($cb, ".", -2, 0);
        //$exp = new DateTime($results['expires']);
        //$exp->format('m/d/y');
        //$results['expires'] = $exp;
        $url = $this->baseurl;
        $url .= "/coupon/".$results['id']."?$this->key";
        $response = $this->simpleGetRequest($url);
        $xml = $this->simplexml_load_string($response);
        $couponresults = $this->simpleAPI("coupon", $this->dcouponinterface, $xml);
        $results['product_url'] = $couponresults[0]['link'];
        return $results;
    }

    //Categories returned as tagged HTML
    function getCategory($id){
        if(!$id)
            return false;
        $url = $this->baseurl;
        $url .= "/category/$id?$this->key";

        $response = $this->simpleGetRequest($url);
        $data = $this->simplexml_load_string($response);

        $parent = $this->simpleAPI("category", $this->catinterface, $data);
        $stores = $this->simpleAPI("store", $this->catstoreinterface, $data);
        $this->cashback($stores);
        $parent = $parent[0];
        $parent['stores']=$stores;
        if($parent['parent_id']){
            $child = $this->getCategory($parent['parent_id']);
            $parent['child'] = $child;
        }else{$parent['child']=false;}

        return $parent;
    }

    //Coupons returned as tagged HTML
    function listCoupon($merchant_id, $page, $sort, $limit){
        $url = $this->baseurl;
        $url .= "/coupon?$this->key";
        if(!empty($merchant_id)) {
            $url = $url."&merchant_id=$merchant_id";
        }
        if(!empty($page)) {
            $url = $url."&page=$page";
        }
        if(!empty($sort)) {
            $url = $url."&sort=".urlencode($sort);
        }
        if(!empty($limit)) {
            $url = $url."&limit=$limit";
        }
        $response = $this->simpleGetRequest($url);
        $data = $this->simplexml_load_string($response);

        //Format the data
        $coupons = $this->simpleAPI("coupon",$this->cinterface, $data);
        foreach($coupons as &$coupon){
            $coupon['code_prefix']='';
            if($coupon['code']!=''){
                $coupon['code_prefix']='Coupon: ';
            }
        }
        $this->simpleFormat($coupons, $this->cformat);
        $this->cashback($coupons);

        $count = $data->xpath("//total_coupons");
        $meta = array('count'=>$count);
        $data = array('coupons'=>$coupons, 'meta'=>$meta);

        return $data;
    }
    function getCoupon($id){
        $url = $this->baseurl;
        $url .= "/coupon/$id?$this->key";
        $response = $this->simpleGetRequest($url);
        $data = $this->simplexml_load_string($response);

        $coupons = $this->simpleAPI("coupon",$this->cinterface, $data);
        foreach($coupons as &$coupon){
            $coupon['code_prefix']='';
            if($coupon['code']!=''){
                $coupon['code_prefix']='Coupon: ';
            }
        }
        $this->simpleFormat($coupons, $this->cformat);
        $this->cashback($coupons);
        return $coupons[0];
    }

    //Stores returned as tagged HTML
    function listStore($q, $page, $sort, $limit, $category){
        $url = $this->baseurl;
        $url .= "/store?$this->key";
        if(!empty($q)) {
            $url = $url."&q=$q";
        }
        if(!empty($category)){
            $url = $url."&category=$category";
        }
        if(!empty($page)) {
            $url = $url."&page=$page";
        }
        if(!empty($sort)) {
            $url = $url."&sort=$sort";
        }
        if(!empty($limit)) {
            $url = $url."&limit=$limit";
        }


        $datas = "";
        while($datas == ""){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $datas = curl_exec($ch);
        $meta = curl_getinfo($ch);
        curl_close($ch);
        if($datas == ""){
            usleep(300);
        }
        }
        $data = $this->simplexml_load_string($datas);

        $storexml = $data->xpath("//store");
        if(count($storexml)==0){
            $fp = fopen('test.txt', 'a');
            fwrite($fp, "SUSPICIOUS RETURN \n");
            fwrite($fp, "YOU SHOULD SEE DATA HERE TIME: ".date("m, d, y h:i:s", time())." \n");
            fwrite($fp, $meta);
            fwrite($fp, $datas);
            if($error = curl_error($url)){
                fwrite($fp, $error);
            }
            fwrite($fp, "END DATA \n");
            fclose($fp);
        }
        $stores = array();
        foreach($storexml as $xml){
            $store = array();
            $store['id'] =(string) $xml->id;
            $store['name'] =(string) $xml->name;
            $store['logo'] =(string) $xml->logo;
            $store['logo'] = str_replace('merchant-images.extrabux.com', 'd20weo6qzghj5o.cloudfront.net', $store['logo']);
            $store['logo_thumb'] =(string) $xml->logo_thumb;
            $store['logo_thumb'] = str_replace('merchant-images.extrabux.com', 'd20weo6qzghj5o.cloudfront.net', $store['logo_thumb']);
            $store['description']=(string)$xml->description;
            $store['cashback_percent']=(string)$xml->cashback_percent;
            $store['cashback_percent']=(string)((float)$xml->cashback_percent/2);
            $money=(string)((float)$xml->cashback_flat/2);
            $money = substr_replace($money, ".", -2, 0);;
            $store['cashback_flat']=$money;
            if($store['cashback_percent']!='0'){
                $store['cashback_text']=$store['cashback_percent'].'%';
            }else{
                $store['cashback_text']='$'.$store['cashback_flat'];
            }
            $store['coupons']=(string)$xml->coupons;
            $stores[] = $store;
        }
        //Get meta data
        $meta = array();
        if($data){
        $data = $data->xpath("//details");
        $data = $data[0];
        }
        $meta['page']=$data->page;
        $meta['sort']=$data->sort;
        $meta['limit']=$data->limit;
        $meta['returned']=$data->returned;
        $meta['total_stores']=$data->total_stores;

        $data = array('stores'=>$stores, 'meta'=>$meta);

        return $data;
    }
    function getStore($id){
        $url = $this->baseurl;
        $url .= "/store/$id?$this->key";

        $data = "";
        while($data == ""){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $data = curl_exec($ch);
        $meta = curl_getinfo($ch);

        curl_close($ch);
        if($data == ""){
            usleep(300);
        }
        }
        $data = $this->simplexml_load_string($data);
        $storexml = $data->store;

        $store=array();
        $store['name']=(string)$storexml->name;
        $store['id']=(string)$storexml->id;
        $store['slug']=(string)$storexml->slug;
        $store['description']=(string)$storexml->description;
        $store['store_url']=(string)$storexml->store_url;
        $store['url']=(string)$storexml->shop_url;

        $store['cashback_percent']=(string)((float)$storexml->cashback_percent/2);
        $store['restrictions']=(string)($storexml->restrictions);
        $money=(string)((float)$storexml->cashback_flat/2);
        $money = substr_replace($money, ".", -2, 0);;
        $store['cashback_flat']=$money;

        $store['logo'] = (string)$storexml->logo;
        $store['logo'] = str_replace('merchant-images.extrabux.com', 'd20weo6qzghj5o.cloudfront.net', $store['logo']);
        $store['logo_thumb'] = (string)$storexml->logo_thumb;
        $store['logo_thumb'] = str_replace('merchant-images.extrabux.com', 'd20weo6qzghj5o.cloudfront.net', $store['logo_thumb']);
        if($store['cashback_percent']!='0'){
            $store['cashback_text']=$store['cashback_percent'].'%';
        }else{
            $store['cashback_text']='$'.$store['cashback_flat'];
        }

        return $store;

    }

    //Referral API
    function createReferral($user_id, $entity_type, $entity){
        $url = $this->baseurl;
        $url .= "/referral?$this->key&user_id=$user_id&entity_type=$entity_type&entity=$entity";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $data = curl_exec($ch);
        $meta = curl_getinfo($ch);

        curl_close($ch);
    }
    function lookupReferral($id){
        $url = $this->baseurl;
        $url .= "/referral/$id?$this->key";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $data = curl_exec($ch);
        $meta = curl_getinfo($ch);

        curl_close($ch);
    }

    //Click API
    //product_id is an optional arguement for linking to a product page
    function click($merchant_id, $user_id, $product_id){
        $url = $this->baseurl;
        $url .= "/click?$this->key";
    	$ch = curl_init();
        $post =array(
            'publisher_id'=>$this->publisher,
            'publisher_tag'=>$this->publisher_tag,
            'merchant_id'=>$merchant_id,
            'user_id'=>$user_id);
        if($product_id){
            $post['product_id']=$product_id;
        }
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => http_build_query($post)
        );

        curl_setopt_array($ch, ($defaults));
        $data = curl_exec($ch);
        $meta = curl_getinfo($ch);

        curl_close($ch);

        $clickdata = $this->simplexml_load_string($data);
        $merchanturl = $clickdata->click;
        $merchanturl = $merchanturl->merchant_transfer_url[0];
        //$merchanturl = str_replace("&","&amp;", $merchanturl);
        return $merchanturl;
    }

    //User API
    function getUser($id, $password, $no_auth = False){
        $url = $this->baseurl;
        $url .= "/user/$id?$this->key&$this->pub";

        $data = "";
        while($data == ""){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $data = curl_exec($ch);
        $meta = curl_getinfo($ch);

        curl_close($ch);
        if($data == ""){
            usleep(300);
        }
        }
        $response = $this->simplexml_load_string($data);
        $error =  $response->xpath('//error');
        $info = $response->xpath('//user');
        if(!$error){
            $pass = (string)$info[0]->password;
            if($pass == (($password)) || $no_auth){
                $results = $this->simpleAPI("user", $this->uinterface, $response);
                return $results[0];
            }
        }
        return False;
    }
    function createUser($first_name, $last_name, $email, $password,$parent_id, $referral_id){
        $url = $this->baseurl;
        $url .= "/user?$this->key&$this->pub";
    	$ch = curl_init();
        $post =array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => trim($email),
            'password' => $password,
            'publisher_id'=>$this->publisher,
            'parent_id'=>$referral_id,
            'referral_id'=>$referral_id);
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => http_build_query($post)
        );

        curl_setopt_array($ch, ($defaults));
        $data = curl_exec($ch);
        $meta = curl_getinfo($ch);
        curl_close($ch);
        $xml = $this->simplexml_load_string($data);
        return (string)$xml->user->id;
    }
    function updateUserBatch($id, $email, $password, $data){
        $url = $this->baseurl;
        $url .= "/user/$id";
    	$ch = curl_init();
        $post =array(
            'key'=>$this->base_key,
            'publisher_id'=>$this->publisher,
            'user_payment_method_type'=>'check',
            'email' => trim($email));
        $post = array_merge($post, $data);

        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => http_build_query($post)
        );

        curl_setopt_array($ch, ($defaults));
        $data = curl_exec($ch);
        $meta = curl_getinfo($ch);
        curl_close($ch);
    }
    function updateUser($id, $email, $password, $field, $info){
        $url = $this->baseurl;
        $url .= "/user/$id";
    	$ch = curl_init();
        $post =array(
            'key'=>$this->base_key,
            'publisher_id'=>$this->publisher,
            'email' => trim($email),
            'password' => $password,
            $field => $info);
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => http_build_query($post)
        );

        curl_setopt_array($ch, ($defaults));
        $data = curl_exec($ch);
        $meta = curl_getinfo($ch);
        curl_close($ch);
    }

    //Product Search API
	function productsearch($q, $page, $category, $brand, $limit, $sort, $zip=False) {
			$q = urlencode($q);
            $brand = array_map('urlencode', $brand);
			$brand = implode("&str_brand[]=",$brand);
            $url = $this->baseurl;
            $url .= "/search?$this->key";
            $url .= "&q=$q";
			if(!empty($category)) {
				$url = $url."&category_id=$category";
			}
			if(!empty($sort)) {
				$url = $url."&sort=".urlencode($sort);
			}
			if(!empty($page)) {
				$url = $url."&page=".urlencode($page);
			}
            #Brand must be last since it is an array of values
			if(!empty($brand)) {
				$url = $url."&str_brand[]=".$brand;
			}
			if(!empty($zip)) {
				$url = $url."&zip=".$zip;
			}

            $response = $this->simpleGetRequest($url);
            $xml = $this->simplexml_load_string($response);
            $products = $this->simpleAPI("document", $this->pinterface, $xml);
            foreach($products as &$product){
                $product['image'] = 'http://images.extrabux.com/'.$product['groupID'].'_s.jpg';
                $product['description'] = strip_tags($product['description']);
            }
            $brandpath = "facets/facet[1]/results/result";
            $categorypath = "facets/facet[2]/results/result";
            $brands = $this->simpleAPI($brandpath, $this->pbinterface, $xml);
            $categories = $this->simpleAPI($categorypath, $this->pcinterface, $xml);
            $this->simpleFormat($products, $this->pformat);


            $metadata['count'] = (int) $xml->documentSet->documents['count'];
            $metadata['start'] = (int) $xml->documentSet->documents['start'];
            $metadata['brands'] = $brands;
            $metadata['categories'] = $categories;
            $searchreturn = array();
            $searchreturn['products']=$products;
            $searchreturn['metadata']=$metadata;
            return $searchreturn;
	}

	function compareprices($groupID, $zip) {
        $url = "http://www.extrabux.com/api/product/$groupID?key=$this->base_key";
        if(!empty($zip)) {
            $url = $url."&zip=".$zip;
        }

        $response = $this->simpleGetRequest($url);
        $xml = $this->simplexml_load_string($response);
        $products = $this->simpleAPI("document", $this->compinterface, $xml);
        $image = 'http://d18uespwp5k87w.cloudfront.net/'.$products[0]['group_id'].'_m.jpg';
        $thumb = 'http://d18uespwp5k87w.cloudfront.net/'.$products[0]['group_id'].'_s.jpg';
        foreach($products as &$product){
            $product['image'] = $image;
            $product['thumb'] = $thumb;
            $merchant_image  = 'http://d20weo6qzghj5o.cloudfront.net/'.$product['merchant_id'].'_t.jpg';
            $product['merchant_image'] =$merchant_image;
                $product['description'] = strip_tags($product['description']);
        }
        $this->simpleFormat($products, $this->compformat);
        return $products;
	}
}


function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}
?>
