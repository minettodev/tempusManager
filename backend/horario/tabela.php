<?php
require "../config.php";
try {
    $Horarios = [];
    foreach ($_pdo->query("
        SELECT * 
        FROM Horarios 
        ORDER BY tempo
        ") as $Horario) {
        $Horarios[] = [
            "id" => $Horario['id'],
            "dia" => $Horario['dia'],
            "task" => $Horario['task'],
            "tempo" => $Horario['tempo'],
        ];
    }
    print json_encode($Horarios);
} catch (PDOException $e) {
    die($e->getMessage());
}
