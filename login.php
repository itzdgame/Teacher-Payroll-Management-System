<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- SITE TITLE -->
    <title></title>
    <!-- Favicons -->
    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->



    <?php
    require_once 'sessions.php';
    if(isset($_SESSION['login'])){
        if($_SESSION['login'] == true){
            header('location:index.php');
        }
    }
    ?>
    <?php
    require_once 'database.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        $db = new database();
        $res = $db -> run_query( "SELECT * FROM admin
                                    WHERE admin_user = '$username'
                                    AND admin_pass = md5('$password');");
        if($res -> num_rows > 0){
            session_start();
            $_SESSION['login'] = true;
            header('location:index.php');
        }else{
            echo "<div class='alert alert-danger'> Invalid Username OR Password!</div>";
        }
    }
    ?>
</head>
<body>
<header >
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header col-md-offset-3">
                <p  class="navbar-brand">Teacher Payroll</p>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="user_manual/docs.html" target="_blank">User Manual</a></li>
            </ul>

            <!-- Collect the nav links, forms, and other content for toggling -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
<div class="container">

    <div class="col-md-offset-4 col-md-4">
        <form action="" method="post">
            <fieldset >
                <legend><h1>Login Section</h1></legend>
                <label for="username" class="h4">Enter the Username</label><br>
                <input type="text" class="form-control col-md-4" name="username" id="username"><br>
                <label for="password" class="h4">Enter the password</label><br>
                <input type="password" class="form-control col-md-4" name="password" id="password"><br>
                <input type="submit" value="Login" class="btn btn-success btn-lg btn-group-justified">
            </fieldset>

        </form>
        </div>
</div>
</body>
</html>

<style>
    .user{
        color: yellow;
        font-weight: bolder;
        font-size: larger;
        text-align: center;
        text-shadow: 2px 2px rgba(37, 37, 37, 0.562);
        position: fixed;
        top: 60px;
        right: 0;
        display: block;
        height: auto;
        background-color: #222222c2;
        padding: 15px;
        border-radius: 2px;
        text-align: end;
        text-decoration: none;
    }
    .doc{
        color: yellow;
        font-weight: bolder;
        font-size: larger;
        text-align: center;
        text-shadow: 2px 2px rgba(37, 37, 37, 0.562);
        position: fixed;
        bottom: 0;
        right: 0;
        display: block;
        height: auto;
        background-color: #222222c2;
        padding: 15px;
        border-radius: 2px;
        text-align: end;
        text-decoration: none;
    }
</style>

<div class="user">
    Admin Login: <br>
    Username : admin<br>
    Password : pass
</div>

<div  class="doc">
    <a href='user_manual/docs.html' style='color:yellow;text-decoration:none;' target="_blank">Documentation</a>
</div>