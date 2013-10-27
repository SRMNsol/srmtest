<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for defining simple format relatioships of xml data
 * and url response
 */

class Simple{
    function simplexml_load_string($data){
        $data = simplexml_load_string($data);
        if(!$data){
            $string = <<<XML
<?xml version='1.0'?>
<error></error>
XML;
            $data = simplexml_load_string($string);
        }
        return $data;
    }
    function simpleAPI($item, $fields, $xml){
        $result = array();
        $array = $xml->xpath("//$item");
        if($array){
        foreach($array as $a){
            $row = array();
            foreach($fields as $name=>$path){
                $xpath = $a->xpath(".//$path");
                if($xpath){
                    $row[$name] = (string)$xpath[0];
                    if($name=="cashback_flat" || $name=="cashback_percent"){
                        $row[$name] = (float)$row[$name]/2;
                    }
                    if(strstr($row[$name],'http://deal-images.extrabux.com')){
                        $row[$name] = str_replace('deal-images.extrabux.com', 'd3o0b2eg5p7zdo.cloudfront.net', $row[$name]);
                    }
                    if(strstr($row[$name],'http://merchant-images.extrabux.com')){
                        $row[$name] = str_replace('merchant-images.extrabux.com', 'd20weo6qzghj5o.cloudfront.net', $row[$name]);
                    }
                    if(strstr($row[$name],'http://images.extrabux.com')){
                        $row[$name] = str_replace('images.extrabux.com', 'd18uespwp5k87w.cloudfront.net', $row[$name]);
                    }
                    if(strstr($row[$name],'http://static.extrabux.com')){
                        $row[$name] = str_replace('static.extrabux.com', 'd2s3q6q1lzb0cp.cloudfront.net', $row[$name]);
                    }
                }else{
                    $row[$name] = "";
                }
            }
            $result[] = $row;
        }
        return $result;
        }
        return array();
    }
    function simpleFormat(&$data, $fields){
        foreach($data as &$item){
            foreach($fields as $field=>$format){
                if($format=='text' || $item[$field] == ''){
                    //Already formatted
                }elseif($format=='date'){
                    $date = strftime("%B %e, %Y", strtotime($item[$field]));
                    if(strtotime($item[$field])<1){
                        $date= "Never";
                    }
                    $item[$field] = $date;
                }elseif($format=='shortdate'){
                    $date = DateTime::createFromFormat('Y-m-d G:i:s',$item[$field]);
                    $date = $date->format('m/d/Y');
                    $item[$field] = $date;
                }elseif($format=='month'){
                    $date = DateTime::createFromFormat('Y-m-d G:i:s',$item[$field]);
                    $date = $date->format('m/Y');
                    $item[$field] = $date;
                }elseif($format=='money'){
                    if(strstr($item[$field], ".")){
                        $num = (float)$item[$field] * 100;
                        $item[$field] = (string) $num;
                    }
                    if($item[$field]<10){
                        $item[$field]= "0.0".$item[$field];
                    }elseif($item[$field]<100){
                        $item[$field]= "0.".$item[$field];
                    }else{
                        $money = substr_replace($item[$field], ".", -2, 0);;
                        $item[$field]=$money;
                    }

                }
            }
        }
    }
    function simpleGetRequest($url){
        $data = "";
        while($data == ""){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $data = curl_exec($ch);
        $meta = curl_getinfo($ch);

        curl_close($ch);
        if($data == ""){
            usleep(300);
        }
        }
        return $data;
    }
    function cashback(&$data){
        foreach($data as &$item){
            if($item['cashback_percent']=='0'){
                $item['cashback_text']="$".$item['cashback_flat'];
            }else{
                $item['cashback_text']=$item['cashback_percent']."%";
            }
        }
    }

    function savetext(&$data){
        foreach($data as &$result){
            $save = $result['retail_amount'] <= 0 ? 0 : ($result['retail_amount']-$result['final_amount'])/$result['retail_amount'];
            $save = round($save*100,0);
            $result['save_text'] = $save;
        }
    }
}
?>
