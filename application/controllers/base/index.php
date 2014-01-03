<?php
class index_Controller extends Controller 
{
    public function index($arg) 
    {
        $this->template->setTitle("Home page");
        $this->template->addStyle("teststyle");

        $this->template->show("_template/header");
        $this->template->show("base/index");
        $this->template->show("_template/footer");
    }
}
?>