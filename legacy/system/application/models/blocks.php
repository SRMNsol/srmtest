<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Blocks Model
 */
class Blocks extends Model
{
    protected $container;

    public function Blocks()
    {
        parent::Model();

        $this->load->helper('bridge');
        $this->load->helper('escape');
        $this->container = silex();
    }

    public function getBlocks($method = "default")
    {       
        $method = $this->router->method;
        $class = $this->router->class;
        $banner = $this->get_banner();
        
        $categories = cached_categories();
       
	   $sql = 'SELECT referral_status FROM user WHERE id = 157476 ';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $refon=$result[0];
		 /*
        echo"<pre>"; print_r($categories); exit;
        $categories='';
         * 
         */
        
        
        $data['banner'] = $this->parser->parse($banner['page'], $banner['vars'],TRUE);
        if ($class=="product" && $method =="compare") {
            //$data['header'] = $this->parser->parse('blocks/header_compare',array(), TRUE);
            $data['header'] = $this->parser->parse('blocks/header',array(), TRUE);
        } elseif ($class=="stores" && $method =="details") {
            //$data['header'] = $this->parser->parse('blocks/header_compare',array(), TRUE);
            $data['header'] = $this->parser->parse('blocks/header',array(), TRUE);
        } elseif ($class=="cashback") {
            $data['header'] = $this->parser->parse('blocks/header_account',array(), TRUE);
        } elseif ($class=="tools") {
            $data['header'] = $this->parser->parse('blocks/header_tools',array(), TRUE);
        } elseif ($class=="account") {
            $data['header'] = $this->parser->parse('blocks/header_account',array(), TRUE);
        } elseif ($class=="stores" && $method =="storelist") {
            //$data['header'] = $this->parser->parse('blocks/header_sitemap',array(), TRUE);
            $data['header'] = $this->parser->parse('blocks/header',array(), TRUE);
             $data['nav_bar'] = $this->parser->parse('blocks/nav_bar',array('categories' => $categories,'refon' => $refon), TRUE);
        } elseif ($class=="info") {
            //$data['header'] = $this->parser->parse('blocks/header_info',array(), TRUE);
            $data['header'] = $this->parser->parse('blocks/header_admin',array(), TRUE);
            $data['nav_bar'] = $this->parser->parse('blocks/nav_bar_admin',array(), TRUE);
            $data['left_nav'] = $this->parser->parse('blocks/left_nav',array(), TRUE);
        } else {
            $data['header'] = $this->parser->parse('blocks/header',array(), TRUE);
            $data['nav_bar'] = $this->parser->parse('blocks/nav_bar',array('categories' => $categories, 'refon' => $refon), TRUE);
        }
        //$data['nav_bar'] = $this->parser->parse('blocks/nav_bar',array('categories' => $categories), TRUE);
        $data['footer'] = $this->parser->parse('blocks/footer',array(), TRUE);
        $data['footer_script'] = $this->parser->parse('blocks/footer_script',array(), TRUE);

        return $data;
    }

    /*Content to show based on user login status*/
    public function get_banner()
    {
        $login_status = $this->db_session->userdata('login');
        if ($login_status) {
            return array('page'=>'blocks/banner_user','vars'=>$login_status);
        } else {
            return array('page'=>'blocks/banner','vars'=>array());
        }
    }
}
