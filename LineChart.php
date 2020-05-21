<?php
	define("IN_CODE",1);
	include("dbh.php");

	$query= "select timestamp as date, count(date) as num from TABLE group by timestamp order by num desc";
	$result = mysqli_query($con, $query);
  $rows=array();
  $table = array();

  //column 
  $table['cols']=array(
    array(
      'label' => 'Date', 
      'type' => 'datetime'
    ),
    array(
      'label' => 'Number',
      'type' => 'number'
    )
  );
while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $datetime = explode(".", $row["date"]);
 $sub_array[] =  array(
      "v" => 'Date(' . $datetime[0] . '000)'
     );
 $sub_array[] =  array(
      "v" => $row["num"]
     );
 $rows[] =  array(
     "c" => $sub_array
    );
}
$table['rows'] = $rows;
$jsonTable = json_encode($table);


?>
<html>
 <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript">
   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);
   function drawChart()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);

    var options = {
     title:' Data',
      height:500 ,
     legend:{position:'bottom'},
     hAxis: {
            format: 'MMM d,(EEE)',
            showTextEvery: 2, slantedText: true, slantedTextAngle: 30,
            gridlines: {
                color: 'transparent'
            },

          }
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

    chart.draw(data, options);
   }
  </script>
  <style>
  .page-wrapper
  {
   
  }
  </style>
 </head>  
 <body>
  <div class="page-wrapper">
   <br />
   <h2 align="center">Display Google Line Chart with JSON PHP & Mysql</h2>
   <div id="line_chart"></div>
  </div>
 </body>
</html>



