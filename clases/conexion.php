<?php

      try {

      $conexion_pg = &ADONewConnection('postgres');

      $conexion_pg->PConnect('host=localhost dbname=control_despacho port=5432 user=postgres password=root');

      } catch (exception $e) {

      var_dump($e);

      }
?>
