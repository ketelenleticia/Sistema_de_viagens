<?php

$conexao = new PDO("mysql:host=mysql;dbname=sistema_viagens;charset=utf8","root","root");
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>