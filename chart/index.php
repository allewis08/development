 <?php
$con=mysql_connect("localhost","formalbu_allewis","teamexp") or die("Failed to connect with database!!!!");
mysql_select_db("formalbu_dev", $con); 
// The Chart table contains two fields: weekly_task and percentage
// This example will display a pie chart. If you need other charts such as a Bar chart, you will need to modify the code a little to make it work with bar chart and other charts
$sth = mysql_query("SELECT * FROM splitpayment");

/*
---------------------------
example data: Table (Chart)
--------------------------
weekly_task     percentage
Sleep           30
Watching Movie  40
work            44
*/

$rows = array();
//flag is not needed
$flag = true;
$table = array();
$table['cols'] = array(

    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'name', 'type' => 'string'),
    array('label' => 'amount', 'type' => 'number')

);

$rows = array();
while($r = mysql_fetch_assoc($sth)) {
    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $r['name']); 

    // Values of each slice
    $temp[] = array('v' => (int) $r['amount']); 
    $rows[] = array('c' => $temp);
}

$table['rows'] = $rows;
$jsonTable = json_encode($table);
//echo $jsonTable;
?>

<html>
  <head>
    <!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    function drawChart() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$jsonTable?>);
      var options = {
           title: 'My Events Deposit',
          is3D: 'true',
          width: 800,
          height: 600
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>
  </head>

<body>
    <!--this is the div that will hold the pie chart-->
    <div id="chart_div">
 
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

   
  </div>
<div>
<form action="insert.php" method="post">
Name: <input type="text" name="name" id="name"><br>
Amount: <input type="text" name="amount" id="amount"><br>
<input type="submit">
</form></div><div>
<center><a href="http://www.formalbuilder.com/dev/"><button>Go Back to API's</button></a></center></div>

    <div id="piechart" style="width: 900px; height: 500px;"></div>

 </body>
</html>
