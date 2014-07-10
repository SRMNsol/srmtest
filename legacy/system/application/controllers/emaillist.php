<?php
/**
 */
class Emaillist extends Controller
{
    public function Emaillist()
    {
        parent::Controller();
        $this->load->library('beesavy');
        $this->load->model('emailer');
        $this->data = array();
        $info = end($this->uri->segments);
        $this->data = $this->blocks->getBlocks();
        $this->data['side_nav'] = $this->parser->parse('blocks/side_bar',array('info'=>$info), TRUE);
    }

    public function index()
    {
    }
}
