<?php
require_once './app/models/commentModel.php';
require_once './app/helpers/helperFunction.php';
require_once './app/views/api.view.php';

class CommentApiController
{
    private $commentModel;
    private $view;
    private $helperFunction;

    private $data;

    public function __construct()
    {
        $this->commentModel = new CommentModel();
        $this->view = new ApiView();
        $this->helperFunction = new HelperFunction();

        $this->data = file_get_contents("php://input");
    }

    private function getData()
    {
        return json_decode($this->data);
    }

    //Obtener comentarios
    public function getComments()
    {
        $atributes = $this->helperFunction->getAttributes("comentarios");;
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

        $comments = $this->commentModel->getAll($atributes, $atributes_filter, $sortby, $order, $page, $limit);
        if ($comments) $this->view->response($comments);
        else $this->view->response($comments, 204);
    }

    //Obtener un comentario
    public function getComment($params = null)
    {
        $id = $params[':ID'];
        $product = $this->commentModel->get($id);
        if ($product) {
            $this->view->response($product);
        } else
            $this->view->response("El producto con el id=$id no existe", 404);
    }

    //Eliminar comentario
    public function deleteComment($params = null)
    {
        $id = $params[':ID'];

        $comment = $this->commentModel->get($id);
        if ($comment) {
            $this->commentModel->delete($id);
            $this->view->response($comment);
        } else
            $this->view->response("El producto con el id=$id no existe", 404);
    }
    //Agregar un comentario
    public function insertComment()
    {
        $comment = $this->getData();
        if (
            empty($comment->id_producto) ||
            empty($comment->comentario)
        ) {
            $this->view->response("Complete los datos correctamente", 400);
        } else {
            $id = $this->commentModel->insert(
                htmlspecialchars($comment->id_producto),
                htmlspecialchars($comment->comentario)
            );
            $comment_item = $this->commentModel->get($id);
            if ($comment_item) $this->view->response($comment_item, 201);
            else $this->view->response("El producto no disponible", 400);
        }
    }

    //Editar comentario
    public function editComment($params = null)
    {
        $id = $params[':ID'];

        $commentUpdate = $this->getData();

        $comment = $this->commentModel->get($id);

        if ($comment) {
            $atributos = $this->helperFunction->getAttributes(TABLACOMMENT);

            $editproduct = [];

            for ($i = 3; $i < count($atributos); $i++) {
                $atribute = $atributos[$i];
                if (!empty($commentUpdate->$atribute)) {
                    $editproduct[$atribute] = $commentUpdate->$atribute;
                }
            }

            if (count($editproduct) > 0) {
                $this->commentModel->edit($id, $editproduct);
                $comment = $this->commentModel->get($id);
                $this->view->response($comment);
            } elseif (count(get_object_vars($commentUpdate))>0) {
                $this->view->response("Los atributos no coinciden con ningun atributo de la tabla", 400);
            }else {
                $this->view->response("No se han puesto atributos para modificar", 400);
            }
        } else
            $this->view->response("El comentario con el id=$id no existe", 404);
    }
}
