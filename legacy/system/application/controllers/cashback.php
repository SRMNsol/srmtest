<?php
/**
 */
class Cashback extends Controller {

	function Cashback()	{
		parent::Controller();
        $this->load->library('beesavy');
        $this->load->model('user');
        $this->user_id = $this->user->get_field('id');
	}

    function __get_header(&$data){
        if(!$this->user->login_status()){
            redirect('main/signin?user=&code=20');
        }
        $blocks = $this->blocks->getBlocks();
        $data2 = $this->beesavy->getUser($this->user_id, '', TRUE);
        $data = array_merge($data, $data2);
        $data = array_merge($data, $blocks);
        $data =array_merge($data, $this->user->info());
    }

    function index(){
		$data = $this->cache->library('beesavy', 'getUserStats', array($this->user_id), 3600);
        $this->__get_header($data);
        #Have columns: Month, Type, Status, Cash Back, Payment date
        $transactions = $data['transactions'];
        foreach($transactions as &$trans){
            $month = $trans['created'];
            $type  = "Personal";
            $status = $trans['status'];
            $cashback = $trans['cashback'];
            if($status == "Paid"){
                $payment = $trans['date'];
            }else{
                $payment = 'N/A';
            }
            $trans = array(
                'month'=>$month,
                'transtype'=>$type,
                'status'=>$status,
                'cashback'=>$cashback,
                'date'=>$payment
            );
        }
        $data['transactions'] = $transactions;

        $reftransactions = $data['reftransactions'];
        $newref = array();
        foreach($reftransactions as &$trans){
            $month = $trans['date'];
            $type  = "Referral Total";
            $payment = 'N/A';
            $stati = array("Paid"=>"referralpaid",
                "Pending"=>"referralpending",
                "Available"=>"referralavailable");
            foreach($stati as $k=>$v){
                if($trans[$v]!="0.00"){
                    $newref[] = array(
                        'month'=>$month,
                        'transtype'=>$type,
                        'status'=>$k,
                        'cashback'=>$trans[$v],
                        'date'=>$payment
                    );
                }
            }

        }
        $data['reftransactions'] = $newref;

        $this->parser->parse('cashback/base', $data);
    }
    function personal(){
        $data = $this->beesavy->getUserStats($this->user_id);
        $this->__get_header($data);
        $data['type'] = "personal";
        $this->parser->parse('cashback/base', $data);
    }
    function referral(){
        $data = $this->beesavy->getUserStats($this->user_id);
        $this->__get_header($data);
        $data['type'] = "referral";

        $reftransactions = $data['reftransactions'];
        $newref = array();
        foreach($reftransactions as &$trans){
            $date = $trans['date'];
            $level = "Referral Total";
            $status = "";
            $cashback = 0;
            $stati = array("Paid"=>"referralpaid",
                "Pending"=>"referralpending",
                "Processing"=>"referralprocessing",
                "Available"=>"referralavailable");
            foreach($stati as $k=>$v){
                $cashback += (float) $trans[$v];
                if($trans[$v] != "0.00" && !$status){
                    $status = $k;
                }else if($trans[$v] != "0.00" && $status){
                    $status = "Mixed";
                }
            }
            if($cashback!=0){
                $newref[] = array(
                    'date'=>$date,
                    'level'=>$level,
                    'status'=>$status,
                    'cashback'=>number_format($cashback, 2)
                );
            }
            if($cashback!=0){
                $levi = array('Level 1'=>'referralcommissiondirect',
                    'Level 2-7'=>'referralcommissionindirect');
                foreach($levi as $lev=>$lev_index){
                    $newref[] = array(
                        'date'=>$date,
                        'level'=>$lev,
                        'status'=>$status,
                        'cashback'=>$trans[$lev_index]
                    );
                }
            }
        }
        $data['reftransactions'] = $newref;
        $this->parser->parse('cashback/base', $data);
    }
}
?>
