<?php
require_once './app/models/productModel.php';
require_once './app/models/commentModel.php';
require_once './app/views/api.view.php';

class ProductApiController
{
    private $productModel;
    private $commentModel;
    private $view;

    private $data;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->commentModel = new CommentModel();
        $this->view = new ApiView();

        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData()
    {
        return json_decode($this->data);
    }

    //Obtener productos
    public function getProducts()
    {
        $atributes = $this->productModel->getAttributes();
        $atributes_filter = [];
        foreach ($atributes as $key => $atribute) {
            if (isset($_GET[$atribute])) {
                $atributes_filter[$atribute] = strtolower($_GET[$atribute]);
            }
        }

        if (isset($_GET['sortby'])) $sortby = $_GET['sortby'];
        else $sortby = null;
        if (isset($_GET['order'])) $order = $_GET['order'];
        else $order = null;
        if (isset($_GET['page'])) $page = intval($_GET['page']);
        else $page = null;
        if (isset($_GET['limit'])) $limit = intval($_GET['limit']);
        else $limit = null;

        $products = $this->productModel->getAll($atributes, $atributes_filter, $sortby, $order, $page, $limit);
        if ($products) {
            $this->view->response($products);
        } else {
            $this->view->response($products, 204);
        }
    }

    //Obtener un producto
    public function getProduct($params = null)
    {
        $id = $params[':ID'];
        $product = $this->productModel->get($id);
        if ($product) {
            $comentarios = $this->commentModel->getAll($id);
            $product->comentarios = $comentarios;
            $this->view->response($product);
        } else
            $this->view->response("El producto con el id=$id no existe", 404);
    }

    //Eliminar producto
    public function deleteProduct($params = null)
    {
        $id = $params[':ID'];

        $product = $this->productModel->get($id);
        if ($product) {
            $this->productModel->delete($id);
            $this->view->response($product);
        } else
            $this->view->response("El producto con el id=$id no existe", 404);
    }

    //Insertar producto
    public function insertProduct()
    {
        $product = $this->getData();

        if (
            empty($product->categoria_fk) ||
            empty($product->nombre) ||
            empty($product->stock) ||
            empty($product->precio) ||
            (empty($product->especificaciones) && !is_array($product->especificaciones))
        ) {
            $this->view->response("Complete los datos correctamente", 400);
        } else {
            if (!empty($product->imagen)) $image = htmlspecialchars($product->imagen);
            else $image = null;
            $product->especificaciones = $this->sanitize_array($product->especificaciones);
            $product->especificaciones = serialize($product->especificaciones);
            $id = $this->productModel->insert(
                htmlspecialchars($product->categoria_fk),
                htmlspecialchars($product->nombre),
                $image,
                htmlspecialchars($product->stock),
                htmlspecialchars($product->precio),
                $product->especificaciones,
            );
            $product_item = $this->productModel->get($id);
            if ($product_item) $this->view->response($product_item, 201);
            else $this->view->response("categoria_fk no disponible", 400);
        }
    }

    public function sanitize_array($array)
    {
        for ($i = 0; $i < count($array); $i++) {
            $newarray[$i] = htmlspecialchars($array[$i]);
        }
        return $newarray;
    }

    //Comentarios

    //Insertar comentarios
    public function insertComent($params = null)
    {
        $id = $params[':ID'];
        $comment = $this->getData();
        if (
            empty($comment->comentario)
        ) {
            $this->view->response("Complete los datos correctamente", 400);
        } else {
            $id = $this->commentModel->insert($id, $comment->comentario);

            $comment_item = $this->commentModel->get($id);
            if ($comment_item) $this->view->response($comment_item, 201);
            else $this->view->response("producto no disponible", 400);
        }
    }
}
