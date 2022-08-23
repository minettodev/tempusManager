<?php
require "../config.php";
require "lib/class.Horario.php";

$id = $_GET['id'];

$p = Horario::findByPk($id);
if (!$p) throw new Exception("Usuário não encontrado!");
$p->setDia($_POST['dia']);
$p->setdescricaoh($_POST['task']);
$p->setTempo($_POST['tempo']);
$p->alterar();
print $p;
