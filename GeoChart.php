<?php
	define("IN_CODE", 1);
	include("dbh.php");

	$query = "SELECT country, count(*) as num from DBTABLE 
where country is not null group by country order by num desc";
	$result = mysqli_query($con, $query);
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
        'mapsApiKey': 'YOURKEY' //you should request from google developer website 
      });
      //load map whenever the website load
      google.charts.setOnLoadCallback(drawRegionsMap);

      //draw map
      function drawRegionsMap(){
        var data = google.visualization.arrayToDataTable([
          ['Country', 'numbers'],
          <?php 
        $ct=0;
            //get data from the query 
          	while($row = mysqli_fetch_array($result))
          	{
			$country[$ct]=$row['country'];
			$num[$ct]=$row['num'];
          		echo "['".$row['country']."',".$row['num']."],";
			$ct++;
          	}
          ?>
        ]);

        var options = {title: 'TITLE'};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="regions_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>
