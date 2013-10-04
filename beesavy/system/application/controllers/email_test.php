<?php
/**
 */
class Email_Test extends Controller {

	function Email_Test()	{
		parent::Controller();
        $this->load->model('emailer');
	}

    function index(){
    }
    function slide01(){
        $email = "rehoner@gmail.com";
        $msg = $this->parser->parse('email/incomplete', array());
        #$this->emailer->sendMessage($msg,"", $email, "BeeSavy - You've got cash back!");
        $msg = $this->parser->parse('email/join', array());
        #$this->emailer->sendMessage($msg,"", $email, "BeeSavy - You've got cash back!");
        $msg = $this->parser->parse('email/joininfo', array());
        #$this->emailer->sendMessage($msg,"", $email, "BeeSavy - You've got cash back!");
        $msg = $this->parser->parse('email/cbinfo', array());
        #$this->emailer->sendMessage($msg,"", $email, "BeeSavy - You've got cash back!");
        $msg = $this->parser->parse('email/cashback', array());
        #$this->emailer->sendMessage($msg,"", $email, "BeeSavy - You've got cash back!");
        $msg = $this->parser->parse('email/60day', array());
        #$this->emailer->sendMessage($msg,"", $email, "BeeSavy - You've got cash back!");
        $msg = $this->parser->parse('email/83day', array());
        #$this->emailer->sendMessage($msg,"", $email, "BeeSavy - You've got cash back!");
        $msg = $this->parser->parse('email/newpassword', array());
        #$this->emailer->sendMessage($msg,"", $email, "BeeSavy - You've got cash back!");
    }

}
?>
