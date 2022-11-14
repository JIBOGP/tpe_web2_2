<?php
require_once './app/models/productModel.php';
require_once './app/helpers/helperFunction.php';
require_once './app/views/api.view.php';

class ProductApiController
{
    private $productModel;
    private $view;
    private $helperFunction;

    private $data;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->view = new ApiView();
        $this->helperFunction = new HelperFunction();

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
        $atributes = $this->helperFunction->getAttributes("lista_productos");
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
            foreach ($products as $key => $product) {
                if (is_string($product->especificaciones))
                    $product->especificaciones = unserialize($product->especificaciones);
            }
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
            $product->especificaciones = unserialize($product->especificaciones);
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
            $product->especificaciones = unserialize($product->especificaciones);
            $this->view->response($product);
        } else
            $this->view->response("El producto con el id=$id no existe", 404);
    }

    //Agregar producto
    public function insertProduct()
    {
        $product = $this->getData();
        if (
            empty($product->categoria_fk) ||
            empty($product->nombre) ||
            empty($product->stock) ||
            empty($product->precio)
        ) {
            $this->view->response("Complete los datos correctamente", 400);
        } else {
            if (!empty($product->imagen)) $image = htmlspecialchars($product->imagen);
            else $image = null;
            if (!empty($product->especificaciones) && is_array($product->especificaciones)) {
                $product->especificaciones = $this->helperFunction->sanitize_array($product->especificaciones);
                $product->especificaciones = serialize($product->especificaciones);
            } else $product->especificaciones = "";
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

    //Editar producto
    public function editProduct($params = null)
    {
        $id = $params[':ID'];

        $productUpdate = $this->getData();

        $product = $this->productModel->get($id);

        if ($product) {
            $atributos = $this->helperFunction->getAttributes(TABLAPROD);

            $editproduct = [];

            for ($i = 3; $i < count($atributos); $i++) {
                $atribute = $atributos[$i];
                if (!empty($productUpdate->$atribute)) {
                    $editproduct[$atribute] = $productUpdate->$atribute;
                }
            }

            if (count($editproduct) > 0) {
                $this->productModel->edit($id, $editproduct);
                $product = $this->productModel->get($id);
                $this->view->response($product);
            } elseif (count(get_object_vars($productUpdate))>0) {
                $this->view->response("Los atributos no coinciden con ningun atributo de la tabla", 406);
            }else {
                $this->view->response("No se han puesto atributos para modificar", 406);
            }
        } else
            $this->view->response("El producto con el id=$id no existe", 404);
    }
}
