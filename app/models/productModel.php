<?php
require_once './app/helpers/helperFunction.php';
define("TABLAPROD", "lista_productos");
class ProductModel
{
    private $db;
    public $helperFunction;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=tpe_web2;charset=utf8', 'root', '');
        $this->helperFunction = new HelperFunction();
    }

    public function getAll($atributes, $atributes_filter, $sortby, $order, $page, $limit)
    {
        return $this->helperFunction->getAll($atributes, $atributes_filter, $sortby, $order, $page, $limit, TABLAPROD);
    }

    //Muestra un producto dado su id
    public function get($id)
    {
        $query = $this->db->prepare("SELECT * FROM " . TABLAPROD . " WHERE id = ?");
        $query->execute([$id]);
        $product = $query->fetch(PDO::FETCH_OBJ);

        return $product;
    }

    //Inserta un producto en la base de datos
    public function insert($categoria_fk, $nombre, $imagen, $stock, $precio, $especificaciones)
    {
        try {
            $query = $this->db->prepare("INSERT INTO " . TABLAPROD . " (categoria_fk, nombre, imagen, stock, precio, especificaciones) VALUES (?, ?, ?, ?, ?, ?)");
            $query->execute([$categoria_fk, $nombre, $imagen, $stock, $precio, $especificaciones]);
        } catch (Exception $e) {
        }

        return $this->db->lastInsertId();
    }

    //Elimina un producto dado su id
    public function delete($id)
    {
        $query = $this->db->prepare("DELETE FROM " . TABLAPROD . " WHERE id = ?");
        $query->execute([$id]);
    }

    public function edit($id, $atributos)
    {
        $sql = "UPDATE " . TABLAPROD . " SET";
        foreach ($atributos as $key => $atribute) {
            $sql .= " $key = :$key,";
            if (is_array($atribute)) {
                $atribute = $this->helperFunction->sanitize_array($atribute);
                $atributos[$key] = serialize($atribute);
            }else{
                $atributos[$key] = htmlspecialchars($atribute);
            }
        }
        $sql = rtrim($sql, ",");

        $atributos["id"] = $id;
        $sql .= " WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute($atributos);
    }
}
