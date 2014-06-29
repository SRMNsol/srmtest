<?php
/**
 */
class Refer extends Controller {

	function Refer()	{
		parent::Controller();
        $this->load->helper('url');
        $this->load->model('user');
        $this->load->helper('s3');
	}

    function r($id){
        if(is_numeric($id)){
            $sql = "select * from refer where id=$id;";
            $res = $this->db->query($sql);
            $res = $res->result_array();
            $res = $res[0];
            $alias = $res['ref_id'];
            if(empty($res)){
                show_404();
            }else{
                $this->user->set_referral($alias);
            }
            redirect($res['url']);
        }
        show_404();
    }
    function ref($alias){
        #check if valid alias
        $alias = addslashes($alias);
        if(is_numeric($alias)){
        $sql = "select * from user where id='$alias';";
        }else{
        $sql = "select * from user where alias='$alias';";
        }
        $res = $this->db->query($sql);
        $res = $res->result_array();
        if(empty($res)){
            show_404();
        }else{
            $this->user->set_referral($alias);
            redirect("");
        }
    }
    function base($id){
        if(is_numeric($id)){
            redirect('');
        }
        show_404();
    }
}
?>
