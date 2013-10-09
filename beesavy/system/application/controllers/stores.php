<?php
/**
 */
class Stores extends Controller
{
    public function Stores()
    {
        parent::Controller();
        $this->load->library('beesavy');
        parse_str($_SERVER['QUERY_STRING'],$_GET);
        $this->load->helper('bridge');
        $this->load->helper('escape');
        $this->container = silex();
    }

    public function details($id)
    {
        //Set defaults
        $sort='rank';
        $limit=10;

        //Run the search query
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];

        $result = $client->findMerchants($catalogs['all_stores'], ['merchant_id' => $id]);
        $store_search = random_slice(serialize_merchants($client->findMerchants($catalogs['all_stores'])->getMerchants()), 8);
        $store = current(serialize_merchants($result->getMerchants()));

        $store['coupons'] = serialize_deals($result->getDeals());
        $store['restrictions'] = null;

        $top_stores = $store_search;
        foreach ($store['coupons'] as &$coupon) {
            if ($coupon['code']!='') {
                $coupon['action_text']='CLICK TO COPY';
            } else {
                $coupon['action_text']='CLICK TO ACTIVATE';
            }
        }

        //Make store referral
        $cashback_percent = $store['cashback_percent'];
        $cashback_flat = $store['cashback_flat'];
        if ($cashback_percent>0) {
            $cb = "Shop $cashback_percent% Cash Back";
        } else {
            $cb = "Shop $$cashback_flat Cash Back";
        }

        //Load the page
        $data = $this->blocks->getBlocks();
        $data['top_stores']=$top_stores;
        $data['store']=$store;
        $data['id']=$id;
        $data['store_name']=$store['name'];
        $data['description']=$store['description'];
        $data['restrictions']=$store['restrictions'];
        $data['logo_thumb']=$store['logo_thumb'];
        $data['cashback_text']=$cb;
        $data['link']=$store['link'];
        $data['coupons'] = $store['coupons'];

        $this->load->vars($data);
        $this->parser->parse('store/store', $data);
    }

    public function set_list()
    {
        $search = $this->input->get('q');
        $category = $this->input->get('category');
        $page = $this->input->get('page');
        $sort = $this->input->get('sort');
        $limit = $this->input->get('limit');
        $search_results2 = $this->cache->library('beesavy', 'listStore', array($search,$page,$sort, 10000,$category), 3600);
        $store_list = $search_results2['stores'];
        $q = "delete from store";
        $this->db->query($q);
        foreach ($store_list as $store) {
            $id = addslashes($store['id']);
            $name = addslashes($store['name']);
            $q = "insert into store (id, name) select '$id', '$name';";
            $this->db->query($q);
        }
    }

    public function _get_list()
    {
        $q = "select * from store;";
        $res = $this->db->query($q);
        $res = $res->result_array();

        return $res;
    }

    public function search()
    {
        //Grab information
        $search = $this->input->get('q');
        $category = $this->input->get('category');
        $page = $this->input->get('page');
        $sort = $this->input->get('sort');
        $limit = $this->input->get('limit');

        //Set defaults
        if (!$page) {$page=1;}
        if (!$limit) {$limit=25;}

        //Run the search query
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];

        $params = [];
        if ($category > 0) {
            $params['merchant_type_id'] = $category;
        }

        $result = $client->findMerchants($catalogs['all_stores'], $params);
        $merchants = $result->getMerchants()->filterByNamePrefix($search === '0' ? '*' : $search);
        $stores = serialize_merchants($merchants->slice($limit * ($page - 1), $limit));
        $merchantTypes = serialize_merchant_types($result->getMerchantTypes());
        $count = $merchants->getTotalCount();

        //Load the page
        $data = $this->blocks->getBlocks();

        $data['search']=$search;
        $data['category']=$category;
        $data['categories'] = $merchantTypes;
        $data['count']=$count;
        $data['page']=$page;
        $data['page_index']=$page-1;
        $data['limit']=$limit;
        $data['start']=($page-1)*$limit+1;
        $end = ($page)*$limit;
        if($end>$count)
            $end = $count;
        $data['end']=$end;
        $data['stores']=$stores;
        $data['store_list']=$stores;
        $data['base_url'] = "/stores/search?q=$search";
        $data['query_string']=array('search'=>$search,
            'page'=>$page,'sort'=>$sort);

        $this->parser->parse('store/search', $data);
    }

    public function storelist()
    {
        $search = $this->uri->segment(3);
        if (!isset($search)) {
            $search = "A";
        }
        //Grab information
        $category = "";

        //Set defaults
        $page=1;
        $limit=1000;
        $sort = '';

        //Run the search query
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];

        $result = $client->findMerchants($catalogs['all_stores']);
        $merchants = $result->getMerchants()->filterByNamePrefix($search === '0' ? '*' : $search);
        $stores = serialize_merchants($merchants->slice($limit * ($page - 1), $limit));

        $count = count($stores)/3;
        $split = array_chunk($stores,$count);

        //Load the page
        $data = $this->blocks->getBlocks();

        $data['search']=$search;
        $data['stores1']=$split[0];
        $data['stores2']=$split[1];
        $data['stores3']=$split[2];

        $this->load->vars($data);
        $this->parser->parse('store/list', $data);
    }
}
