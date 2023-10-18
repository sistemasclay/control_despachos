<?php

      try {

      $conexion_pg = &ADONewConnection('postgres');

      $conexion_pg->PConnect('host=localhost dbname=mic port=5432 user=postgres password=root');
      //$conexion_pg->PConnect('host=localhost dbname=mic port=5433 user=postgres password=root');

      } catch (exception $e) {

      var_dump($e);

      }
?>
