<?php
require "../config.php";
try {
    $tarefas = [];
    foreach ($_pdo->query("
        SELECT * 
        FROM tarefas 
        ORDER BY data
        ") as $tarefa) {
        $tarefas[] = [
            "id" => $tarefa['id'],
            "descricao" => $tarefa['descricao'],
            "categoria" => $tarefa['categoria'],
            "data" => $tarefa['data'],
        ];
    }
    print json_encode($tarefas);
} catch (PDOException $e) {
    die($e->getMessage());
}
