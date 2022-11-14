<?php
require_once './libs/Router.php';
require_once './app/controllers/productApiController.php';
require_once './app/controllers/commentApiController.php';

$router = new Router();
//GET
$router->addRoute('products', 'GET', 'ProductApiController', 'getProducts');
$router->addRoute('products/:ID', 'GET', 'ProductApiController', 'getProduct');
$router->addRoute('comments', 'GET', 'CommentApiController', 'getComments');
$router->addRoute('comments/:ID', 'GET', 'CommentApiController', 'getComment');
//DELETE
$router->addRoute('products/:ID', 'DELETE', 'ProductApiController', 'deleteProduct');
$router->addRoute('comments/:ID', 'DELETE', 'CommentApiController', 'deleteComment');
//POST
$router->addRoute('products', 'POST', 'ProductApiController', 'insertProduct'); 
$router->addRoute('comments', 'POST', 'CommentApiController', 'insertComment'); 
//Update
$router->addRoute('products/:ID', 'PUT', 'ProductApiController', 'editProduct'); 
$router->addRoute('comments/:ID', 'PUT', 'CommentApiController', 'editComment'); 

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);