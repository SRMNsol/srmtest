<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Email Sender
 */
class EmailSender
{
    private $ci; // CI Instance

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->library('email');

        $this->ci->load->config('email');
        $this->ci->email->initialize($this->ci->config->item('email'));
    }

    public function send($to = '',$subject = 'Beesavy',$body = '')
    {
        $this->ci->email->from('postmaster@beesavy.com', 'Beesavy');
        $this->ci->email->to($to);
        // $this->ci->email->cc('another@another-example.com');
        // $this->ci->email->bcc('them@their-example.com');
        $this->ci->email->subject($subject);
        $this->ci->email->message($body);

        $this->ci->email->send();
    }
}