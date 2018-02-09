<?php
//namespace lib;

class Router
{
    public function __construct()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        if (empty($url[0])) {
            require 'controllers/Home.php';
            $controller = new Home();
            $controller->index();
            return false;
        }

        $url[0] = rtrim($url[0], '.php');
        $file = 'controllers/' . $url[0] . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            require_once("controllers/Errorme.php");
            $controller = new Errorme();
            return false;
        }

        $controller = new $url[0];
        $controller->loadModel($url[0]);

        if (isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2]);
            } else {
                $this->error();
            }
        } else {
            if (isset($url[1])) {
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}();
                } else {
                    $this->error();
                }
            } else {
                $controller->index();
            }
        }
    }

    public function error()
    {
        require "controllers/Errorme.php";
        $controller = new Error();
        $controller->index();
        return false;
    }
}
