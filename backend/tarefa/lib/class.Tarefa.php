<?php
class Tarefa
{
    private $id;
    private $descricao = "";
    private $categoria = "";
    private $data = "";

    function __toString()
    {
        return json_encode([
            "id" => $this->id,
            "descricao" => $this->descricao,
            "categoria" => $this->categoria,
            "data" => $this->data
        ]);
    }

    static function findByPk($id)
    {
        global $_DATABASE;
        global $_pdo;
        $consulta = $_pdo->prepare("SELECT * FROM Tarefas WHERE id=:id");
        $consulta->execute([':id' => $id]);
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'Tarefa');
        return $consulta->fetch();
    }

    function setDescricao($v)
    {
        $this->descricao = $v;
    }
    function setCategoria($v)
    {
        $this->categoria = $v;
    }
    function setData($v)
    {
        $this->data = $v;
    }
    function getDescricao()
    {
        return $this->descricao;
    }
    function getCategoria()
    {
        return $this->categoria;
    }
    function getData()
    {
        return $this->data;
    }

    function inserir()
    {
        global $_DATABASE;
        global $_pdo;
        try {
            $consulta = $_pdo->prepare("INSERT INTO Tarefas(descricao, categoria, data) VALUES(:descricao,:categoria,:data) ORDER BY data");
            $consulta->execute([
                ':descricao' => $this->descricao,
                ':categoria' => $this->categoria,
                ':data' => $this->data
            ]);
            $consulta = $_pdo->prepare("SELECT id FROM Tarefas ORDER BY id DESC LIMIT 1");
            $consulta->execute();

            $data = $consulta->fetch(PDO::FETCH_ASSOC);
            $this->id = $data['id'];
        } catch (PDOException $e) {
            throw new Exception("Ocorreu um erro interno!");
        }
    }

    function alterar()
    {
        global $_DATABASE;
        global $_pdo;
        try {
            $consulta = $_pdo->prepare("UPDATE Tarefas SET descricao = :descricao, categoria = :categoria, data = :data WHERE id= :id");
            $consulta->execute([
                ':id' => $this->id,
                ':descricao' => $this->descricao,
                ':categoria' => $this->categoria,
                ':data' => $this->data
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function remover()
    {
        global $_DATABASE;
        global $_pdo;
        try {
            $consulta = $_pdo->prepare("DELETE FROM Tarefas WHERE id= :id");
            $consulta->execute([':id' => $this->id]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
