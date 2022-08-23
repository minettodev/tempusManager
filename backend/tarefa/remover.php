<?php
require "../config.php";
require "lib/class.Tarefa.php";

$id = $_GET['id'];

$p = Tarefa::findByPk($id);
if (!$p) throw new Exception("Usuário não encontrado!");
$p->remover();
print $p;
