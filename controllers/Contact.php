<?php

class Contact extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->render('contact/contact_form', 'lib/images/contact.jpg');
    }
}
