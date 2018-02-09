<?php
class View
{
    public function __construct()
    {
    }

    public function render($name, $noInclude = false)
    {
        if ($noInclude == true) {
            $name = rtrim($name, '.php');
            require 'views/'. $name . '.php';
        } else {
            # to solve the redict error name.php.php
            $name = rtrim($name, '.php');
            require 'views/header.php';
            require 'views/'. $name . '.php';
            require 'views/footer.php';
        }
    }
}
