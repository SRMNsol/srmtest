<?php
/**
 */
class Stores extends Controller
{
    public function Stores()
    {
        parent::Controller();
        parse_str($_SERVER['QUERY_STRING'],$_GET);
        $this->load->helper('bridge');
        $this->container = silex();
    }

    public function details($id)
    {
        // Coupons paging
        $page = $this->input->get('page') ?: 1;
        $limit = 25;

        //Run the search query
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();
        $topStores = $this->container['orm.em']->getRepository('App\Entity\Merchant')->getTopStores();

        $result = $client->findMerchants($catalogs['all_stores'], ['merchant_id' => $id, 'deal_limit' => 100]);
        $store_search = random_slice(result_merchants($topStores, $rate), 8);
        $store = current(result_merchants($result->getMerchants(), $rate));

        $store['coupons'] = result_deals($result->getDeals(), $rate, null, $page, $limit);
        $store['restrictions'] = null;

        // pagination data
        $start = (($page - 1) * $limit) + 1;
        $count = $result->getDeals()->count();
        $end = ($start + $limit - 1 < $count) ? $start + $limit - 1 : $count;

        $top_stores = $store_search;
        foreach ($store['coupons'] as &$coupon) {
            if ($coupon['code']!='') {
                $coupon['action_text']='CLICK TO COPY';
            } else {
                $coupon['action_text']='CLICK TO ACTIVATE';
            }
        }

        //Load the page
        $data = $this->blocks->getBlocks();
        $data['top_stores'] = $top_stores;
        $data['store'] = $store;
        $data['id'] = $id;
        $data['store_name'] = $store['name'];
        $data['description'] = $store['description'];
        $data['restrictions'] = $store['restrictions'];
        $data['logo_thumb'] = $store['logo_thumb'];
        $data['cashback_text'] = $store['cashback_text'];
        $data['link'] = $store['link'];
        $data['coupons'] = $store['coupons'];

        // coupons pagination
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['start'] = (($page - 1) * $limit) + 1;
        $data['end'] = $end;
        $data['count'] = $count;

        $this->load->vars($data);
        $this->parser->parse('store/store', $data);
    }

    public function search()
    {
        //Grab information
        $search = $this->input->get('q');
        $category = $this->input->get('category');
        $page = $this->input->get('page');
        $sort = $this->input->get('sort');
        $limit = $this->input->get('limit');

        //Show all stores when search by letter
        $showAll = $search != '';

        //Set defaults
        if (!$page) { $page = 1; }
        if (!$limit) { $limit = 25; }

        //Run the search query
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();

        $params = [];
        if ($category > 0) {
            $params['merchant_type_id'] = $category;
        }

        $result = $client->findMerchants($catalogs['all_stores'], $params);
        $merchants = $result->getMerchants()->sortByMerchantName();
        $allStores = result_merchants($merchants, $rate);

        $merchants = $merchants->filterByNamePrefix($search === '0' ? '*' : $search);

        if ($showAll) {
            $limit = $merchants->count();
        }

        $stores = result_merchants($showAll ? $merchants : $merchants->slice($limit * ($page - 1), $limit), $rate);
        $merchantTypes = result_merchant_types($result->getMerchantTypes());
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
        $data['store_list'] = $allStores;
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
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();

        $result = $client->findMerchants($catalogs['all_stores']);
        $merchants = $result->getMerchants()
            ->sortByMerchantName()
            ->filterByNamePrefix($search === '0' ? '*' : $search);
        $stores = result_merchants($merchants, $rate);

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
