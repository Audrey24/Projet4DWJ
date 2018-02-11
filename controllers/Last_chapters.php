<?php

class Last_chapters extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->render('last_chapter/chapters', 'lib/images/livre.jpg');
    }
}
