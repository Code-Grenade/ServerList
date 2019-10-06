<?php
    require_once __DIR__ . '\..\config\database.php';

    $errors = [];

    $rowcheckquery = "SELECT * FROM `servers`;";
    $rowstmt = $handler->prepare($rowcheckquery);
    $rowstmt->execute();
    $result = $rowstmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($result))
    {
        echo 'kur';
        $errors .= "There are no Servers in the List";
    }

    if (empty($errors))
    {

        foreach ($result as $row)
        {
            $ip = $row->ip;
            $port = $row->port;

            $Query->Connect($ip, $port, 1, SourceQuery::GOLDSOURCE);
            $ServerInfo = $Query->GetInfo();
?>
            <table class="table table-dark table-hover">
                <thead>
                <tr>
                    <th>Server Name</th>
                    <th>IP Address</th>
                    <th>Pl/Bots/Max</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $ServerInfo['HostName']; ?></td>
                    <td><?php echo SQ_SERVER_ADDR; ?></td>
                    <td><?php echo $ServerInfo['Players'] - $ServerInfo['Bots'] . '/' . $ServerInfo['Bots'] . '/' . $ServerInfo['MaxPlayers']; ?></td>
                </tr>
                </tbody>
            </table>
<?php 
        }
    }
    else
    {
        ?>
        <div class="text-warn">
            <?php
                foreach ($errors as $error)
                {
                    echo $error;
                }
            ?>
        </div
        <?php
    }