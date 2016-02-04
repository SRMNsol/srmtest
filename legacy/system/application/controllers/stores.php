<?php
/**
 * Stores controller
 */
class Stores extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('bridge');
        $this->container = silex();
    }

    public function details($id)
    {
        // Coupons paging
        $page = $this->input->get('page') ?: 1;
        $limit = 25;

        //Run the search query
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();
        $topStores = $this->container['orm.em']->getRepository('App\Entity\Merchant')->getTopStores();

        $merchant = $this->container['orm.em']->getRepository('App\Entity\Merchant')->getActiveMerchant($id);
        if ($merchant === null) {
            show_404();
        }

        $topStores = random_slice(result_merchants($topStores, $rate), 8);
        $store = current(result_merchants([$merchant], $rate));

        $store['coupons'] = [];
        $store['restrictions'] = null;

        // pagination data
        $start = (($page - 1) * $limit) + 1;
        $count = 0;
        $end = ($start + $limit - 1 < $count) ? $start + $limit - 1 : $count;

        //Load the page
        $data = $this->blocks->getBlocks();
        $data['top_stores'] = $topStores;
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
        $page = $this->input->get('page') ?: 1;
        $sort = $this->input->get('sort');
        $limit = $this->input->get('limit') ?: 25;

        //Show all stores when search by letter
        $showAll = $search != '';

        //Run the search query
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();

        $merchants = $this->container['orm.em']->getRepository('App\Entity\Merchant')->getActiveMerchants();
        $allStores = result_merchants($merchants, $rate);

        if ($category > 0) {
            $merchants = $this->container['orm.em']->find('App\Entity\Category', $category)->getActiveMerchants()->toArray();
        }

        $merchants = merchants_filter_prefix($merchants, $search === '0' ? '*' : $search);

        if ($showAll) {
            $limit = count($merchants);
        }

        $stores = result_merchants($showAll ? $merchants : array_slice($merchants, $limit * ($page - 1), $limit), $rate);
        $categories = cached_categories();
        $count = count($merchants);

        //Load the page
        $data = $this->blocks->getBlocks();

        $data['search'] = $search;
        $data['category'] = $category;
        $data['categories'] = $categories;
        $data['count'] = $count;
        $data['page'] = $page;
        $data['page_index'] = $page-1;
        $data['limit'] = $limit;
        $data['start'] = ($page-1)*$limit+1;
        $end = ($page)*$limit;
        if ($end > $count) {
            $end = $count;
        }
        $data['end'] = $end;
        $data['stores'] = $stores;
        $data['store_list'] = $allStores;
        $data['base_url'] = "/stores/search?q=$search";
        $data['query_string'] = ['search' => $search, 'page' => $page, 'sort' => $sort];

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
        $page = 1;
        $limit = 1000;
        $sort = '';

        //Run the search query
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();

        $merchants = $this->container['orm.em']->getRepository('App\Entity\Merchant')->getActiveMerchants();
        $merchants = merchants_filter_prefix($merchants, $search === '0' ? '*' : $search);

        $stores = result_merchants($merchants, $rate);

        $count = count($stores)/3;
        $split = array_chunk($stores,$count);

        //Load the page
        $data = $this->blocks->getBlocks();

        $data['search'] = $search;
        $data['stores1'] = $split[0];
        $data['stores2'] = $split[1];
        $data['stores3'] = $split[2];

        $this->load->vars($data);
        $this->parser->parse('store/list', $data);
    }
}
