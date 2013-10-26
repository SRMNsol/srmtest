<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Extrabux Library
 *
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		Jonny Simkin
*/
class Extrabux
{
    protected $db;

    public function __construct()
    {
        $ci = get_instance();
        $ci->load->database();
        $this->db = $ci->db;
    }

    public function getUser($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }

    protected function getUserRawData($id, $type)
    {
        $user = $this->getUser($id);
        $raw_data = json_decode($user['raw_data'], true);

        return $raw_data[$type];
    }

    public function getUserReferrals($id)
    {
        return $this->getUserRawData($id, 'referrals');
    }

    public function getUserReport($id)
    {
        return $this->getUserRawData($id, 'report');
    }

    public function getUserStats($id)
    {
        return $this->getUserRawData($id, 'stats');
    }

    public function __call($method, $args)
    {
        throw new Exception("Deprecated method Extrabux::$method");
    }
}
