<?php
class View
{
    public function __construct()
    {
    }

    public function render($name, $img = null, $noInclude = false)
    {
        if (!empty($img)) {
            $backgroundImg = $img;
        } else {
            $backgroundImg = 'lib/images/plume.jpg';
        }

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
