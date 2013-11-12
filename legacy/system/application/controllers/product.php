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

        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];

        $matches = $client->findMerchants($catalogs['all_stores'])->getMerchants()->filter(function ($merchant) use ($store) {
            if (strtolower($store) === strtolower($merchant->getName())) {
                return $merchant;
            }
        });

        if ($matches->count() > 0) {
            redirect('/stores/details/' . $matches->current()->getId());
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

        $brands = result_brands($result->getBrands());
        $categories = result_merchant_types($result->getMerchantTypes());
        $products = result_products($result->getProducts());
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

        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];

        $params = [
            'include_deals' => 1,
            'product_sort' => 'price_asc',
        ];

        if (strpos($group_id, '0') === 0) {
            $params['product_id'] = substr($group_id, 1);
        } else {
            $params['product_group_id'] = $group_id;
        }

        $results = comparison_result($client->findProducts($catalogs['all_stores'], null, $params));

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
        //Grab information
        $category = $this->input->get('category') ?: null;
        $brand = $this->input->get('brand') ?: null;
        $page = $this->input->get('page');
        $sort = $this->input->get('sort');
        $limit = $this->input->get('limit');

        //Set defaults
        if (!$page) {$page=1;}
        if (!$limit) {$limit=10;}

        //Run the search query
        $client = $this->container['popshops.client'];
        $catalogs = $this->container['popshops.catalog_keys'];

        $result = $client->findProducts($catalogs['all_stores'], null, [
            'brand_id' => $brand,
            'merchant_type_id' => $category,
            'product_sort' => $sort,
            'product_offset' => ($page - 1) * $limit,
            'product_limit' => $limit,
        ]);

        $brands = result_brands($result->getBrands());
        $stores = random_slice(result_merchants($result->getMerchants()), 10);
        $categories = result_merchant_types($result->getMerchantTypes());
        $products = result_products($result->getProducts());
        $count = $result->getProducts()->getTotalCount();

        //Load the page
        $data = $this->blocks->getBlocks();
        $data['count']=$count;
        $data['brands']=$brands;
        $data['brand'] = $brand;
        $data['categories']=$categories;
        $data['category'] = $category;
        $data['category_name'] = $categories[0]['name'];
        $data['stores'] = $stores;
        $data['sort'] = $sort;
        $data['page']=$page;
        $data['limit']=$limit;
        $data['page_index']=$page-1;
        $data['products']=$products;
        $data['chosen_brands']=array();
        $data['category_tree'] = null;
        $data['base_url'] = "/product/category?";
        $data['query_string']=array('search'=>'','category'=>$category,'brand'=>$brand,'page'=>$page,'sort'=>$sort);

        $this->parser->parse('product/category_search', $data);
    }
}
