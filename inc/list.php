<?php

    if (isset($_GET['detailed']))
    {
        $serverid = $_GET['detailed'];
        require __DIR__ . '\\detailed.php';
        return;
    }

    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../config/resources.php';
    require __DIR__ . '/../SourceQuery/bootstrap.php';
    use xPaw\SourceQuery\SourceQuery;

    $errors = [];

    $rowcheckquery = "SELECT * FROM `servers`;";
    $rowstmt = $handler->prepare($rowcheckquery);
    $rowstmt->execute();
    $result = $rowstmt->fetchAll(PDO::FETCH_OBJ);
    $rowscount = $rowstmt->rowCount();

    if ($rowscount == 0)
    {
        $errors[] .= 'There are no Servers in the List';
    }

    if (empty($errors))
    {
        ?>
        <table class="table table-responsive table-dark table-hover text-center">
            <thead>
            <tr>
                <th>Status</th>
                <th>Server Name</th>
                <th>IP Address</th>
                <th>Pl/Bots/Max</th>
            </tr>
            </thead>
            <tbody>

        <?php
        $Query = new SourceQuery();
        foreach ($result as $row)
        {
            $ip = $row->ip;
            $port = intval($row->port);

            $success = true;

            try
            {
                $Query->Connect($ip, $port, 1, SourceQuery::GOLDSOURCE);
                $ServerInfo = $Query->GetInfo();
            }
            catch(Exception $e )
            {
                $success = false;
                // echo $e->getMessage();
            }
            finally
            {
                $Query->Disconnect();
            }

            switch ($success)
            {
                case true:
                ?>
                <tr>
                    <td><img src="<?php echo RESOURCES_FOLDER . ONLINE_ICON; ?>" title="This server is online" alt="online"/></td>
                    <td class="text-success"><a href="index.php?detailed=<?php echo $row->id; ?>" class="text text-success"><?php echo $ServerInfo['HostName']; ?></a></td>
                    <td class="text-success"><?php echo $ip; ?></td>
                    <td class="text-success"><?php echo $ServerInfo['Players'] - $ServerInfo['Bots'] . '/' . $ServerInfo['Bots'] . '/' . $ServerInfo['MaxPlayers']; ?></td>
                </tr>
                <?php

                $Updatehnquery = "UPDATE servers SET hostname=:hostname WHERE ip='{$ip}' AND port=$port;";
                $Updatestmt = $handler->prepare($Updatehnquery);
                $Updatestmt->execute(array(':hostname' => $ServerInfo['HostName']));
                break;

                default:
                ?>
                <tr>
                    <td><img src="<?php echo RESOURCES_FOLDER . OFFLINE_ICON; ?>" class="img-responsive" title="This server is offline" alt="offline"/></td>
                    <td class="text-danger"><?php echo $row->hostname ?></td>
                    <td class="text-danger"><?php echo $ip; ?></td>
                    <td class="text-danger">0/0/0</td>
                </tr>
                <?php
                break;
            }
        }
        ?>

            </tbody>
        </table>
    <?php
    }
    else
    {
        ?>

        <div class="alert alert-danger" role="alert">
            <?php
                foreach ($errors as $error)
                {
                    echo $error;
                }
            ?>
        </div>
        <?php
    }
?>