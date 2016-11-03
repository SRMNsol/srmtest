<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Facebook API:
 * This is initiated by the user clicking a graph Authorization link
 *  Based on the user giving us permissions or not
 *  We can make additional requests to invoke actions on behalf of
 *  the user
 */
class Facebook extends Model {

    var $id = "117040755037895";
    var $secret ="04ced89742cf2754a630775cdc956081";

	function Facebook() {
		parent::Model();
        $this->load->helper('url');
	}

    /*
     * Methods for posting onto a facebook user's wall
     */
    function post_message($message, $uid){
        #Get user from database
        $this->db->get_where('user', array('id'=>$uid));
        $q->result_array();
        $user = $q[0];
        $access_token = $user['fb_access_token'];

        #Post to someone's feed
        $info = $this->user_info($acces_token);
        $fid = $info->id;
        $link = $message['link'];
        $title = $message['title'];
        $content = $message['content'];
        $image = $message['image'];

        $ch = curl_init();
        $url = "https://graph.facebook.com/$fid/feed";
        $post =array('access_token'=>$access_token, 
            'description'=>"$content", 
            'link'=>$link, 
            'picture'=>$image,
            'name'=>$title);
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
    }
    function post_cashback($amount, $uid, $link){
        $image =base_url()."images/bee-alone.gif"; 
        if((float)$amount < 5){
            $status = "I just saved money by shopping at my favorite stores with BeeSavy.com! $link";
        }else{
            $status = "I just saved $$amount by shopping at my favorite stores with BeeSavy.com! $link";
        }
        $q = $this->db->get_where('user', array('id'=>$uid));
        $q = $q->result_array();
        $user = $q[0];
        $access_token = $user['fb_access_token'];
        $ch = curl_init();
        $url = "https://graph.facebook.com/me/feed";
        $post =array('access_token'=>$access_token, 
            'description'=>"$status", 
            'link'=>$link);
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
    }

    /* 
     * Methods for gaining permissions for a facebook user
     */
    function request_permissions($ruri,$uid){
        #Request permissions only if we do not already have them
        $q = $this->db->get_where('user', array('id'=>$uid));
        $q = $q->result_array();
        $user = $q[0];
            $client_id = $this->id;
            return "https://www.facebook.com/dialog/oauth?client_id=$client_id&redirect_uri=".urlencode($ruri)."&scope=email,offline_access,publish_stream";
    }
    function get_access_token($uid){
        $error = $this->input->get('error');
        if ($error)
            return False;

        //Make the FB Request for the access token
        $clientid = $this->id;
        $clientsecret = $this->secret;
        $code = $this->input->get('code');
        if($this->input->get('code')){
            $ruri = "https://www.beesavy.com/account/add_facebook";
            $ruri = urlencode($ruri);
            $url = "https://graph.facebook.com/oauth/access_token?client_id=$clientid&redirect_uri=".$ruri."&client_secret=$clientsecret&code=$code";

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TRUE);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $data = curl_exec($ch);
            $arr = array();
            parse_str($data, $arr);
        }
        if($arr['access_token']){
            $this->db->where('id', $uid);
            $this->db->update('user', array('fb_access_token'=>$arr['access_token']));
            return True;
        }else{
            return False;
        }
    }

    /*
     * Helper methods
     */
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
