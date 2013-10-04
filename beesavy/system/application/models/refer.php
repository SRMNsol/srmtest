<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Refer extends Model {

	function Refer() {
		parent::Model();
        $this->load->helper('url');
	}

    function createReferral($url, $refid){
        $sql = "select max(id) as id from refer";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        $res = $res[0];
        $id = rand(1, 100)+(int)$res['id'];
        $sql = "insert into refer (id, url, ref_id) value "
            ."($id, '$url', '$refid');";
        $this->db->query($sql);
        return $id;
    }
}
?>
