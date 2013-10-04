<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Blocks Model
 */
class Blocks extends Model {
    function Blocks(){
        parent::Model();
    }
    function getBlocks($method = "default"){
        $method = $this->router->method;
        $class = $this->router->class;
        $banner = $this->get_banner();
        $data['banner'] = $this->parser->parse($banner['page'], $banner['vars'],TRUE);
        if($class=="product" && $method =="compare"){
            $data['header'] = $this->parser->parse('blocks/header_compare',array(), TRUE);
        }elseif($class=="stores" && $method =="details"){
            $data['header'] = $this->parser->parse('blocks/header_compare',array(), TRUE);
        }elseif($class=="cashback"){
            $data['header'] = $this->parser->parse('blocks/header_account',array(), TRUE);
        }elseif($class=="tools"){
            $data['header'] = $this->parser->parse('blocks/header_tools',array(), TRUE);
        }elseif($class=="account"){
            $data['header'] = $this->parser->parse('blocks/header_account',array(), TRUE);
        }elseif($class=="stores" && $method =="storelist"){
            $data['header'] = $this->parser->parse('blocks/header_sitemap',array(), TRUE);
        }elseif($class=="info"){
            $data['header'] = $this->parser->parse('blocks/header_info',array(), TRUE);
        }else{
            $data['header'] = $this->parser->parse('blocks/header',array(), TRUE);
        }
        $data['nav_bar'] = $this->parser->parse('blocks/nav_bar',array(), TRUE);
        $data['footer'] = $this->parser->parse('blocks/footer',array(), TRUE);
        return $data;
    }

    /*Content to show based on user login status*/
    function get_banner(){
        $login_status = $this->db_session->userdata('login');
        if($login_status){
            return array('page'=>'blocks/banner_user','vars'=>$login_status);
        }else{
            return array('page'=>'blocks/banner','vars'=>array());
        }
    }
}
?>
