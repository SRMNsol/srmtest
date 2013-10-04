<?php
/**
 */
class Coupon extends Controller {

	function Coupon()	{
		parent::Controller();
        $this->load->library('simple');
        $this->load->library('beesavy');
        parse_str($_SERVER['QUERY_STRING'],$_GET);
        $css = array('pagination.css', 'scroll-styles/jScrollPane.css',
            'shopping.css', 'results.css', 'jquery/scroll.css','product.css');
        $js = array('jquery/jquery_004.js', 'jquery/jquery-ui.js',
            'scroll-scripts/jquery-1.2.6.min.js', 
            'scroll-scripts/jquery.mousewheel.js',
            'scroll-scripts/jScrollPane.js',
            'jquery/jquery.pagination.js');
        $page_script = 'pagescript/coupon.php';
        $title = "BeeSavy";
        $description = "Save money on millions of products from thousands of top online stores at beesavy.com with comparison shopping, cash back, and coupons.";
        $page_info = array('css'=>$css,'js'=>$js,'title'=>$title,'description'=>$description,
            'page_script'=>$page_script);
        $this->page_info = $page_info;
	}

    function _get_list(){
        $q = "select * from store;";
        $res = $this->db->query($q);
        $res = $res->result_array();
        return $res;
    }

    function index(){
    }

    function search(){
        $sort = $this->input->get('sort');
        //Grab information
        $page = $this->input->get('page');
        $limit = $this->input->get('limit');
      
        //Set defaults
        if(!$page){$page=1;}
        if(!$sort){$sort='';}
        if(!$limit){$limit=25;}
        
        //Run the search query
		$search_results = $this->beesavy->listCoupon('',$page,$sort,$limit);
		$search_results2 = $this->beesavy->listStore('','','', 10,'');
        $store_list = $this->_get_list();
		$store_search = $this->beesavy->listStore('','','','','');
        $stores = $store_search['stores'];
        $count = $search_results['meta']['count'][0];
        $coupons = $search_results['coupons'];

        foreach($coupons as &$coupon){
            if($coupon['code']!=''){
                $coupon['action_text']='CLICK TO COPY';
            }else{
                $coupon['action_text']='CLICK TO ACTIVATE';
            }
        }

        //Load the page
        $data = $this->blocks->getBlocks();
        $data['count']=$count;
        $data['start']=($page-1)*$limit+1;
        $end = ($page)*$limit;
        if($end>$count)
            $end = $count;
        $data['end']=$end;
        $data['page']=$page;
        $data['page_index']=$page-1;
        $data['limit']=$limit;
        $data['sort']=$sort;
        $data['stores']=$stores;
        $data['coupons']=$coupons;
        $data['store_list']=$store_list;
        
        $this->load->vars($data);
        $this->parser->parse('coupon/coupon_search', $data);
    }



}
?>
