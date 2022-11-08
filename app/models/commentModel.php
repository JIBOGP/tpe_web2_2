<?php

class CommentModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=tpe_web2;charset=utf8', 'root', '');
    }

    //Devuelve todos los comentarios de un producto especifico
    public function getAll($id)
    {
        $query = $this->db->prepare("SELECT * FROM comentarios WHERE id_producto = ?");
        $query->execute([$id]);
        $product = $query->fetchAll(PDO::FETCH_OBJ);

        return $product;
    }

    //Devuelve el comentario
    public function get($id)
    {
        $query = $this->db->prepare("SELECT * FROM comentarios WHERE id = ?");
        $query->execute([$id]);
        $product = $query->fetch(PDO::FETCH_OBJ);

        return $product;
    }

    //Inserta un comentario
    public function insert($id_producto, $comentario)
    {
        try {
            $query = $this->db->prepare("INSERT INTO comentarios (id_producto , comentario, mg, nmg) VALUES (?, ?, ?, ?)");
            $query->execute([$id_producto, $comentario,0,0]);
        } catch (Exception $e) {
        }

        return $this->db->lastInsertId();
    }

    //Elimina un comentario dado su id
    public function delete($id)
    {
        $query = $this->db->prepare('DELETE FROM comentarios WHERE id = ?');
        $query->execute([$id]);
    }
}
