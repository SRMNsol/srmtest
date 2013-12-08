<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BeeSavy Library
 *
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @author      Jonny Simkin
*/

class Old_Beesavy extends Old_Extrabux {
    var $query_limit = 25;
    function get_hot_coupons($num_coupons){
        $coupons = Old_Extrabux::listCoupon('','','',50);
        $ids = array();
        $hot = array();
        foreach($coupons['coupons'] as &$coupon){
            $coupon['link'] = '/transfer/coupon/'.$coupon['id'];
            $coupon['linkstore'] = '/stores/details/'.$coupon['merchant_id'];
            $id = $coupon['merchant_id'];
            if($coupon['code_prefix']==''){
                $coupon['code_prefix'] = "<a style='color:#515151; font-weight:bold;' href='stores/details/$id'>Click here to activate</a>";
                $coupon['code'] = '';
            }
            if(!in_array($coupon['merchant_id'], $ids)){
                $ids[] = $coupon['merchant_id'];
                $hot[] = $coupon;
            }
            if(count($hot)==$num_coupons){
                break;
            }
        }
        return $hot;
    }

    function get_hot_stores_rand($num_stores){
        $stores = $this->listStore('','','rank',100,'');
        $stores = $stores['stores'];
        $hot_stores = array();
        $indices = array();
        while(count($indices)<$num_stores&&count($stores)!=0){
            $index = rand(0,count($stores)-1);
            if(!in_array($index, $indices) && $stores[$index]['name']!='Half.com')
                $indices[]=$index;
        }
        foreach($indices as $index){
            $hot_stores[] = $stores[$index];
        }
        return array('stores'=>$hot_stores);
    }
    function get_daily_rand($max_deals){
        $deals = $this->dailyDeals();
        $num_deals = count($deals);
        $show  = array();
        if($max_deals>$num_deals){
            return $deals;
        }

        //Randomly select indexes to use
        $indices = array();
        while(count($indices)<$max_deals){
            $index = rand(0,$num_deals-1);
            if(!in_array($index, $indices))
                $indices[]=$index;
        }
        //Add the selected indexes to the show list
        foreach($indices as $index){
            $show[] = $deals[$index];
        }
        return $show;
    }

    function abreviate(&$arr, $index, $limit){
        foreach($arr as &$a){
            if(!$a[$index]){
                $a[$index.'-abrv'] = "No description available";
            }else{
                $len = strlen($a[$index]);
                if($len>$limit){
                    $a[$index.'-abrv'] = substr($a[$index],0,$limit).'...';
                }else{
                    $a[$index.'-abrv'] = $a[$index];
                }
            }
        }
    }
    function wrap_coupon(&$arr){
        foreach($arr as &$a){
            if($a['coupons']=='0'){
                $a['class'] = 'coupon';
                $a['coupons'] = array();
            }else{
                $a['class'] = 'coupons';
                $a['coupons'] = array(array('coupon_text'=>$a['coupons'].' Coupons',
                    'id'=>$a['id']));
            }
        }
    }

    function getUserStats($id){
        $cashback = Old_Extrabux::getUserStats($id);
        $total = $cashback['total'];
        $total[0]['UserPending'] = sprintf("%01.2f",(float)$total[0]['pending']);
        $total[0]['UserAvailable'] = sprintf("%01.2f",(float)$total[0]['available']);
        $total[0]['pending'] = sprintf("%01.2f",(float)$total[0]['pending']+(float)$total[0]['referralpending']);
        $total[0]['available'] = sprintf("%01.2f",(float)$total[0]['available']+(float)$total[0]['referralavailable']);
        $total[0]['processing'] = sprintf("%01.2f",(float)$total[0]['referralprocessing']+(float)$total[0]['processing']);
        $total[0]['paid'] = sprintf("%01.2f",(float)$total[0]['referralpaid']+(float)$total[0]['paid']);
        $total[0]['referralpending'] = sprintf("%01.2f",(float)$total[0]['referralpending']);
        $total[0]['referralavailable'] = sprintf("%01.2f",(float)$total[0]['referralavailable']);
        $purchases = $cashback['purchases'];
        $index= 0 ;
        for($i = 0; $i<count($cashback['reftransactions']); $i++){
            $sum = 0;
            $sum += (float) $cashback['reftransactions'][$i]['referralpaid'];
            $sum += (float) $cashback['reftransactions'][$i]['referralcommissiondirect'];
            $sum += (float) $cashback['reftransactions'][$i]['referralcommissionindirect'];
            if($sum == 0){
                unset($cashback['reftransactions'][$i]);
            }
        }
        return array_merge(array(
            'type' => 'all',
            'total'=>$total,
        ), array('transactions'=>$purchases,
        'reftransactions'=>$cashback['reftransactions']));
    }

    function dailyDeals(){
        $deals = Old_Extrabux::dailyDeals();
        foreach($deals as &$deal){
            $deal['link'] = '/transfer/deal/'.$deal['id'];
        }
        return $deals;
    }
    function listCoupon($merchant_id, $page, $sort, $limit){
        $coupons = Old_Extrabux::listCoupon($merchant_id, $page, $sort, $limit);
        foreach($coupons['coupons'] as &$coupon){
            $coupon['expiration'] = $coupon['end_date'];
            $coupon['link'] = '/transfer/coupon/'.$coupon['id'];
            $coupon['linkstore'] = '/stores/details/'.$coupon['merchant_id'];
        }
        return $coupons;
    }
    function listStore($q, $page, $sort, $limit, $category){
        $stores = Old_Extrabux::listStore($q, $page, $sort, $limit, $category);
        foreach($stores['stores'] as &$store){
            $store['link'] = '/transfer/store/'.$store['id'];
        }
        return $stores;
    }
    function getStore($id){
        $store = Old_Extrabux::getStore($id);
        $store['link'] = '/transfer/store/'.$id;
        return $store;
    }
    function compareprices($groupID, $zip = False){
        $products = Old_Extrabux::compareprices($groupID, $zip);
        function comp($a, $b){
            $valA = ($a['final_amount']);
            $valA = (float)str_replace(",","",$valA);
            $valB = ($b['final_amount']);
            $valB = (float)str_replace(",","",$valB);
            if ($valA == $valB) {return 0;}
            else {return ($valA<$valB) ? -1 : 1;}
        }
        foreach($products as &$product){
            $product['link'] = '/transfer/product/'.$product['id'];
            $product['cashback_amount'] = $product['cashback_amount_half'];
            $product['final_amount'] = $product['final_amount_half'];
            $product['lowest_price'] = $product['lowest_price_half'];
            if($product['tax_amount']!=''){
                if($product['tax_amount'] == '0.00'){
                    $tax = 'None';
                }else{
                    $tax = '$'.$product['tax_amount'];
                    $product['final_amount'] = (float)$product['final_amount']+(float)$product['tax_amount'];
                }
                if($product['shipping_amount'] == '0.00'){
                    $shipping = 'Free';
                }else{
                    $shipping = '$'.$product['shipping_amount'];
                    $product['final_amount'] = (float)$product['final_amount']+(float)$product['shipping_amount'];
                }
                $product['final_amount'] = number_format($product['final_amount'], 2);
                $product['t&s'] = "Tax: $tax<br/>Shipping: $shipping<br/>";
            }else{
                $product['t&s'] = '';
            }
        }
        usort($products, "comp");
        return $products;

    }
}
