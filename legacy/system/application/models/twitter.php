<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Twitter API:
 * This is initiated by the user clicking a graph Authorization link
 *  Based on the user giving us permissions or not
 *  We can make additional requests to invoke actions on behalf of
 *  the user
 */
require_once('twitteroauth.php');
class Twitter extends Model {

    var $key = "IasncVBK5X49u7DgSXNzmA";
    var $secret ="59pGK5obcEKpTvXWBKgH16L70kTKY06telNqnNAuzYQ";

	function Twitter() {
		parent::Model();
        $this->load->helper('url');
	}

    /*
     * Methods for posting onto a facebook user's wall
     */
    function post_cashback($amount, $uid, $link){
        if((float)$amount < 5){
            $status = "I just saved money by shopping at my favorite stores with BeeSavy.com! $link";
        }else{
            $status = "I just saved $$amount by shopping at my favorite stores with BeeSavy.com! $link";
        }
        $q = $this->db->get_where('user', array('id'=>$uid));
        $q = $q->result_array();
        $user = $q[0];
        $link = base_url()."refer/ref/".$user['alias'];
        $baseURI = 'https://api.twitter.com/1/statuses/update.json';
        $oauth_token= $user['twitter_access_token'];
        $oauth_secret= $user['twitter_token_secret'];
        $nonce = time();
        $timestamp = time();
        $oauth = array(
            'oauth_consumer_key' => $this->key,
            'oauth_nonce'=>$nonce,
            'oauth_timestamp'=>$timestamp,
            'oauth_signature_method'=>'HMAC-SHA1',
            'oauth_token'=>$oauth_token,
            'oauth_version'=> '1.0');
        $consumerSecret = $this->secret;
        $connection = new TwitterOAuth($this->key, $this->secret, $oauth_token, $oauth_secret);
        $c = $connection->post('https://api.twitter.com/1/statuses/update.json', array('status'=>$status));
        print_r($c);
    }

    /* 
     * Methods for gaining permissions for a facebook user
     */
    function request_permissions($ruri,$uid){
        #Request permissions only if we do not already have them
        $q = $this->db->get_where('user', array('id'=>$uid));
        $q = $q->result_array();
        $user = $q[0];
        if($user['twitter_access_token']){
            return False;
        #Otherwise we need to request an oauth token from twitter and then direct the user to 
        #grant permissions
        }else{
            $baseURI = 'https://api.twitter.com/oauth/request_token';
            $nonce = time();
            $timestamp = time();
            $oauth = array('oauth_callback'=>$ruri,
                'oauth_consumer_key' => $this->key,
                'oauth_nonce'=>$nonce,
                'oauth_signature_method'=>'HMAC-SHA1',
                'oauth_timestamp'=>$timestamp,
                'oauth_version'=> '1.0');
            $consumerSecret = $this->secret;
            $baseString = $this->buildBaseString($baseURI, $oauth);
            $compositeKey = $this->getCompositeKey($consumerSecret, null);
            $oauth_signature = base64_encode(hash_hmac('sha1', $baseString, $compositeKey, true));
            $oauth['oauth_signature'] = $oauth_signature;

            $response = $this->sendRequest($oauth, $baseURI);
            $responseArray = array();
            $parts = explode('&', $response);
            foreach($parts as $p){
                $p = explode('=', $p);
                $responseArray[$p[0]] = $p[1];    
            }//end foreach

            //get oauth_token from response
            $oauth_token = $responseArray['oauth_token'];
            $this->db->where('id', $uid);
            $this->db->update('user', array('twitter_token_secret'=>$responseArray['oauth_token_secret']));

            return "http://api.twitter.com/oauth/authorize?oauth_token=$oauth_token";
        }
    }
    function get_access_token($uid){
        $q = $this->db->get_where('user', array('id'=>$uid));
        $q = $q->result_array();
        $user = $q[0];
        $baseURI = 'https://api.twitter.com/oauth/access_token';
        $oauth_token= $this->input->get('oauth_token');
        $oauth_verifier= $this->input->get('oauth_verifier');
        $nonce = time();
        $timestamp = time();
        $oauth = array('oauth_token'=>$oauth_token,
            'oauth_verifier'=>$oauth_verifier,
            'oauth_consumer_key' => $this->key,
            'oauth_nonce'=>$nonce,
            'oauth_signature_method'=>'HMAC-SHA1',
            'oauth_timestamp'=>$timestamp,
            'oauth_version'=> '1.0');
        $consumerSecret = $this->secret;
        $baseString = $this->buildBaseString($baseURI, $oauth);
        $compositeKey = $this->getCompositeKey($consumerSecret, $user['twitter_token_secret']);
        $oauth_signature = base64_encode(hash_hmac('sha1', $baseString, $compositeKey, true));
        $oauth['oauth_signature'] = $oauth_signature;

        $response = $this->sendRequest($oauth, $baseURI);
        $responseArray = array();
        $parts = explode('&', $response);
        foreach($parts as $p){
            $p = explode('=', $p);
            $responseArray[$p[0]] = $p[1];    
        }//end foreach

        //get oauth_tokettn from response
        if(array_key_exists('oauth_token', $responseArray)){
        $this->db->where('id', $uid);
        $this->db->update('user', array('twitter_access_token'=>$responseArray['oauth_token']));
        $this->db->where('id', $uid);
        $this->db->update('user', array('twitter_token_secret'=>$responseArray['oauth_token_secret']));
        }

    }

    /*
     * Helper methods
     */
    function sendRequest($oauth, $baseURI){
        $header = array( $this->buildAuthorizationHeader($oauth), 'Expect:'); 

        $options = array(CURLOPT_HTTPHEADER => $header,
                       CURLOPT_HEADER => false,
                       CURLOPT_URL => $baseURI,
                       CURLOPT_POST => true, 
                       CURLOPT_RETURNTRANSFER => true,
                       CURLOPT_SSL_VERIFYPEER => false);

        $ch = curl_init(); //get a channel
        curl_setopt_array($ch, $options); //set options
        $response = curl_exec($ch); //make the call
        curl_close($ch); //hang up

        return $response;
    }
    function getCompositeKey($consumerSecret, $requestToken){
        return rawurlencode($consumerSecret) . '&' . rawurlencode($requestToken);
    }
    function buildAuthorizationHeader($oauth){
        $r = 'Authorization: OAuth '; //header prefix
        $values = array();
        foreach($oauth as $key=>$value){
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }
        $r .= implode(', ', $values);
        return $r;
    }
    function buildBaseString($baseURI, $params){
        $r = array(); //temporary array
        ksort($params); //sort params alphabetically by keys
        foreach($params as $key=>$value){
            $r[] = "$key=" . rawurlencode($value); //create key=value strings
        }//end foreach                

        return "POST&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r)); //return complete base string
    }
    function user_info($access_token){
        #Get user info
        $url = "https://graph.facebook.com/me?access_token=$access_token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $data = curl_exec($ch);
        $info = json_decode($data);
    }

    function adduser($info, $access){
        $fid = $info->id;
        $fname = $info->first_name;
        $lname = $info->last_name;
        $profile = $info->profile;
        $gender = $info->gender;
        $email = $info->email;
        $timezone = $info->timezone;
        $locale = $info->locale;
        $time = $info->updated_time;
        #Add user to database

        #Check if user exists
        $sql = "select * from facebook where fid = $fid";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        if(empty($res)){
            $sql = "insert into facebook (fid, fname, lname, profile, gender, email, timezone, locale, time) select '$fid', '$fname', '$lname', '$profile', '$gender', '$email', '$timezone', '$locale', '$time';";
            $this->db->query($sql);
        }
    }

}
?>
