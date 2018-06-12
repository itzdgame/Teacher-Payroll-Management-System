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
    ob_start();
    require_once 'sessions.php';
    if($_SESSION['login'] == false){
        header('location:login.php');
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
                <li class=""><a href="index.php">Home</a></li>
                <li class=""><a href="payment.php">Pay Salary</a></li>
                <li class="active"><a href="paymentHistory.php">Payment History</a></li>

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
    <h1>PAYMENT</h1>
    <hr>

        <h4 class="text-center">Payment Historty</h4>

    <div class="well">
        <table class='table table-hover table-dark'>
            <thead>
            <tr>
                <th>
                    Payment ID
                </th>
                <th>
                    Name
                </th>
                <th>
                    Amount Paid
                </th>
                <th>
                    Month
                </th>
                <th>
                    Year
                </th>
                <th>
                    Payment Date
                </th>

            </tr>
            </thead>

            <tbody>
            <?php
            require_once 'database.php';
            $db = new database();
            $sql = "SELECT * FROM payment_details NATURAL JOIN teachers ORDER BY payment_date;";
            $result = $db -> run_query($sql);
            $sum = $db -> run_query("SELECT SUM(amount) FROM payment_details;");
            foreach($sum as $key => $value){
                $data =  $value;
            }
            $counter = 1;
            foreach ($result as $key => $value) {
                echo "<tr>
                            <td>" . $value['payment_id'] . "</td>
                            <td>" . $value['t_name'] . "</td>
                            <td>BDT " . $value['amount'] . "</td>
                            <td>" . $value['month'] . "</td>
                            <td>" . $value['year'] . "</td>
                            <td>" . $value['payment_date'] . "</td>
                            <td>

                            </td></tr>";
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th colspan='11'>
                    Total Paid Amount : BDT <?php echo number_format($data['SUM(amount)'],2);?>
                </th>
            </tr>
            </tfoot>
        </table>
    </div>
</section>


<!-- JS -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>