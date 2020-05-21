<?php
	define("IN_CODE",1);
	include("dbh.php");

	$query = "SELECT user, count(user) as num from tablename group by user order by num desc limit 10";
	$result = mysqli_query($con, $query);
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load Charts and the corechart and barchart packages.
      google.charts.load('current', {'packages':['corechart']});

      // Draw the pie chart and bar chart when Charts is loaded.
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'user');
        data.addColumn('number', 'num');
        data.addRows([
          <?php 
	    $ct=0;
            while($row = mysqli_fetch_array($result))
            {
	      $user[$ct]=$row['user'];
	      $num[$ct]=$row['num'];
	      $ct++;
              echo "['".$row['user']."',".$row['num']."],";
            }
          ?>
       
        ]);

        //pie chart with counts
        var piechart_options = {title:'top 10(Count)',
                       width:400,
                       height:300,
                       pieSliceText: 'value'};
         var piechart = new google.visualization.PieChart(document.getElementById('piechart_div'));
        piechart.draw(data, piechart_options);

        //pie chart with percentatage
        var piechart_options2 = {title:'top 10(Percentage)',
                       width:400,
                       height:300};

        var piechart2 = new google.visualization.PieChart(document.getElementById('piechart_div2'));
        piechart2.draw(data, piechart_options2);
        
        //barchart
        var barchart_options = {title:'top 10',
                       width:400,
                       height:300,
                       legend: 'none'};
        var barchart = new google.visualization.BarChart(document.getElementById('barchart_div'));
        barchart.draw(data, barchart_options);
      }
</script>