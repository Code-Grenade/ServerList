<?php
    if (!isset($serverid))
    {
        if (!isset($_GET['detailed']))
        {
            return;
        }
        $serverid = intval($_GET['detailed']);
    }

    $errors = [];

    require_once __DIR__ . '/../config/database.php';
    require __DIR__ . '/../SourceQuery/bootstrap.php';
    use xPaw\SourceQuery\SourceQuery;

    $SqlQuery = "SELECT * FROM `servers` WHERE `id`='$serverid';";
    $SqlStmt = $handler->prepare($SqlQuery);
    $SqlStmt->execute();
    $SqlCount = $SqlStmt->rowCount();

    if ($SqlCount == 0)
    {
        $errors[] .= "Can't find server by id \"$serverid\"";
        return;
    }

    $result = $SqlStmt->fetch(PDO::FETCH_OBJ);

    $ip = $result->ip;
    $port = $result->port;

    $Query = new SourceQuery();
    $Query->Connect($ip, $port, 3, SourceQuery::GOLDSOURCE);

    ?>

    <table class="table table-responsive table-dark table-hover text-center">
    <thead>
        <tr>
            <th>#</th>
            <th scope="col">Player Name</th>
            <th scope="col">Score</th>
            <th scope="col">Time Played</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($Query->GetPlayers() as $Player)
            {
                ?>
                    <tr>
                        <td class="text-warning"><?php echo $Player['Id']; ?></td>
                        <td class="text-warning"><?php echo $Player['Name']; ?></td>
                        <td class="text-warning"><?php echo $Player['Frags']; ?></td>
                        <td class="text-warning"><?php echo $Player['TimeF']; ?></td>
                    </tr>
                <?php
            }
        ?>

    </tbody>
</table>
<?php
?>
    <table class="table table-responsive table-dark table-hover text-center scrollable">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Cvar</th>
        <th scope="col">Value</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $counter = 0;

            foreach ($Query->GetRules() as $key => $value)
            {
                echo "<tr>";
                echo "<td class='text-warning'> $counter </td>";
                echo "<td class='text-warning'> {$key} </td>";
                echo "<td class='text-warning'> {$value} </td>";
                echo "</tr>";

                $counter++;
            }
        ?>
    
    </tbody>
    </table>
    <?php

?>