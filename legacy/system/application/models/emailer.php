<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Emailer
 */
class Emailer extends Model
{
    protected $container;
    protected $mailer;

    public function Emailer()
    {
        parent::Model();
        $ci = get_instance();
        $ci->load->helper('bridge');
        $this->container = silex();
        $this->mailer = $this->container['mailer'];
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
        $message->addPart($data['message'], 'text/html');

        $this->mailer->send($message);
    }
}
