<?php
session_start();

$id = $_GET['id'];

$Horarios = $_SESSION['Horarios'];
foreach ($Horarios as $p) {
    if ($p['id'] == $id) {
        print json_encode($p);
        die();
    }
}
header("HTTP/1.0 404 Not Found");
print json_encode("Usuário não encontrado!");
