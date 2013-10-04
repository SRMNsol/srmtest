<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends Model {

	function Admin() {
		parent::Model();
        $this->load->helper('file');
        $this->load->library('simple');
        $this->_assign_libraries();
        $this->settings_file = __DIR__ . "/../resource/admin_settings.xml";
        $this->loadxml();
	}
    function loadxml(){
        $data = read_file($this->settings_file);
        $this->xml = simplexml_load_string($data);
        $fields = array(
            'default_user'=>'default_user',
            'default_id'=>'default_id',
            'min_activity'=>'min_activity'
        );
        $settings = $this->simple->simpleAPI("admin", $fields, $this->xml);
        $this->settings = $settings[0];
    }
    function getSettings(){
        $this->loadxml();
        return $this->settings;
    }
    function getUsers(){
        $this->db->order_by('email', 'asc');
        $users = $this->db->get('user');
        $users = $users->result_array();
        return $users;
    }
    function setDefault($default){
        $default = addslashes($default);
        $res = $this->db->get_where('user',array('email'=>$default));
        $res = $res->result_array();
        if(!empty($res)){
        $this->xml->admin->default_user = $default;
        $this->xml->admin->default_id = $res[0]['id'];
        $this->xml->asXML($this->settings_file);
        }
    }
    function setActivity($activity){
        $activity = addslashes($activity);
        $this->xml->admin->min_activity = $activity;
        $this->xml->asXML($this->settings_file);
    }
    function getDefault(){
        return $this->settings['default_user'];
    }
    function getDefaultId(){
        return $this->settings['default_id'];
    }
}
?>
