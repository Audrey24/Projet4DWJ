<?php

class About extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->render('about/bio', 'lib/images/ecrivain.jpeg');
    }
}
