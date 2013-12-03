<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Model
{
    public function Admin()
    {
        parent::Model();
        $this->load->helper('file');
        $this->load->library('simple');
        $this->_assign_libraries();
        $this->settings_file = __DIR__ . "/../resource/admin_settings.xml";
        $this->loadxml();
    }

    public function loadxml()
    {
        $data = read_file($this->settings_file);
        $this->xml = simplexml_load_string($data);
        $fields = array(
            'default_user' => 'default_user',
            'default_id'   => 'default_id',
            'min_activity' => 'min_activity'
        );
        $settings = $this->simple->simpleAPI("admin", $fields, $this->xml);

        // override default_id with user:uid
        $query = $this->db->get_where('user', array('email' => $settings[0]['default_user']));
        $res = $query->result_array();
        if (empty($res)) {
            throw new \Exception('Invalid user');
        }

        $settings[0]['default_id'] = $res[0]['uid'];

        $this->settings = $settings[0];
    }

    public function getSettings()
    {
        $this->loadxml();

        return $this->settings;
    }

    public function getUsers()
    {
        $this->db->order_by('email', 'asc');
        $users = $this->db->get('user');
        $users = $users->result_array();

        return $users;
    }

    public function setDefault($default)
    {
        $default = addslashes($default);
        $res = $this->db->get_where('user',array('email'=>$default));
        $res = $res->result_array();
        if (!empty($res)) {
            $this->xml->admin->default_user = $default;
            $this->xml->admin->default_id = $res[0]['id'];
            $this->xml->asXML($this->settings_file);
        }
    }

    public function setActivity($activity)
    {
        $activity = addslashes($activity);
        $this->xml->admin->min_activity = $activity;
        $this->xml->asXML($this->settings_file);
    }

    public function getDefault()
    {
        return $this->settings['default_user'];
    }

    public function getDefaultId()
    {
        return $this->settings['default_id'];
    }
}
