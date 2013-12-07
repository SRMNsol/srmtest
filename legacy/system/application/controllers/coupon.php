<?php
/**
 */
class Coupon extends Controller
{
    protected $container;

    public function Coupon()
    {
        parent::Controller();
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

        $this->load->helper('bridge');
        $this->load->helper('escape');
        $this->container = silex();
    }

    public function _get_list()
    {
        $q = "select * from store;";
        $res = $this->db->query($q);
        $res = $res->result_array();

        return $res;
    }

    public function index()
    {
    }

    public function search()
    {
        $sort = $this->input->get('sort');
        //Grab information
        $page = $this->input->get('page');
        $limit = $this->input->get('limit');

        //Set defaults
        if (!$page) {$page=1;}
        if (!$sort) {$sort='';}
        if (!$limit) {$limit=25;}

        //Run the search query
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();
        $subid = create_subid($this->user_id);

        $catalogKey = $catalogs['all_stores'];
        $params = [
            'deal_limit' => $limit,
            'deal_offset' => ($page - 1) * 25,
        ];

        switch ($sort) {
            case 'free_shipping' :
                $params += ['deal_type_id' => 1];
                break;
            case 'expire_soon' :
                $params += [
                    'end_on_max' => (new DateTime('1 week'))->format('m/d/Y'),
                ];
                break;
            case 'hot_coupons' :
                $catalogKey = $catalogs['hot_coupons'];
                break;
        }

        $result = $client->findDeals($catalogKey, $params);
        $stores = result_merchants($result->getMerchants(), $rate, $subid);
        $count = $result->getDeals()->getTotalCount();
        $coupons = result_deals($result->getDeals(), $rate, $subid);

        foreach ($coupons as &$coupon) {
            if ($coupon['code']) {
                $coupon['action_text']='CLICK TO COPY';
            } else {
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
        $data['store_list']=$stores;

        $this->load->vars($data);
        $this->parser->parse('coupon/coupon_search', $data);
    }

}
