<?php

class ProductModel
{

    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=tpe_web2;charset=utf8', 'root', '');
    }

    public function getAll($atributes_filter,$atributes_value,$sortby,$order)
    {
        $sql = "SELECT * FROM lista_productos";
        $atributes = $this->getAttributes(); //Devuelve los atributos de la tabla

        //Filtrar por cualquiera de los atributo de mi tabla
        $sql_filter = "";
        $filter_values = [];
        foreach ($atributes_filter as $key => $atribute) {
            if (!empty($atributes_value[$atribute])) {
                $filter_value = $atributes_value[$atribute];
                $sql_filter .= " $atribute LIKE ? AND";
                $filter_values[] = "$filter_value";
            }
        }
        if (!empty($sql_filter)) {
            $sql .= " WHERE" . rtrim($sql_filter, " AND");
        }
        //Ordenar por cualquiera de los atributo de mi tabla
        if (!empty($sortby)) {
            //$filterby = $_GET['filter'];
            if (array_search($sortby, $atributes) != false) {
                $sql .= " ORDER BY $sortby"; //Agrega la orden de ordenado
            }
        }else {$sql .= " ORDER BY id";} //Ordena por defecto id

        if (!empty($order)) {
            $order = strtolower($order);
            if ($order == 'desc') $sql .= " DESC"; //Agrega la orden de ordenado descendente
            else if ($order == 'asc') $sql .= " ASC"; //Agrega la orden de ordenado ascendente
        }

        $query = $this->db->prepare($sql);
        if (!empty($filter_values)) {
            $query->execute($filter_values);
        } else {
            $query->execute();
        }


        $products = $query->fetchAll(PDO::FETCH_OBJ);

        return $products;
    }

    public function getAttributes() //Devuelve los atributos de la tabla
    {
        $query = $this->db->prepare("SHOW COLUMNS FROM `lista_productos`");
        $query->execute();

        $attributes = $query->fetchAll(PDO::FETCH_OBJ);
        $arrayAttributes[0] = "";
        foreach ($attributes as $key => $attribute) {
            $arrayAttributes[$key + 1] = strtolower($attribute->Field);
        }
        return $arrayAttributes;
    }

    //Muestra un producto dado su id
    public function get($id)
    {
        $query = $this->db->prepare("SELECT * FROM lista_productos WHERE id = ?");
        $query->execute([$id]);
        $product = $query->fetch(PDO::FETCH_OBJ);

        return $product;
    }

    //Inserta un producto en la base de datos
    public function insert($categoria_fk, $nombre, $imagen, $stock, $precio, $especificaciones)
    {
        try {
            $query = $this->db->prepare("INSERT INTO lista_productos (categoria_fk, nombre, imagen, stock, precio, especificaciones) VALUES (?, ?, ?, ?, ?, ?)");
            $query->execute([$categoria_fk, $nombre, $imagen, $stock, $precio, $especificaciones]);
        } catch (Exception $e) {
        }

        return $this->db->lastInsertId();
    }

    //Elimina un producto dado su id
    public function delete($id)
    {
        $query = $this->db->prepare('DELETE FROM lista_productos WHERE id = ?');
        $query->execute([$id]);
    }
}
