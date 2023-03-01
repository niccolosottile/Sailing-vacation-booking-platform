<?php
// Initialize the session
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .table-container {
            border: 2px solid;
            color: black;
            text-align: center;
            width: 90%;
        }

    </style>
    <!-- Chart to analyse sales per month -->
    <script>
        window.onload = function() {

            CanvasJS.addColorSet("blue",
                [ //colorSet Array
                    "#004789",
                    "#004789",
                    "#004789",
                    "#004789",
                    "#004789",
                    "#004789",
                    "#004789",
                    "#004789",
                    "#004789",
                    "#004789",
                    "#004789",
                    "#004789"
                ]);

            var chart = new CanvasJS.Chart("chartContainer", {
                colorSet: "blue",
                animationEnabled: true,
                exportEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Total sales sorted by month"
                },
                axisY: {
                    includeZero: true,
                    title: "Sales value per month (€)",
                    titleFontSize: 13,
                },
                data: [{
                    type: "column", //change type to bar, line, area, pie, etc
                    //indexLabel: "{y}", //Shows y value on all Data Points
                    indexLabelFontColor: "#808080",
                    indexLabelFontSize: 16,
                    indexLabelPlacement: "outside",
                    dataPoints: [

                        {
                            label: 'January',
                            y: 0
                        },
                        {
                            label: 'February',
                            y: 0
                        },
                        {
                            label: 'March',
                            y: 0
                        },
                        {
                            label: 'April',
                            y: 0
                        },
                        {
                            label: 'May',
                            y: 0
                        },
                        {
                            label: 'June',
                            y: 0
                        },
                        {
                            label: 'July',
                            y: 0
                        },
                        {
                            label: 'August',
                            y: 0
                        },
                        {
                            label: 'September',
                            y: 0
                        },
                        {
                            label: 'October',
                            y: 0
                        },
                        {
                            label: 'November',
                            y: 0
                        },
                        {
                            label: 'December',
                            y: 0
                        }

                    ]
                }]
            });
            <?php
                            if($_SERVER["REQUEST_METHOD"] == "POST"){
                                    require_once 'config.php';
                                    
                                    $month_total = 0;
                                    $month = 0;
                                    $Yearselected = $_POST['year_selected'];
                                    ?>
            chart.options.title.text = "Total sales sorted by month in <?php echo $Yearselected; ?>";
            <?php
                                    // Getting the data for the chart //
                                    $salesdata = $link->prepare("
                                    SELECT SUM(amount_payed) AS month_total,MONTH(created_at) AS month   
                                    FROM orders 
                                    WHERE YEAR(created_at) = ? 
                                    GROUP BY MONTH(created_at)");
                                    
                                    // This is used to allow admin to filter by year //
                                    $salesdata->bind_param("i",$Yearselected);
                                    
                                    $salesdata->execute();
                                    $result = $salesdata->get_result();
                                    while($row = $result->fetch_assoc()){
                                        $month_total = $row['month_total'];
                                        $month = $row['month'];
                                        ?>
            chart.options.data[0].dataPoints[<?php echo $month-1; ?>].y = <?php echo $month_total; ?>;
            <?php } ?>
            <?php } ?>

            var pieChart = new CanvasJS.Chart("pieChart", {
                animationEnabled: true,
                title: {
                    text: "Your customers' nationalities",
                    horizontalAlign: "center"
                },
                data: [{
                    type: "doughnut",
                    startAngle: 60,
                    //innerRadius: 60,
                    indexLabelFontSize: 17,
                    indexLabel: "{label} - #percent%",
                    toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                    dataPoints: [




                        <?php
                                    require_once 'config.php';
                                    
                                    $Qty = 0;
                                    $Nationality = '';
                                    
                                    // Getting the data for the pie chart //
                                    $nationalities = $link->prepare("
                                    SELECT COUNT(CustomerID), Nationality
                                    FROM customers
                                    GROUP BY Nationality;");
                                    
                                    $nationalities->execute();
                                    $result = $nationalities->get_result();
                                    while($row = $result->fetch_assoc()){
                                        $Qty = $row['COUNT(CustomerID)'];
                                        $Nationality = $row['Nationality'];
                                        ?> {
                            y: <?php echo $Qty; ?>,
                            label: "<?php echo $Nationality; ?>"
                        },
                        <?php } ?>
                    ]
                }]
            });
            chart.render();
            pieChart.render();
        }

    </script>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-default navbar-fixed-top my-navbar">
            <br>
            <br>
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand header-text-change" style="color:white;" href="#">Admin Panel for Edenj</a>
            </div>
            <!-- Collection of nav links, forms, and other content for toggling -->
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a href="admin-panel.php" style="font-size: 17px; margin-left: 100px;">PANEL INFO</a></li>
                    <li class="nav-item"><a href="admin-add-trip.php" style="font-size: 17px; margin-left: 5px;">MANAGE TRIPS</a></li>
                    <li class="nav-item"><a href="admin-manage.php" style="font-size: 17px; margin-left: 5px;">MANAGE BOOKINGS</a></li>
                    <li class="nav-item active"><a href="admin-analysis.php" style="font-size: 17px; margin-left: 5px;">ANALYSE DATA</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">

                    <li><a href="admin-account.php" style="font-size: 17px;"><span class="glyphicon glyphicon glyphicon-user"></span> ACCOUNT</a></li>
                    <li><a href="logout.php" style="font-size: 18px;margin-right: 10px;"><span class="	glyphicon glyphicon-log-out"></span> LOGOUT</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <div class="container-fluid text-container">
        <h2>In this section you can analyse your operations</h2>
    </div>
    <br>
    <br>
    <div class="container-fluid" style="width:90%;">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped text-center center">
                    <tbody>
                        <tr>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group">
                                    <td>
                                        <label>Select year for analysis: </label>
                                    </td>
                                    <td>
                                        <select class="form-control" name="year_selected">
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                        </select>
                                    </td>
                                </div>
                                <td>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value="Analyse">
                                    </div>
                                </td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid table-container">
        <div class="row">
            <div class="col-lg-12">
                <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                <script src="canvas.js"></script>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="container-fluid table-container">
        <div class="row">
            <div class="col-lg-12">
                <div id="pieChart" style="height: 300px; width: 100%;"></div>
                <script src="canvas.js"></script>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
</body>

</html>
