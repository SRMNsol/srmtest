<?php
/**
 */
class Periodic_Email extends Controller {

    function Periodic_Email(){
		parent::Controller();
        $this->load->library('beesavy');
        $this->load->model('emailer');
        $this->load->model('user');
        $this->load->helper('s3');
    }
    function index(){
        //Check for 7 day offer email
        $sql = "select * from user where date(created)+Interval 14 day < current_date and email_refer_info=0";
        $q = $this->db->query($sql);
        $res = $q->result_array();
        foreach($res as $r){
            $id = $r['id'];
            $email = $r['email'];
            $sql = "update user set email_refer_info = 1 where id='$id';";
            $this->db->query($sql);
            $data = array('email'=>$email);
            $msg = $this->parser->parse('email/cbinfo', $data, True);
            $tmsg = $this->parser->parse('email/cbinfot', $data, True);
            $this->emailer->sendMessage($msg, $tmsg, $data['email'], "Share the buzz on BeeSavy.");
        }

        //Update any last_casshback =0
        $sql = "select * from user where date(last_cashback)+Interval 60 day < current_date and email_60 = 0 and purchase_exempt=0 and last_cashback!=0;";
        $q = $this->db->query($sql);
            $stats = $this->beesavy->getUserStats(88481);

        $res = $q->result_array();
        return;
        foreach($res as $r){
            $id = $r['id'];
            $email = $r['email'];
            $data =$this->user->ebinfo_user($id);
            $stats = $this->beesavy->getUserStats($id);
            $data['cashback']= $stats['total'][0]['referralavailable'];
            $sql = "update user set email_60 = 1 where id='$id';";
            $this->db->query($sql);
            $msg = $this->parser->parse('email/60day', $data, True);
            $tmsg = $this->parser->parse('email/60dayt', $data, True);
            $this->emailer->sendMessage($msg, $tmsg, $data['email'], "Congratulations! You have referral cash back.");

        }
        //Check for 83 daqy inactivity
        $sql = "select * from user where date(last_cashback)+Interval 83 day < current_date and email_83 = 0 and purchase_exempt=0 and last_cashback!=0;";
        $q = $this->db->query($sql);
        $res = $q->result_array();
        foreach($res as $r){
            $id = $r['id'];
            $email = $r['email'];
            $data =$this->user->ebinfo_user($id);
            $stats = $this->beesavy->getUserStats($id);
            $data['cashback']= $stats['total'][0]['referralavailable'];
            $sql = "update user set email_83 = 1 where id='$id';";
            $this->db->query($sql);
            $msg = $this->parser->parse('email/83day', $data, True);
            $tmsg = $this->parser->parse('email/83dayt', $data, True);
            $this->emailer->sendMessage($msg, $tmsg, $data['email'], "Congratulations! You have referral cash back.");

        }
    }
}
?>
