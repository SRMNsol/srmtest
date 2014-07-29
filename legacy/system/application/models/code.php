<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Code extends Model
{
    public $errors = array(
        0 =>'Error',
        18=>'User account already exists',
        19=>'System cannot execute this action currently',
        20=>'Could not validate login credentials',
        21=>'Passwords did not match',
        22=>'Referral ID not found',
        23=>'Password must be at least 6 characters',
        24=>'Invalid email',
        25=>'Invalid password',
        30=>'Account error',
        31=>'Alias must be at least 3 characters including 1 alphabetical character',
        32=>'Alias mismatch',
        33=>'Email mismatch',
        34=>'Enter all checking information',
        35=>'Enter all paypal information',
        36=>'Enter all charity information',
        37=>'Already in use',
    );
    public $codes = array(
        'fail'=>18,
        'in_use'=>37,
        'general_login'=>20,
        'password_mismatch'=>21,
        'invalid_referral'=>22,
        'password_length'=>23,
        'invalid_email'=>24,
        'invalid_password'=>25,
        'general_account'=>30,
        'alias_format'=>31,
        'alias_mismatch'=>32,
        'email_mismatch'=>33,
        'check_error'=>34,
        'paypal_error'=>35,
        'charity_error'=>36
    );

    public function Code()
    {
        parent::Model();
    }

    public function get_code($str)
    {
        if (array_key_exists($str, $this->codes)) {
            return $this->codes[$str];
        } else {
            return '0';
        }
    }
    public function get_errors($codes)
    {
        if(empty($codes))

            return array();
        $arr = array();
        foreach ($codes as $code) {
            $arr[] = array('message'=>$this->get_error($code));
        }

        return $arr;
    }
    public function get_error($str)
    {
        if($str)

        return($this->errors[$str]);
    }
}
