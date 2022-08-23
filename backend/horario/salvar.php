<?php
require "../config.php";
require "lib/class.Horario.php";

try {
    $p = new Horario();
    $p->setDia($_POST['dia']);
    $p->setTask($_POST['task']);
    $p->setTempo($_POST['tempo']);
    $p->inserir();
    print $p;
} catch (Exception $e) {
    print json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}
