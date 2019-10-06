<?php
    require_once 'inc/session.php';

    if (isset($_SESSION['logged']))
    {
        header('Location: index.php');
    }

    if (isset($_POST['login']))
    {
        require_once 'config.php';

        $errors = [];

        $username           = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        $password           = htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8');
        var_dump($username);
        var_dump($password);

        if ($username != ADMIN_USER || $password != ADMIN_PASS)
        {
            $errors[] .= "Can't login!";
        }
        else
        {
            $_SESSION['logged'] = true;
            header('Location: index.php');
        }
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

    <title>Server List System</title>
</head>

<body>
    <div class='container'>
        <form method="POST">
            <div class="form-group">
                <label for="user">User</label>
                <input type="texr" class="form-control" id="username" name="username" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
            </div>
            <button type="submit" class="btn btn-primary" id="login" name="login">Submit</button>
        </form>
    </div>
</body>
</html> 