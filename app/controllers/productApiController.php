<?php
require_once './app/models/productModel.php';
require_once './app/views/api.view.php';

class ProductApiController
{
    private $model;
    private $view;

    private $data;

    public function __construct()
    {
        $this->model = new ProductModel();
        $this->view = new ApiView();

        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData()
    {
        return json_decode($this->data);
    }

    public function getProducts($params = null)
    {
        $atributes = $this->model->getAttributes();
        $atributes_value = [];
        foreach ($atributes as $key => $atribute) {
            if (!isset($_GET[$atribute])) {
                unset($atributes[$key]);
            } else {
                $atributes_value[$atribute]=strtolower($_GET[$atribute]);
            }
        }
        //var_dump($atributes);
        //var_dump($atributes_value); 
        $sortby = null;
        $order = null;
        if (isset($_GET['sortby'])) $sortby = $_GET['sortby'];
        if (isset($_GET['order'])) $order = $_GET['order'];

        $products = $this->model->getAll($atributes, $atributes_value, $sortby, $order);
        if ($products)
            $this->view->response($products);
        else
            $this->view->response("No se encontraron productos que cumplan con las condiciones pedidas", 404);
    }

    public function getProduct($params = null)
    {
        $id = $params[':ID'];
        $product = $this->model->get($id);

        if ($product)
            $this->view->response($product);
        else
            $this->view->response("El producto con el id=$id no existe", 404);
    }

    public function deleteProduct($params = null)
    {
        $id = $params[':ID'];

        $product = $this->model->get($id);
        if ($product) {
            $this->model->delete($id);
            $this->view->response($product);
        } else
            $this->view->response("El producto con el id=$id no existe", 404);
    }

    public function insertProduct($params = null)
    {
        $product = $this->getData();

        if (
            empty($product->categoria_fk) ||
            empty($product->nombre) ||
            empty($product->imagen) ||
            empty($product->stock) ||
            empty($product->precio) ||
            empty($product->especificaciones)
        ) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insert(
                $product->categoria_fk,
                $product->nombre,
                $product->imagen,
                $product->stock,
                $product->precio,
                $product->especificaciones,
            );
            $task = $this->model->get($id);
            if ($task) $this->view->response($task, 201);
            else $this->view->response("categoria_fk no disponible", 400);
        }
    }
}
