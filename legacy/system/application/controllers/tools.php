<?php
/**
 */
class Tools extends Controller
{
    public function Tools()
    {
        parent::Controller();
        $this->load->library('beesavy');
        $this->load->model('user');
        $this->load->model('facebook');
        $this->load->model('twitter');
        $this->user_id = $this->user->get_field('id');
    }

    public function __get_header(&$data)
    {
        if (!$this->user->login_status()) {
            redirect('main/signin?user=&code=20');
        }
        $home = $this->user->get_home(0);
        $banner = $this->user->get_banner(0);
        $data = array_merge($data,$this->blocks->getBlocks());
    }

    public function index()
    {
        if (!$this->user->login_status()) {
            redirect('main/signin?user=&code=20');
        }
        $data = array_merge(
            $this->popshopscache->library('beesavy', 'getUserStats', array($this->user_id), 3600),
            $this->popshopscache->library('beesavy', 'getUser', array($this->user_id,'', TRUE), 3600)
        );
        $this->__get_header($data);
        $this->parser->parse('tools/overview', $data);
    }

    public function referrals()
    {
        if (!$this->user->login_status()) {
            redirect('main/signin?user=&code=20');
        }
        $data = $this->popshopscache->library('beesavy', 'getUserStats', array($this->user_id), 3600);
        $data2 = $this->popshopscache->library('beesavy', 'getUser', array($this->user_id,'', TRUE), 3600);
        $data2 = array_merge($data2, $this->user->info());
        $data = array_merge($data, $data2);
        $data3 = $this->beesavy->getUserReferrals($this->user_id);
        $data = array_merge($data, $data3);
        $this->__get_header($data);
        $this->parser->parse('tools/referrals', $data);
    }

    public function test()
    {
        $data =$this->user->info();
        $this->__get_header($data);
        $banners = array(
            'leaderboard_1_static'=>$this->_makestatic('Version_01/728x90_final.jpg', $data['alias']),
            'leaderboard_2_static'=>$this->_makestatic('Version_02/728x90_final.jpg', $data['alias']),
            'wide_skyscraper_1_static'=>$this->_makestatic('Version_01/160x600_final.jpg', $data['alias']),
            'wide_skyscraper_2_static'=>$this->_makestatic('Version_02/160x600_final.jpg', $data['alias']),
            'medium_rectangle_1_static'=>$this->_makestatic('Version_01/300x250_final.jpg', $data['alias']),
            'medium_rectangle_2_static'=>$this->_makestatic('Version_02/300x250_final.jpg', $data['alias']),
            'square_popup_1_static'=>$this->_makestatic('Version_01/250x250_final.jpg', $data['alias']),
            'square_popup_2_static'=>$this->_makestatic('Version_02/250x250_final.jpg', $data['alias']),
            'full_banner_1_static'=>$this->_makestatic('Version_01/468x60_final.jpg', $data['alias']),
            'full_banner_2_static'=>$this->_makestatic('Version_02/468x60_final.jpg', $data['alias']),
            'half_banner_1_static'=>$this->_makestatic('Version_01/234x60_final.jpg', $data['alias']),
            'half_banner_2_static'=>$this->_makestatic('Version_02/234x60_final.jpg', $data['alias']),
            'leaderboard_1_flash'=>$this->_makeflash('768px', '90px', 'Version1/leaderboard.swf', $data['alias']),
            'leaderboard_2_flash'=>$this->_makeflash('768px', '90px', 'Version2/leaderboard.swf', $data['alias']),
            'wide_skyscraper_1_flash'=>$this->_makeflash('160px', '600px', 'Version1/wideskyscraper.swf', $data['alias']),
            'wide_skyscraper_2_flash'=>$this->_makeflash('160px', '600px', 'Version2/wideskyscraper.swf', $data['alias']),
            'medium_rectangle_1_flash'=>$this->_makeflash('300px', '250px', 'Version1/Mediumrectangle.swf', $data['alias']),
            'medium_rectangle_2_flash'=>$this->_makeflash('300px', '250px','Version2/Mediumrectangle.swf', $data['alias']),
            'square_popup_1_flash'=>$this->_makeflash('250px', '250px','Version1/squarepop.swf', $data['alias']),
            'square_popup_2_flash'=>$this->_makeflash('250px', '250px','Version2/squarepop.swf', $data['alias']),
            'full_banner_1_flash'=>$this->_makeflash('428px', '60px','Version1/fullbanner.swf', $data['alias']),
            'full_banner_2_flash'=>$this->_makeflash('428px', '60px','Version2/fullbanner.swf', $data['alias']),
            'half_banner_1_flash'=>$this->_makeflash('234px', '60px','Version1/halfbanner.swf', $data['alias']),
            'half_banner_2_flash'=>$this->_makeflash('234px', '60px','Version2/halfbanner.swf', $data['alias']),
        );
        foreach ($banners as $b) {
            echo $b;
        }
    }
    public function banner()
    {
        if (!$this->user->login_status()) {
            redirect('main/signin?user=&code=20');
        }
        $data =$this->user->info();
        if ($data['alias']=='') {
            $data['alias']=$data['id'];
        }
        $data2 = $this->beesavy->getUser($this->user_id, '', TRUE);
        $data2 =array_merge($data2, $this->user->info());
        $data = array_merge($data, $data2);
        if ($data['alias']=='') {
            $data['alias']=$data['id'];
        }
        $this->__get_header($data);
        #Load the banner HTML
        #STATIC
        $banners = array(
            'leaderboard_1_static'=>$this->_makestatic('Version_01/728x90_final.jpg', $data['alias']),
            'leaderboard_2_static'=>$this->_makestatic('Version_02/728x90_final.jpg', $data['alias']),
            'wide_skyscraper_1_static'=>$this->_makestatic('Version_01/160x600_final.jpg', $data['alias']),
            'wide_skyscraper_2_static'=>$this->_makestatic('Version_02/160x600_final.jpg', $data['alias']),
            'medium_rectangle_1_static'=>$this->_makestatic('Version_01/300x250_final.jpg', $data['alias']),
            'medium_rectangle_2_static'=>$this->_makestatic('Version_02/300x250_final.jpg', $data['alias']),
            'square_popup_1_static'=>$this->_makestatic('Version_01/250x250_final.jpg', $data['alias']),
            'square_popup_2_static'=>$this->_makestatic('Version_02/250x250_final.jpg', $data['alias']),
            'full_banner_1_static'=>$this->_makestatic('Version_01/468x60_final.jpg', $data['alias']),
            'full_banner_2_static'=>$this->_makestatic('Version_02/468x60_final.jpg', $data['alias']),
            'half_banner_1_static'=>$this->_makestatic('Version_01/234x60_final.jpg', $data['alias']),
            'half_banner_2_static'=>$this->_makestatic('Version_02/234x60_final.jpg', $data['alias']),
            'leaderboard_1_flash'=>$this->_makeflash('768px', '90px', 'Version1/leaderboard.swf', $data['alias']),
            'leaderboard_2_flash'=>$this->_makeflash('768px', '90px', 'Version2/leaderboard.swf', $data['alias']),
            'wide_skyscraper_1_flash'=>$this->_makeflash('160px', '600px', 'Version1/wideskyscraper.swf', $data['alias']),
            'wide_skyscraper_2_flash'=>$this->_makeflash('160px', '600px', 'Version2/wideskyscraper.swf', $data['alias']),
            'medium_rectangle_1_flash'=>$this->_makeflash('300px', '250px', 'Version1/Mediumrectangle.swf', $data['alias']),
            'medium_rectangle_2_flash'=>$this->_makeflash('300px', '250px','Version2/Mediumrectangle.swf', $data['alias']),
            'square_popup_1_flash'=>$this->_makeflash('250px', '250px','Version1/squarepop.swf', $data['alias']),
            'square_popup_2_flash'=>$this->_makeflash('250px', '250px','Version2/squarepop.swf', $data['alias']),
            'full_banner_1_flash'=>$this->_makeflash('428px', '60px','Version1/fullbanner.swf', $data['alias']),
            'full_banner_2_flash'=>$this->_makeflash('428px', '60px','Version2/fullbanner.swf', $data['alias']),
            'half_banner_1_flash'=>$this->_makeflash('234px', '60px','Version1/halfbanner.swf', $data['alias']),
            'half_banner_2_flash'=>$this->_makeflash('234px', '60px','Version2/halfbanner.swf', $data['alias']),
        );
        $imageurl = array(
            'leaderboard_1_static_url'=>'/Banner/Static/Version_01/728x90_final.jpg',
            'leaderboard_2_static_url'=>'/Banner/Static/Version_02/728x90_final.jpg',
            'wide_skyscraper_1_static_url'=>'/Banner/Static/Version_01/160x600_final.jpg',
            'wide_skyscraper_2_static_url'=>'/Banner/Static/Version_02/160x600_final.jpg',
            'medium_rectangle_1_static_url'=>'/Banner/Static/Version_01/300x250_final.jpg',
            'medium_rectangle_2_static_url'=>'/Banner/Static/Version_02/300x250_final.jpg',
            'square_popup_1_static_url'=>'/Banner/Static/Version_01/250x250_final.jpg',
            'square_popup_2_static_url'=>'/Banner/Static/Version_02/250x250_final.jpg',
            'full_banner_1_static_url'=>'/Banner/Static/Version_01/468x60_final.jpg',
            'full_banner_2_static_url'=>'/Banner/Static/Version_02/468x60_final.jpg',
            'half_banner_1_static_url'=>'/Banner/Static/Version_01/234x60_final.jpg',
            'half_banner_2_static_url'=>'/Banner/Static/Version_02/234x60_final.jpg',
            #FLASH
            'leaderboard_1_flash_url'=>'/tools/showflash/768px/90px/1/leaderboard',
            'leaderboard_2_flash_url'=>'/tools/showflash/768px/90px/2/leaderboard',
            'wide_skyscraper_1_flash_url'=>'/tools/showflash/160px/600px/1/wideskyscraper',
            'wide_skyscraper_2_flash_url'=>'/tools/showflash/160px/600px/2/wideskyscraper',
            'medium_rectangle_1_flash_url'=>'/tools/showflash/300px/250px/1/Mediumrectangle',
            'medium_rectangle_2_flash_url'=>'/tools/showflash/300px/250px/2/Mediumrectangle',
            'square_popup_1_flash_url'=>'/tools/showflash/300px/250px/1/squarepop',
            'square_popup_2_flash_url'=>'/tools/showflash/250px/250px/2/squarepop',
            'full_banner_1_flash_url'=>'/tools/showflash/428px/60px/1/fullbanner',
            'full_banner_2_flash_url'=>'/tools/showflash/428px/60px/2/fullbanner',
            'half_banner_1_flash_url'=>'/tools/showflash/234px/60px/1/halfbanner',
            'half_banner_2_flash_url'=>'/tools/showflash/234px/60px/2/halfbanner',
        );
        $data = array_merge($data, $banners);
        $data = array_merge($data, $imageurl);
        #FLASH
        $this->parser->parse('tools/banner', $data);
    }
    public function _makestatic($image, $alias)
    {
        return "<a href='".base_url()."$alias'><img src='".base_url()."/Banner/Static/$image' /></a>";
    }
    public function showflash($width, $height, $version, $flash)
    {
        $height2 = str_replace("px", "", $height);
        $height2 = (float) $height2 + 10;
        $width2 = str_replace("px", "", $width);
        $width2 = (float) $width2 + 10;
        $height2 = $height2."px";
        $width2 = $width2."px";
        $data = array(
            'height2'=>$height2,
            'width2'=>$width2,
            'width'=>$width,
            'height'=>$height,
            'link'=>base_url(),
            'flash'=>"/Banner/Animation/Version$version/$flash.swf");
        $this->parser->parse('tools/flash', $data);
    }
    public function _makeflash($width, $height, $flash, $alias)
    {
        $height2 = str_replace("px", "", $height);
        $height2 = (float) $height2 + 10;
        $width2 = str_replace("px", "", $width);
        $width2 = (float) $width2 + 10;
        $height2 = $height2."px";
        $width2 = $width2."px";
        $data = array(
            'height2'=>$height2,
            'width2'=>$width2,
            'width'=>$width,
            'height'=>$height,
            'link'=>base_url()."$alias",
            'flash'=>base_url()."/Banner/Animation/$flash");

        return $this->parser->parse('tools/flash', $data, True);
    }
    public function email_personal($alias)
    {
        $data = $this->beesavy->getUser($this->user_id, '', TRUE);
        $data =array_merge($data, $this->user->info());
        $this->__get_header($data);
        $title = "BeeSavy...Taking the Sting Out of Online Shopping";
        $body = $this->parser->parse('tools/personal', $data, true);
        $url = "mailto:?subject=".($title)."&body=".($body);
        echo $url;
    }
    public function email_business($alias)
    {
        $data = $this->beesavy->getUser($this->user_id, '', TRUE);
        $data =array_merge($data, $this->user->info());
        $this->__get_header($data);
        $title = "BeeSavy.com...A Revolution in Website Monetization";
        $body = $this->parser->parse('tools/business', $data, true);
        $url = "mailto:?subject=".($title)."&body=".($body);
        echo $url;
    }
    public function set_setting()
    {
        $setting =$this->input->post('setting');
        $value =$this->input->post('value');
        if ($setting == "facebook_auto" && $value) {
            $url = $this->facebook->request_permissions(base_url()."/tools/add_facebook", $this->user_id);
            if ($url) {
                redirect($url);
            }
        }
        if ($setting == "twitter_auto" && $value) {
            $url = $this->twitter->request_permissions(base_url()."/tools/add_twitter", $this->user_id);
            if ($url) {
                redirect($url);
            }
        }

            $this->user->set_setting($setting, $value);
            $this->index();

    }
    public function add_facebook()
    {
        $success = $this->facebook->get_access_token($this->user_id);
        if (!$success) {
            $error = '5';
            echo $error;
        }
        $setting = "facebook_auto";
        $value = 1;
        $this->user->set_setting($setting, $value);
        $this->index();
    }
    public function add_twitter()
    {
        $success = $this->twitter->get_access_token($this->user_id);
        if (!$success) {
            $error = '5';
            echo $error;
        }
        $setting = "twitter_auto";
        $value = 1;
        $this->user->set_setting($setting, $value);
        $this->index();
    }
}
