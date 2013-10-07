<?php
/**
 */
class Product extends Controller
{
    protected $container;

    public function Product()
    {
        parent::Controller();
        $this->load->model('refer');
        parse_str($_SERVER['QUERY_STRING'],$_GET);

        $this->load->helper('bridge');
        $this->load->helper('escape');
        $this->container = silex();
    }

    public function index()
    {
    }

    public function check_store($store)
    {
        $this->load->helper('url');
        $arr = array('name'=>$store);
        $res = $this->db->get_where('store', $arr);
        $res = $res->result_array();
        if (!empty($res)) {
            redirect('/stores/details/'.$res[0]['id']);
        }
    }

    public function search()
    {
        //Grab information
        $search = $this->input->get('q');
        $category = $this->input->get('category') ?: null;
        $brand = $this->input->get('brand') ?: null;
        $page = $this->input->get('page');
        $sort = $this->input->get('sort');
        $limit = $this->input->get('limit');
        $zip = $this->input->get('zip');

        //Set defaults
        if (!$page) {$page=1;}
        if (!$limit) {$limit=25;}
        if (!$sort) {$sort="score desc";}

        $this->check_store($search);

        //Run the search query
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];

        $result = $client->findProducts($catalogs['all_stores'], $search, [
            'brand_id' => $brand,
            'merchant_type_id' => $category,
            'product_sort' => $sort,
            'product_offset' => ($page - 1) * $limit,
            'product_limit' => $limit,
        ]);

        $brands = serialize_brands($result->getBrands());
        $categories = serialize_merchant_types($result->getMerchantTypes());
        $products = serialize_products($result->getProducts());
        $count = $result->getProducts()->getTotalCount();

        //Load the page
        $data = $this->blocks->getBlocks();
        $data['search']=$search;
        $data['zip']=$zip;
        $data['count']=$count;
        $data['start']=($page-1)*$limit+1;
        $end = ($page)*$limit;
        if($end>$count)
            $end = $count;
        $data['end']=$end;
        $data['sort'] = $sort;
        $data['brands']=$brands;
        $data['brand'] = $brand;
        $data['categories']=$categories;
        $data['category'] = $category;

        $data['page']=$page;
        $data['page_index']=$page-1;
        $data['limit']=$limit;
        $data['products']=$products;
        $data['base_url'] = "/product/search?q=$search";
        $data['query_string']=array('search'=>$search,'category'=>$category,
            'brand'=>$brand,'page'=>$page,'sort'=>$sort);

        if ($count==0) {
            $this->parser->parse('product/noproduct', $data);

            return;
        }
        $this->parser->parse('product/search', $data);
    }

    public function _ischecked(&$brands, $checked)
    {
        foreach ($brands as &$brand) {
            $name = $brand['name'];
            if (in_array($name, $checked)) {
                $brand['checked'] = "checked='yes'";
            } else {
                    $brand['checked'] = "";
            }
        }
    }

    public function compare($group_id)
    {
        //Run the search query
        $zip = $this->input->get('zip');
        $results = $this->cache->library('beesavy', 'compareprices', array($group_id, $zip), 3600);
        $this->load->helper('url');
        //Load the page
        $data = $this->blocks->getBlocks();
        $data['compare']=$results;
        $data['id']=$group_id;
        $data['zip'] = $zip;
        $this->parser->parse('product/compare', $data);
    }
    public function category()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        //$this->cache->delete_all();

        //Grab information
        $category = $this->input->get('category');
        $brand = $this->input->get('brand');
        $brandarr = explode("__", $brand);
        $page = $this->input->get('page');
        $sort = $this->input->get('sort');
        $limit = $this->input->get('limit');

        //Set defaults
        if (!$page) {$page=1;}
        if (!$limit) {$limit=10;}

        //Run the search query
        $q='';
        $search_results = $this->cache->library('beesavy', 'productsearch', array('',$page,$category,$brandarr,$limit,$sort), 3600);
        $brands = $search_results['metadata']['brands'];
        $categories = $search_results['metadata']['categories'];
        $products = $search_results['products'];
        $this->beesavy->abreviate($products, 'description', 100);
        $count = $search_results['metadata']['count'];
        $category_tree = $this->cache->library('beesavy', 'getCategory', array($category), 3600);
        $stores = array_slice($category_tree['stores'], 0, 10);
        $this->_ischecked($brands, $brandarr);

        //Load the page
        $data = $this->blocks->getBlocks();
        $data['count']=$count;
        $data['brands']=$brands;
        $data['categories']=$categories;
        $data['category'] = $category_tree['name'];
        $data['stores'] = $stores;
        $data['sort'] = $sort;
        $data['page']=$page;
        $data['limit']=$limit;
        $data['page_index']=$page-1;
        $data['products']=$products;
        $data['chosen_brands']=array();
        $data['category_tree'] = $category_tree;
        $data['base_url'] = "/product/category?";
        $data['query_string']=array('search'=>'','category'=>$category,'brand'=>$brand,'page'=>$page,'sort'=>$sort);

        $this->parser->parse('product/category_search', $data);
    }
}
