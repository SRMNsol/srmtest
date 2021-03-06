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
        $this->load->model('user');
        $this->load->helper('bridge');
        $this->container = silex();
    }

    public function index()
    {
        echo "Product index"; exit;
    }

    public function search()
    {
        $store = $this->input->get('q');
        $this->load->helper('url');

        $merchants = $this->container['orm.em']->getRepository('App\Entity\Merchant')->getActiveMerchants();
        $matches = array_filter($merchants, function ($merchant) use ($store) {
            if (strtolower($store) === strtolower($merchant->getName())) {
                return $merchant;
            }
        });

        if (count($matches) > 0) {
            redirect('/stores/details/' . current($matches)->getId());
        }

        $data = $this->blocks->getBlocks();
        $data['search'] = $store;
        $this->parser->parse('product/noproduct', $data);
    }
    public function checkpopup()
    {
       
        $data['popupstatus']= $this->user->popupstatus(); 
        return $data['popupstatus'];         
    }
    public function category()
    {
        //Grab information
		$ccategory = $this->input->get('category');
		
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
		//$data['onecat']= $this->user->onecat($categoryId);
        
		
		$this->parser->parse('product/category_search', $data);
    }
}
