<?php
/**
 */
class Admin_Panel extends Controller {

	function Admin_Panel()	{
		parent::Controller();
        $this->load->library('beesavy');
        $this->load->helper('url');
        $this->load->model('admin');
        $this->load->model('user');
	}

    function _remap($method){
        $admin = $this->user->is_admin();
        if($admin){
            $this->$method();
            return;
        }
        redirect('error');
    }

    function index(){
        $users = $this->admin->getUsers();
        $settings = $this->admin->getSettings();
        $settings['users'] = $users;
        $this->parser->parse('admin/admin', $settings);
    }


    function setDefault(){
        $default = $this->input->get('user');
        $this->admin->setDefault($default);
        $this->index();
    }
    function setActivityLevel(){
        $min = $this->input->get('min');
        $this->admin->setActivity($min);
        $this->index();
    }
    function user_info(){
        $id = $this->input->get('id');
        $info = $this->beesavy->getUser($id, '', True);
        $info =array_merge($info, $this->user->info_user($id));
        $this->parser->parse('admin/user_setting', $info);
        print_r($info);
    }
    function set_setting(){
        $setting =$this->input->post('setting');
        $value =$this->input->post('value');
        $id = $this->input->post('id');
        if($value=="on"){
            $value = 1;
        }else{
            $value = 0;
        }
        $this->user->set_setting_user($setting, $value, $id);
    }
    function set_setting_text(){
        $setting =$this->input->post('setting');
        $value =$this->input->post('value');
        $id = $this->input->post('id');
        $this->user->set_setting_user($setting, $value, $id);
    }

}
?>
