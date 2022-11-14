<?php
class HelperFunction
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=tpe_web2;charset=utf8', 'root', '');
    }

    public function getAttributes($table) //Devuelve los atributos de la tabla
    {
        $query = $this->db->prepare("SHOW COLUMNS FROM `$table`");
        $query->execute();

        $attributes = $query->fetchAll(PDO::FETCH_OBJ);
        $arrayAttributes[0] = "";
        foreach ($attributes as $key => $attribute) {
            $arrayAttributes[$key + 1] = strtolower($attribute->Field);
        }
        return $arrayAttributes;
    }

    //Retorna los datos de una tabla siguiendo los parametros
    public function getAll($atributes, $atributes_filter, $sortby, $order, $page, $limit, $table)
    {
        $sql = "SELECT * FROM $table";

        //Filtrar por cualquiera de los atributo de mi tabla
        $sql_filter = "";
        $filter_values = [];
        foreach ($atributes_filter as $key => $atribute) {
            if (!empty($atribute)) {
                $sql_filter .= " $key LIKE ? AND";
                $filter_values[] = "$atribute";
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
        } else {
            $sql .= " ORDER BY id";
        } //Ordena por defecto id

        if (!empty($order)) {
            $order = strtolower($order);
            if ($order == 'desc') $sql .= " DESC"; //Agrega la orden de ordenado descendente
            else if ($order == 'asc') $sql .= " ASC"; //Agrega la orden de ordenado ascendente
        }

        //Paginación
        if (
            !empty($page) && is_numeric($page) && $page > 0 &&
            !empty($limit) && is_numeric($limit) && $limit > 0
        ) {
            $pos = $limit * ($page - 1);
            $sql .= " LIMIT $pos, $limit";
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

    //Sanitiza un arreglo
    public function sanitize_array($array)
    {
        for ($i = 0; $i < count($array); $i++) {
            $newarray[$i] = htmlspecialchars($array[$i]);
        }
        return $newarray;
    }
}
