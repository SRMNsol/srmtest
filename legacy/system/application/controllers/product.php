<?php
/**
 * Product search controller
 */
class Product extends Controller
{
    protected $container;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('refer');
        $this->load->helper('bridge');
        $this->container = silex();
    }

    public function index()
    {
    }

    public function search()
    {
        $store = $this->input->get('q');
        $this->load->helper('url');

        if (empty($store)) {
            $merchants = array();
        }
        else {
            $merchants = $this->container['orm.em']->getRepository('App\Entity\Merchant')->searchActiveMerchants($store);
        }

        $data = $this->blocks->getBlocks();
        $data['search'] = $store;
        $data['merchants'] = $merchants;
        $this->parser->parse('product/search', $data);
    }

    public function category()
    {
        //Grab information
        $categoryId = $this->input->get('category') ?: null;
        $page = $this->input->get('page') ?: 1;
        $limit = $this->input->get('limit') ?: 25;

        if ($categoryId === null) {
            throw new \Exception('Invalid category Id');
        }

        //Run the search query
        $category = $this->container['orm.em']->find('App\Entity\Category', $categoryId);
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();
        $stores = result_merchants($category->getActiveMerchants()->slice(($page - 1) * $limit, $limit), $rate);
        $categories = cached_categories();
        $count = $category->getActiveMerchants()->count();

        //Load the page
        $data = $this->blocks->getBlocks();
        $data['count'] = $count;
        $data['categories'] = $categories;
        $data['category'] = $category;
        $data['category_name'] = $category->getName();
        $data['stores'] = $stores;
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['page_index'] = $page-1;
        $data['category_tree'] = null;
        $data['base_url'] = "/product/category?";
        $data['query_string'] = ['search' => '', 'category' => $category, 'page' => $page];

        $this->parser->parse('product/category_search', $data);
    }
}
