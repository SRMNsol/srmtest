<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Emailer
 */
class Emailer extends Model
{
    protected $container;

    public function Emailer()
    {
        parent::Model();
        $ci = get_instance();
        $ci->load->helper('bridge');
        $this->container = silex();
    }

    public function sendMessage($message, $txt_message, $email, $title="BeeSavy")
    {
        $data = array('title'=>$title,
            'message'=>$message,
            'txt_message'=>$txt_message,
            'to_addr'=>$email,
            'from_addr'=>'no-reply@beesavy.com',
        );
        $this->db->insert('email', $data);

        $message = Swift_Message::newInstance();
        $message->setSubject($data['title']);
        $message->setFrom($data['from_addr']);
        $message->setTo($data['to_addr']);
        $message->setBody($data['txt_message']);

        if ($data['message'] !== null) {
            $message->addPart($data['message'], 'text/html');
        }

        $this->container['mailer']->send($message);

        $spool = $this->container['swiftmailer.spooltransport']->getSpool();
        $spool->flushQueue($this->container['swiftmailer.transport']);
    }
}
