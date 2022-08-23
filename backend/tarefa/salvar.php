<?php
require "../config.php";
require "lib/class.Tarefa.php";

try {
    $p = new Tarefa();
    $p->setDescricao($_POST['descricao']);
    $p->setCategoria($_POST['categoria']);
    $p->setData($_POST['data']);
    $p->inserir();
    print $p;
} catch (Exception $e) {
    print json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}
