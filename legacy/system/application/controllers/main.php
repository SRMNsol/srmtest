
<?php
/**
 * Homepage controller
 */
 
 // Include the autoloader provided in the SDK
require_once APPPATH. 'libraries/facebook-php-sdk/autoload.php';


// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class Main extends Controller
{
    protected $container;
    
    public function __construct()
    {

	    parent::__construct();
        $this->load->model('user');    
        $this->load->helper('bridge');
     

		 $this->load->library('EmailSender');

        $this->container = silex(); 
		//$this->load->library('facebook-php-sdk/autoload.php');
		 //$this->load->library('Facebook');
		 
    }
     
    public function index()
    {
		
    	$home = $this->user->get_home(0);
       
        $data = $this->blocks->getBlocks();
        $data = array_merge($home['vars'], $data);

        if ($this->db_session->userdata('login')) {
        	
            $data = array_merge(
                $this->defaultcache->library('beesavy', 'getUserStats', array($this->user->get_field('id')), 3600),
                $this->defaultcache->library('beesavy', 'getUser', array($this->user->get_field('id'),'', TRUE), 3600),
                $data
            );
        }

      
        $rate = $this->container['orm.em']->getRepository('App\Entity\Rate')->getCurrentRate();
        $topStores = $this->container['orm.em']->getRepository('App\Entity\Merchant')->getTopStores();
        
        $data['stores'] = random_slice(result_merchants($topStores, $rate), 12);
        $data['home'] = $home['vars'];
        $data['referral'] = $this->input->get('referral');
        if (!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }
        if (isset($data['id'])) {
            $data['user_id'] = $data['id'];
            unset($data['id']);
        }
		$categories = cached_categories();
        $data['categories'] = $categories;

		$data['allref']= $this->user->getReffral();

		

		$data['chekref']= $this->user->onreffral();
		

		

		$data['recentor']= $this->user->recentOrder();
		
		
		$data['purchasit']= $data['purchase_exempt'];
		
		$check_sign=$data['allref'];
		$totalref=$data['allref'];
		
		for($i=0; $i<4; $i++) {
			$users [$i] = $this->user->checksign($totalref[$i]['email']);
			
		}
		$data['users'] = $users;
        $this->parser->parse($home['page'], $data);
    }
   public function checkpopup()
    {
    	$data['popupstatus']= $this->user->popupstatus(); 
    	return $data['popupstatus'];
	}
  /* public function newemail()
    {
	  	$data['email']= $this->user->newaccount(); 
    
	}
*/
    public function signin()
    {
        $data = $this->blocks->getBlocks();
        $data['user'] = $this->input->get('user');
        $data['code'] = $this->input->get('code');
        $data['referral'] = $this->input->get('referral');
        $message = array();
        if (!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }
        if ($data['code']) {
            $message = $this->code->get_errors(array($data['code']));
        }
        $data['errors'] = $message;

        $this->parser->parse('/home/signin', $data);
    }

   public function fblogin(){
	  
	   	// Include FB config file && User class
require_once APPPATH.'controllers/fb/fbConfig.php';

if(isset($accessToken)){
	if(isset($_SESSION['facebook_access_token'])){
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}else{
		// Put short-lived access token in session
		$_SESSION['facebook_access_token'] = (string) $accessToken;
		
	  	// OAuth 2.0 client handler helps to manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();
		
		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
		
		// Set default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}
	
	// Redirect the user back to the same page if url has "code" parameter in query string
	if(isset($_GET['code'])){
		header('Location: ./');
	}
	
	// Getting user facebook profile info
	try {
		$profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
		$fbUserProfile = $profileRequest->getGraphNode()->asArray();
	} catch(FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// Redirect user back to app login page
		header("Location: ./");
		exit;
	} catch(FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	
	// Insert or update user data to the database
	$fbUserData = array(
		'oauth_provider'=> 'facebook',
		'oauth_uid' 	=> $fbUserProfile['id'],
		'first_name' 	=> $fbUserProfile['first_name'],
		'last_name' 	=> $fbUserProfile['last_name'],
		'email' 		=> $fbUserProfile['email'],
		'gender' 		=> $fbUserProfile['gender'],
		'locale' 		=> $fbUserProfile['locale'],
		'picture' 		=> $fbUserProfile['picture']['url'],
		'link' 			=> $fbUserProfile['link']
	);
	$userData = $fbUserData;
	
	// Put user data into session
	$_SESSION['userData'] = $userData;
	
	// Get logout url
	$logoutURL = $helper->getLogoutUrl($accessToken, $redirectURL.'logout.php');
	
	// Render facebook profile data
	if(!empty($userData)){
		
		$output .= $userData['picture'].'">';
        $output .=  $userData['oauth_uid'];
       // $output .= '<br/>Name : ' . $userData['first_name'].' '.$userData['last_name'];
        $output .= '<br/>Email : ' . $userData['email'];
        $output .= '<br/>Gender : ' . $userData['gender'];
        $output .= '<br/>Locale : ' . $userData['locale'];
        $output .= '<br/>Logged in with : Facebook';
		$output .= '<br/><a href="'.$userData['link'].'" target="_blank">Click to Visit Facebook Page</a>';
        $output .= '<br/>Logout from <a href="'.$logoutURL.'">Facebook</a>'; 
	}else{
		$output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
	}
	
}else{
	// Get login url
	$loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
	
	// Render facebook login button
	$output = '<a class="btn btn-facebook btn-block" href="'.htmlspecialchars($loginURL).'"><i class="fa fa-facebook"></i> Signin With Facebook</a>';
}

$data['output'] = $output;
	
        $this->load->view('/home/joinnow',$data);
	   redirect('/main/joinnow');
	   }

    public function glogin()
    {	 
		$data = $this->blocks->getBlocks();
		 $this->load->library('googleplus');
		$this->googleplus->getAuthenticate();
			
			if (isset($_GET['code'])) {	
			
		
			$data['user_prof']=$this->googleplus->getUserInfo();
			
			$this->load->view('home/joinnow', $data);
			
			 $data['email'] = $this->input->get('email');
			$data['referral'] = $this->input->get('referral');
			if (!$data['referral']) {
				$data['referral'] = $this->db_session->userdata('referral');
			}
	
			if ($this->input->get('errors')) {
				$data['codes'] = explode(",",$this->input->get('errors'));
			} else {
				$data['codes'] = array();
			}
			$data['errors'] = $this->code->get_errors($data['codes']);
			
			$this->parser->parse('/home/joinnow', $data);

			}
	}

    public function joinlogin()
    {

    	if($this->db_session->userdata('login')['login']){
    			redirect("account");
			}
	
        $data = $this->blocks->getBlocks();
		
        $data['email'] = $this->input->get('email');
        $data['referral'] = $this->input->get('referral');
        if (!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }

        if ($this->input->get('errors')) {
            $data['codes'] = explode(",",$this->input->get('errors'));
        } else {
            $data['codes'] = array();
        }
        $data['chekref']= $this->user->onreffral(); 
        $data['errors'] = $this->code->get_errors($data['codes']);
        $this->parser->parse('/home/joinlogin', $data);
    }


    public function forgotp()
    {
        $data = $this->blocks->getBlocks();
		
        $data['email'] = $this->input->get('email');
        $data['referral'] = $this->input->get('referral');
        if (!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }

        if ($this->input->get('errors')) {
            $data['codes'] = explode(",",$this->input->get('errors'));
        } else {
            $data['codes'] = array();
        }
        $data['chekref']= $this->user->onreffral(); 
        $data['errors'] = $this->code->get_errors($data['codes']);
        $this->parser->parse('/home/forgot', $data);
    }
    public function joinnow()
    {

// Include FB config file && User class
require_once APPPATH.'controllers/fb/fbConfig.php';

if(isset($accessToken)){
	if(isset($_SESSION['facebook_access_token'])){
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}else{
		// Put short-lived access token in session
		$_SESSION['facebook_access_token'] = (string) $accessToken;
		
	  	// OAuth 2.0 client handler helps to manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();
		
		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
		
		// Set default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}
	
	// Redirect the user back to the same page if url has "code" parameter in query string
	if(isset($_GET['code'])){
		header('Location: ./fblogin');
	}
	
	// Getting user facebook profile info
	try {
		$profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
		$fbUserProfile = $profileRequest->getGraphNode()->asArray();
	} catch(FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// Redirect user back to app login page
		header("Location: ./fblogin");
		exit;
	} catch(FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	
	// Insert or update user data to the database
	$fbUserData = array(
		'oauth_provider'=> 'facebook',
		'oauth_uid' 	=> $fbUserProfile['id'],
		'first_name' 	=> $fbUserProfile['first_name'],
		'last_name' 	=> $fbUserProfile['last_name'],
		'email' 		=> $fbUserProfile['email'],
		'gender' 		=> $fbUserProfile['gender'],
		'locale' 		=> $fbUserProfile['locale'],
		'picture' 		=> $fbUserProfile['picture']['url'],
		'link' 			=> $fbUserProfile['link']
	);
	$userData = $fbUserData;
	
	// Put user data into session
	$_SESSION['userData'] = $userData;
	
	// Get logout url
	$logoutURL = $helper->getLogoutUrl($accessToken, $redirectURL.'/logout');
	
	// Render facebook profile data
	if(!empty($userData)){
		$output['detail']= '<h1>Facebook Profile Details </h1>';
		$output['picture']=$userData['picture'].'">';
        $output['oauth_uid']= $userData['oauth_uid'];
        $output['name']= $userData['first_name'].' '.$userData['last_name'];
        $output['email']=  $userData['email'];
        $output['gender']=  $userData['gender'];
        $output['locale']=  $userData['locale'];
        $output['logged']= '<br/>Logged in with : Facebook';
		$output['link']= $userData['link'];
        $output['logout']= '<a class="btn btn-facebook btn-block"  href="'.htmlspecialchars($logoutURL).'"><img class="img-rounded" src="'.$userData['picture'].'" width="20px"/> Logout from Facebook</a>';
		
	}else{
		$output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
	}
	
	
}else{
	// Get login url
	$loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
	
	// Render facebook login button
	$output = '<a class="btn btn-facebook btn-block" id="fbb" href="'.htmlspecialchars($loginURL).'"><i class="fa fa-facebook"></i> Signin With Facebook</a>';
}

$data['output'] = $output;

		$categories = cached_categories();
        $data['categories'] = $categories;
		//$data = $this->blocks->getBlocks();
		
        $data['email'] = $this->input->get('email');
        $data['referral'] = $this->input->get('referral');
        if (!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }

        if ($this->input->get('errors')) {
            $data['codes'] = explode(",",$this->input->get('errors'));
        } else {
            $data['codes'] = array();
        }
		  
			

        $data['errors'] = $this->code->get_errors($data['codes']);


		$data['chekref']= $this->user->onreffral();     
		  	

        $this->parser->parse('/home/joinnow', $data);
    }

    public function forgot($success= False, $email = "")
    {
        if ($this->user->login_status()) {
            redirect('');
        }
        $data = $this->blocks->getBlocks();
        if ($success) {
            $data['success'] = "An email has been sent to $email";
        }
        if ($this->input->get('errors')) {
            $data['codes'] = explode(",",$this->input->get('errors'));
        } else {
            $data['codes'] = array();
        }
        $data['errors'] = $this->code->get_errors($data['codes']);
        $data['referral'] = $this->input->get('referral');
        if (!$data['referral']) {
            $data['referral'] = $this->db_session->userdata('referral');
        }
        $this->parser->parse('/home/forgot', $data);
    }
	function logout(){
		// Include FB config file && User class
require_once APPPATH.'controllers/fb/fbConfig.php';
// Remove access token from session
unset($_SESSION['facebook_access_token']);

// Remove user data from session
unset($_SESSION['userData']);

// Redirect to the homepage
header("Location: ./joinnow");
		}
}
