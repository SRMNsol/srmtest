<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class Emailer extends Model {

	function Emailer() {
		parent::Model();
	}

    function sendMessage($message, $txt_message, $email, $title="BeeSavy"){
        $data = array('title'=>$title,
            'message'=>$message,
            'txt_message'=>$txt_message,
            'to_addr'=>$email,
            'from_addr'=>'no-reply@beesavy.com',
        );
        $this->db->insert('email', $data);
    }
}
?>
