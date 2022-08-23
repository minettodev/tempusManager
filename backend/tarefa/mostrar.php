<?php
session_start();

$id = $_GET['id'];

$tarefas = $_SESSION['tarefas'];
foreach ($tarefas as $p) {
    if ($p['id'] == $id) {
        print json_encode($p);
        die();
    }
}
header("HTTP/1.0 404 Not Found");
print json_encode("Usuário não encontrado!");
