<?php
require "../config.php";
require "lib/class.Horario.php";

$id = $_GET['id'];

$p = Horario::findByPk($id);
if (!$p) throw new Exception("Usuário não encontrado!");
$p->remover();
print $p;
