<?php

class ApiView
{

  public function response($data, $status = 200)
  {
    header("Content-Type: application/json");
    header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));

    if (is_array($data)) {
      foreach ($data as $key => $idata) {
        if (isset($idata->especificaciones))
          $idata->especificaciones = unserialize($idata->especificaciones);
      }
    } else if (is_object($data)) {
      if (isset($data->especificaciones))
        $data->especificaciones = unserialize($data->especificaciones);
    }

    // convierte los datos a un formato json
    echo json_encode($data);
  }

  private function _requestStatus($code)
  {
    $status = array(
      200 => "OK",
      201 => "Created",
      204 => "No Content",
      400 => "Bad request",
      404 => "Not found",
      500 => "Internal Server Error"
    );
    return (isset($status[$code])) ? $status[$code] : $status[500];
  }
}
