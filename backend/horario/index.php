<?php
require "../config.php";
try {
    $Horarios = [];
    foreach ($_pdo->query("
        SELECT * 
        FROM Horarios 
        ORDER BY tempo, dia
        ") as $Horario) {
        $Horarios[$Horario['tempo']][$Horario['dia']] = [
            "id" => $Horario['id'],
            "task" => $Horario['task'],
        ];

?>
        <table class="table">
            <thead>
                <tr>
                    <th>Horário</th>
                    <th>Domingo</th>
                    <th>Segunda</th>
                    <th>Terça</th>
                    <th>Quarta</th>
                    <th>Quinta</th>
                    <th>Sexta</th>
                    <th>Sábado</th>
                </tr>

            </thead>
            <tbody>
                <?php foreach ($Horarios as $hora => $dias) { ?>
                    <tr>
                        <td><?php $hora ?></td>
                        <td><?php $dias ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
<?php
    }
    print_r($Horarios);
} catch (PDOException $e) {
    die($e->getMessage());
}


/*
    FOREACH 
    [11:00] => [
        1 => [
            'task 1,,
            'task 2',
        ]
        2 => [
            'task 3',
        ]
    ],
    [11:30] => [
        1 => [

        ]
    ]


*/