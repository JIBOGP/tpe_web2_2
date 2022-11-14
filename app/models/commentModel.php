<?php
require_once './app/helpers/helperFunction.php';
define("TABLACOMMENT","comentarios");

class CommentModel
{
    private $db;
    private $helperFunction;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=tpe_web2;charset=utf8', 'root', '');
        $this->helperFunction= new HelperFunction();
    }

    //Devuelve todos los comentarios de un producto especifico
    public function getAll($atributes, $atributes_filter, $sortby, $order, $page, $limit)
    {
        return $this->helperFunction->getAll($atributes, $atributes_filter, $sortby, $order, $page, $limit,TABLACOMMENT);
    }


    //Devuelve el comentario
    public function get($id)
    {
        $query = $this->db->prepare("SELECT * FROM ".TABLACOMMENT." WHERE id = ?");
        $query->execute([$id]);
        $product = $query->fetch(PDO::FETCH_OBJ);

        return $product;
    }

    //Inserta un comentario
    public function insert($id_producto, $comentario)
    {
        try {
            $query = $this->db->prepare("INSERT INTO ".TABLACOMMENT." (id_producto , comentario) VALUES (?, ?)");
            $query->execute([$id_producto, $comentario]);
        } catch (Exception $e) {
        }

        return $this->db->lastInsertId();
    }

    //Elimina un comentario dado su id
    public function delete($id)
    {
        $query = $this->db->prepare("DELETE FROM ".TABLACOMMENT." WHERE id = ?");
        $query->execute([$id]);
    }

    public function edit($id,$atributos)
    {
        $sql="UPDATE ".TABLACOMMENT." SET";
        foreach ($atributos as $key => $atribute) {
            $sql.=" $key = :$key,";
            $atributos[$key] = htmlspecialchars($atribute);
        }
        $sql= rtrim($sql, ",");

        $atributos["id"]= $id;
        $sql.=" WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute($atributos);
    }
}
