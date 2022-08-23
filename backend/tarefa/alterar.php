<?php
require "../config.php";
require "lib/class.Tarefa.php";

$id = $_GET['id'];

$p = Tarefa::findByPk($id);
if (!$p) throw new Exception("Usuário não encontrado!");
$p->setDescricao($_POST['descricao']);
$p->setCategoria($_POST['categoria']);
$p->setData($_POST['data']);
$p->alterar();
print $p;
