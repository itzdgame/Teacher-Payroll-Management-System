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
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>


    <?php
    ob_start();
    require_once 'sessions.php';
    if($_SESSION['login'] == false){
        header('location:login.php');
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['t_id'])){
        // echo '<pre>';
        // print_r($_REQUEST);
        // echo '</pre>';
        require_once 'database.php';
        $db = new database();
        $sql = "INSERT INTO `payment_details`(`t_id`, `amount`, `month`, `year`) VALUES ('" . filter_input(INPUT_POST, 't_id') . "', '" . filter_input(INPUT_POST, 't_amount') . "', '" . filter_input(INPUT_POST, 'payment_month') . "', '" . filter_input(INPUT_POST, 'payment_years') . "');";
        $result = $db -> run_query($sql);
        if($result){
            echo "<div class='alert alert-success'>Teacher Salary Payment Successful!</div>";
        }else{
            echo "<div class='alert alert-danger'>Teacher Salary Payment Not Successful!</div>";
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
                <li class=""><a href="index.php">Home</a></li>
                <li class="active"><a href="payment.php">Pay Salary</a></li>
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
    <h1>PAYMENT</h1>
    <hr>
    <ul class="nav nav-tabs nav-justified">
        <li><a href="#pay" data-toggle="tab"><h4>Make Payment</h4></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active fade in" id="pay">
            <div class="col-md-12 well">
                <script >
                    function show_teacher(){
                        var id = document.getElementById('selectTeacher').value;
                        var ajax = new XMLHttpRequest();
                        ajax.open('GET', 'get_teacher_data.php?t_id=' + id, true);
                        ajax.send();
                        console.log(ajax);
                        ajax.onreadystatechange = function(){
                            if(ajax.readyState == 4){
                                var output_html = "<fieldset ><legend>Teacher Information</legend><table class='table table-bordered table-striped table-hover table-responsible'><tbody>";
                                var Teacher_data = JSON.parse(ajax.responseText);
                                Teacher_data.forEach(function(element) {
                                    output_html += "<tr><td> Teacher Name :</td><td>" + element['t_name'] + "</td>";
                                    output_html += "<tr><td> Designation :</td><td>" + element['t_desig'] + "</td>";
                                    output_html += "<tr><td> Highest Qualifications :</td><td>" + element['t_qlf'] + "</td>";
                                    output_html += "<tr><td> Base Salary :</td><td>" + element['t_salary'] + "</td>";
                                    output_html += "<tr><td> House Renting Allowances :</td><td>" + element['t_hra'] + "</td>";
                                    output_html += "<tr><td> Traveling Allowances :</td><td>" + element['t_ta'] + "</td>";
                                    output_html += "<tr><td> Gross Salary Payable :</td><td>" + element['t_gross_salary'] + "</td>";
                                    output_html += "<tr><td> Income Tax Payable :</td><td>" + element['t_it'] + "</td>";
                                    output_html += "<tr><td> Net Salary Payable :</td><td>" + element['t_net_salary'] + "</td></tr>";
                                output_html += "</tbody></table></fieldset><fieldset><legend>Payment Cycle</legend><form method='post'><input type='hidden' name='t_id' value='" +  element['t_id']  + "'/><input type='hidden' name='t_amount' value='" +  element['t_net_salary']  + "'/><label for='payment_month'>Payment Month</label><br><select name='payment_month' id='' class='form-control '><option value='Jan'>Jan</option>                    <option value='Feb'>Feb</option>                    <option value='Mar'>Mar</option>                    <option value='Apr'>Apr</option>                    <option value='May'>May</option>                    <option value='Jun'>Jun</option>                    <option value='Jul'>Jul</option>                    <option value='Aug'>Aug</option>                    <option value='Sep'>Sep</option>                    <option value='Oct'>Oct</option>                    <option value='Nov'>Nov</option>                    <option value='Dec'>Dec</option>                </select><br>                <label for='payment_years'>Payment Month</label><br>               <select name='payment_years' id='' class='form-control'>                    <option value='2018'>2018</option>                    <option value='2019'>2019</option>                    <option value='2020'>2020</option>                </select><br><input type='submit' class='btn btn-success btn-lg btn-group ' value='Make Payments'/></form></fieldset></fieldset>";
                                }, this);
                                document.getElementById('teacher_data').innerHTML = output_html;
                            }
                        }
                    }
                </script>
                <form action="" method="post">
                    <label for="selectTeacher">Select Teacher:</label><br>
                    <select name="selectTeacher" id="selectTeacher" class="form-control selectpicker" onchange="show_teacher()" title="Select a Teacher" data-live-search="true">
                        <?php
                        require_once 'database.php';
                        $db = new database();
                        $sql = "SELECT t_name,t_id FROM teachers;";
                        $result = $db -> run_query($sql);
                        if($result -> num_rows > 0){
                            $counter = 0;
                        foreach ($result as $key => $value) {
                            echo "<option value='".$value['t_id']."' data-tokens='".$value['t_name']."'>".$value['t_name']."</option>";

                            $counter ++;
                        }
                        }
                        ?>
                    </select><br>
                    <div id="teacher_data">

                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
</body>
</html>