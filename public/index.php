<?php 
    ini_set('display-errors',1);
    error_reporting(E_ALL);
    require __DIR__.'/../vendor/autoload.php';
    require '../helpers.php';

    use Framework\Router;
    $router = new Router();
    $routes = require basePath('routes.php');


    $uri= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //Uniform Resource Identifier //h80=
    $router->route($uri);

?>






<?php
  // require '../helpers.php'; 
    // require basePath('Framework/Database.php');
    // require basePath('Framework/Router.php');

    // require '../Database.php';
    // require basePath('views/home.view.php');
    // viewPartials('home'); 

    // echo "hello mundo";  

    // $config = require basePath('config/db.php');
    // $db = new Database($config);
    // inspect($config);

// echo "yow";

// $name = 'error/404';
//  var_dump(basePath("views/{$name}.view.php"));

// $name = 'controllers/error/404.php';
//  var_dump(basePath($routes['404'])); 

//  viewPartials('error/404');

?>