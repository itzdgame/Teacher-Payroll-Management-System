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
    <style>
        table
        {
            background-color: #272b30;
        }
        .form-control
        {
            width: 66%;
        }
    </style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->



    <?php

require_once 'sessions.php';
if($_SESSION['login'] == false){
    header('location:login.php');
}?>
<link rel="stylesheet" href="bootstrap.css">
<?php
require_once 'database.php';
$db = new database();


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $t_name =filter_input(INPUT_POST, 't_name');
    $t_desig =filter_input(INPUT_POST, 't_desig');
    $t_qlf =filter_input(INPUT_POST, 't_qlf');
    $t_salary =filter_input(INPUT_POST, 't_salary');
    $t_hra =filter_input(INPUT_POST, 't_hra');
    $t_ta =filter_input(INPUT_POST, 't_ta');
    $t_gross_salary =filter_input(INPUT_POST, 't_gross_salary');
    $t_it =filter_input(INPUT_POST, 't_it');
    $t_net_salary =filter_input(INPUT_POST, 't_net_salary');
    $result = $db -> run_query("INSERT INTO `teachers`  
                                VALUES (NULL, 
                                            '$t_name', 
                                            '$t_desig', 
                                            '$t_qlf', 
                                            '$t_salary', 
                                            '$t_hra', 
                                            '$t_ta', 
                                            '$t_gross_salary', 
                                            '$t_it', 
                                            '$t_net_salary');");
    if($result){
        echo "<div class='alert alert-success'> Teacher Added to Database!</div>";
    }else{
        echo "<div class='alert alert-danger'> Teacher Not Added to Database!</div>";
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
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li class=""><a href="payment.php">Pay Salary</a></li>
                <li class=""><a href="paymentHistory.php">Payment History</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if(isset($_GET['action']) && $_GET['action'] == 'logout'){
                    $_SESSION['login'] = false;
                    header('location:login.php');
                }
                ?>
                <li><a href="?action=logout">Logout</a></li>
            </ul>
            <!-- Collect the nav links, forms, and other content for toggling -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
<section id="body" class="container">
<h1>ADMIN DASHBOARD</h1>
    <hr>
    <ul class="nav nav-tabs nav-justified">
        <li><a href="#teacherTable" data-toggle="tab"><h4>Available Teachers</h4></a></li>
        <li><a href="#insertTeacher" data-toggle="tab"><h4>Insert New Teacher</h4></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active fade in" id="teacherTable">
        <div class="col-md-12 well">
            <table class='table table-hover table-dark'>
                <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Designation
                    </th>
                    <th>
                        Qualification
                    </th>
                    <th>
                        Basic Salary
                    </th>
                    <th>
                        HRA
                    </th>
                    <th>
                        TA
                    </th>
                    <th>
                        Gross Salary
                    </th>
                    <th>
                        Income Tax
                    </th>
                    <th>
                        Net Salary
                    </th>
                    <th>
                        Controls
                    </th>
                </tr>
                </thead>

                <tbody>

                <?php
                $result = $db -> run_query("SELECT * FROM teachers ORDER BY t_name;");
                $counter = 1;
                foreach ($result as $key => $value) {
                    echo "<tr><td>" . $counter . "</td>
                            <td>" . $value['t_name'] . "</td>
                            <td>" . $value['t_desig'] . "</td>
                            <td>" . $value['t_qlf'] . "</td>
                            <td>" . $value['t_salary'] . "</td>
                            <td>" . $value['t_hra'] . "</td>
                            <td>" . $value['t_ta'] . "</td>
                            <td>" . $value['t_gross_salary'] . "</td>
                            <td>" . $value['t_it'] . "</td>
                            <td>" . $value['t_net_salary'] . "</td>
                            <td>

                                <form action = 'update.php' method='post'>
                                    <input type='hidden' name='t_id' value='" . $value['t_id'] . "'/>
                                    <input type='submit' value='Update' class='btn btn-primary btn-xs'/>
                                </form>
                                <form action='delete.php' method='post'>
                                <input type='hidden' name='t_id' value='".$value['t_id']."'/>
                                <input type='submit' value='Delete' class='btn btn-danger btn-xs'/>
                                </form>
                            </td></tr>";
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan='11'>
                        Total Teachers : <?php echo $result -> num_rows;?>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
        <div class="tab-pane fade in" id="insertTeacher">
        <div class="well">
            <script>
                function updateSalary(){
                    var basic = parseFloat(document.getElementById('t_salary').value);
                    var ta = parseFloat(document.getElementById('t_ta').value);
                    var hra = parseFloat(document.getElementById('t_hra').value);
                    document.getElementById('t_gross_salary').value = basic + ta + hra;
                    var gross = document.getElementById('t_gross_salary').value;
                    var it = parseFloat(document.getElementById('t_it').value);
                    document.getElementById('t_net_salary').value = gross - it;
                }

            </script>
            <form action="" method="post">
                <label for="t_name" class="col-md-4">Enter Teacher Name </label>
                <input type="text" name="t_name" id="t_name" class="form-control col-md-6" required ><br>
                <label for="t_desig" class="col-md-4">Enter Teacher Designation </label>
                <input type="text" name="t_desig" id="t_desig" class="form-control col-md-6" required><br>
                <label for="t_qlf" class="col-md-4">Enter Teacher Qualification </label>
                <input type="text" name="t_qlf" id="t_qlf" class="form-control col-md-6" required><br>
                <label for="t_salary" class="col-md-4">Enter Teacher Salary </label>
                <input type="number" name="t_salary" id="t_salary" class="form-control col-md-6" required onkeyup="updateSalary()"><br>
                <label for="t_hra" class="col-md-4">Enter Teacher HRA </label>
                <input type="number" name="t_hra" id="t_hra" class="form-control col-md-6" required onkeyup="updateSalary()"><br>
                <label for="t_ta" class="col-md-4">Enter Teacher TA </label>
                <input type="number" name="t_ta" id="t_ta" class="form-control col-md-6" required onkeyup="updateSalary()"><br>
                <label for="t_gross_salary" class="col-md-4">Enter Teacher Gross </label>
                <input type="number" name="t_gross_salary" id="t_gross_salary" class="form-control col-md-6" readonly required  onkeyup="updateSalary()"><br>
                <label for="t_it" class="col-md-4">Enter Teacher Income Tax </label>
                <input type="number" name="t_it" id="t_it" class="form-control col-md-6" required onkeyup="updateSalary()"><br>
                <label for="t_net_salary" class="col-md-4">Enter Teacher Net Salary </label>
                <input type="number" name="t_net_salary" id="t_net_salary" class="form-control col-md-6" readonly required onkeyup="updateSalary()"><br>
                &nbsp;
                <input type="submit" value='Save Teacher Data!' class="btn btn-success btn-lg btn-group center-block">
            </form>
        </div>
    </div>
    </div>

</section>


<!-- JS -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>