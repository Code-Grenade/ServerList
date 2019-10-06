<?php
    require_once __DIR__ . '\config\database.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <title>User System</title>
</head>

<body>
    <div class='container'>

        <?php 
            if (empty($errors))
            {
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

                <?php
                foreach ($result as $row)
                {
                    $ip = $row->ip;
                    $port = $row->port;
        
                    $Query->Connect($ip, $port, 1, SourceQuery::GOLDSOURCE);
                    $ServerInfo = $Query->GetInfo();
                    ?>

                    <tr>
                        <td><?php echo $ServerInfo['HostName']; ?></td>
                        <td><?php echo SQ_SERVER_ADDR; ?></td>
                        <td><?php echo $ServerInfo['Players'] - $ServerInfo['Bots'] . '/' . $ServerInfo['Bots'] . '/' . $ServerInfo['MaxPlayers']; ?></td>
                    </tr>

                    <?php
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

    </div>
</body>
</html> 