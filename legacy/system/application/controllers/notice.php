<?php
/**
 */
class Notice extends Controller
{
    public function Notice()
    {
        parent::Controller();
        $this->load->library('EmailSender');
        $this->load->model('twitter');
        $this->load->model('facebook');

    }

    public function index()
    {
        echo base_url();
    }

    public function _format_money($str)
    {
        if (strstr($str, ".")) {
            $num = (float) $str * 100;
            $str = (string) $num;
        } else {
            $num = (float) $str;
            $str = (string) $num/100;
        }
        $str = sprintf("%01.2f", $str);

        return $str;
    }
    public function test()
    {
        echo $this->_format_money($this->_half(10));
        echo "<br />";
        echo $this->_format_money("-10");
        echo "<br />";
        echo $this->_format_money("1000");
        echo "<br />";
        echo $this->_format_money("100");
    }
    public function _half($str)
    {
        $str = (float) $str;
        $str = $str;

        return number_format($str);
    }

    public function cashback()
    {
        #user info
        $id = $data['user_id'] = $this->input->post('user_id');
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');

        #order info
        $data['order_id'] = $this->input->post('order_id');
        $data['merchant_id'] = $this->input->post('merchant_id');
        $data['merchant_name'] = $this->input->post('merchant_name');
        $data['amount'] = $this->_format_money($this->input->post('amount'));
        $data['cashback_amount'] = $this->_format_money($this->_half($this->input->post('cashback_amount')));
        if ((float) $data['cashback_amount']<0) {
            return;
        }

        //Set Date
        $date = $this->input->post('date');
        $date = DateTime::createFromFormat('Y-m-d G:i:s',$date);
        $date = $date->format('F j, Y');
        $data['date'] = $date;

        //Format money

        $id = addslashes($id);
        $sql = "update user set last_cashback=current_timestamp where id='$id';";
        $this->db->query($sql);

        #Select user
        $sql = "select * from user where id='$id';";
        $q = $this->db->query($sql);
        $res = $q->result_array();
        if (!empty($res)) {
            $email = $res[0]['email'];
            $msg = $this->parser->parse('email/cashback', $data, True);
            $tmsg = $this->parser->parse('email/cashbackt', $data, True);
            $this->emailsender->send($email, "BeeSavy - You've got cash back!",$msg);
            $link = base_url().$res[0]['alias'];
            $this->twitter->post_cashback($data['cashback_amount'], $id, $link);
            $this->facebook->post_cashback($data['cashback_amount'], $id, $link);
        }
    }

    public function referral()
    {
        $id = $this->input->post('user_id');
        $id = addslashes($id);
        $sql = "update user set last_refer=current_timestamp where id='$id';";
        $this->db->query($sql);
    }

}
