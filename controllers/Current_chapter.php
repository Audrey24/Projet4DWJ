<?php

class Current_chapter extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->render('current_chapter/reading');
    }
}
