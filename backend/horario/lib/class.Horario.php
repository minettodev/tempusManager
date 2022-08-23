<?php
class Horario
{
    private $id;
    private $dia = "";
    private $task = "";
    private $tempo = "";

    function __toString()
    {
        return json_encode([
            "id" => $this->id,
            "dia" => $this->dia,
            "task" => $this->task,
            "tempo" => $this->tempo
        ]);
    }

    static function findByPk($id)
    {
        global $_tempoBASE;
        global $_pdo;
        $consulta = $_pdo->prepare("SELECT * FROM Horarios WHERE id=:id");
        $consulta->execute([':id' => $id]);
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'Horario');
        return $consulta->fetch();
    }

    function setDia($v)
    {
        $this->dia = $v;
    }
    function setTask($v)
    {
        $this->task = $v;
    }
    function setTempo($v)
    {
        $this->tempo = $v;
    }
    function getDia()
    {
        return $this->dia;
    }
    function getTask()
    {
        return $this->task;
    }
    function getTempo()
    {
        return $this->tempo;
    }

    function inserir()
    {
        global $_tempoBASE;
        global $_pdo;
        try {
            $consulta = $_pdo->prepare("INSERT INTO Horarios(dia, task, tempo) VALUES(:dia,:task,:tempo) ORDER BY dia, tempo");
            $consulta->execute([
                ':dia' => $this->dia,
                ':task' => $this->task,
                ':tempo' => $this->tempo
            ]);
            $consulta = $_pdo->prepare("SELECT id FROM Horarios ORDER BY id DESC LIMIT 1");
            $consulta->execute();

            $tempo = $consulta->fetch(PDO::FETCH_ASSOC);
            $this->id = $tempo['id'];
        } catch (PDOException $e) {
            throw new Exception("Ocorreu um erro interno!");
        }
    }

    function alterar()
    {
        global $_tempoBASE;
        global $_pdo;
        try {
            $consulta = $_pdo->prepare("UPDATE Horasios SET dia = :dia, task = :task, tempo = :tempo WHERE id= :id");
            $consulta->execute([
                ':id' => $this->id,
                ':dia' => $this->dia,
                ':task' => $this->task,
                ':tempo' => $this->tempo
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function remover()
    {
        global $_tempoBASE;
        global $_pdo;
        try {
            $consulta = $_pdo->prepare("DELETE FROM Horarios WHERE id= :id");
            $consulta->execute([':id' => $this->id]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
