<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for defining simple format relatioships of xml data 
 * and url response
 */

class Simple{
    function simpleAPI($item, $fields, $xml){
        $result = array();
        $array = $xml->xpath("//$item");
        foreach($array as $a){
            $row = array();
            foreach($fields as $name=>$path){
                $xpath = $a->xpath(".//$path");
                $row[$name] = (string)$xpath[0];
            }
            $result[] = $row;
        }
        return $result;
    }
    function simpleFormat(&$data, $fields){
        foreach($data as &$item){
            foreach($fields as $field=>$format){
                if($format=='text'){
                    //Already formatted
                }elseif($format=='date'){
                    $date = strftime("%A, %B %e, %Y", strtotime($item[$field]));
                    $item[$field] = $date;
                }elseif($format=='money'){
                    $money = substr_replace($item[$field], ".", -2, 0);;
                    $item[$field]=$money;
                }
            }
        }
    }
    function simpleGetRequest($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $startTime = date("Y-m-d H:i:s");
        $data = curl_exec($ch);
        $meta = curl_getinfo($ch);

        if($result || curl_errno() != 0)
        {
            $fh = fopen('./tmp/API_error_log.txt','a');
            fwrite($fh, "Error contacting extrabux API\n");
            fwrite($fh, "Request made at ". $startTime. "\n" );
            fwrite($fh, date("Y-m-d H:i:s") . "\n");
            fwrite($fh, "curl error was". curl_error(). "\n");
            fwrite($fh, print_r($result, true));
            fclose($fh);
        }
        curl_close($ch);
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
            $save = ($result['retail_amount']-$result['final_amount'])/$result['retail_amount'];
            $save = round($save*100,0);
            $result['save_text'] = $save;
        }
    }
}
?>
