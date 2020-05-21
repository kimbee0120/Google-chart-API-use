# Google Charts API
https://developers.google.com/chart/interactive/docs/gallery

*Google charts API provides many types of charts such as; Geo Chart,Pie Chart, Bar Chart, Line Chart, Map Charts etc.*

*Thie project will talk about data visualization with google chart API and MySQL*

** for db configuration check here https://github.com/kimbee0120/Get_Geo_Location

## Step1: 
- create query that you want to show data
- query should bring two data: item and quantity of the item
- connect to database: mysqli_query<br>
<b>ex) display top 10 user</b>
    ```php
    <?php
        $query = "SELECT user, count(user) as num from tablename group by user order by num desc limit 10";

        $result = mysqli_query($con, $query);
    >
    ```

## Step2:
*<b>There are lots of good examples in Google Chart website.</b>*
- use html and start script 
```javascript
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
```
- Load Charts: corechart and barchart packages.
- Draw the charts when the webpage is loaded 'setOnLoadCallback'
- if you don't want to show on the webpage right away when it loaded, don't use 'setOnLoadCallback'
```javascript
    // Load Charts and the corechart and barchart packages.
    google.charts.load('current', {'packages':['corechart']});

    // Draw the pie chart and bar chart when Charts is loaded.
    google.charts.setOnLoadCallback(drawChart);
```
## Step3:
- Start Fucntion
- When you add row for the visualization, start php again and bring the data from mysql
```javascript
function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'user');
        data.addColumn('number', 'num');
        data.addRows([
          <?php 
	    $ct=0;
            while($row = mysqli_fetch_array($result))
            {
                //insert user and count
	      $user[$ct]=$row['user'];
	      $num[$ct]=$row['num'];
	      $ct++;
              echo "['".$row['user']."',".$row['num']."],";
            }
          ?>
       
        ]);

        //option1 show in count
        var piechart_options = {title:'top 10 (Count)',
                       width:400,
                       height:300,
                       pieSliceText: 'value'};
         var piechart = new google.visualization.PieChart(document.getElementById('piechart_div'));
        piechart.draw(data, piechart_options);

        //option2 show in percentage
        var piechart_options2 = {title:'top 10 (Percentage)',
                       width:400,
                       height:300};

        var piechart2 = new google.visualization.PieChart(document.getElementById('piechart_div2'));
        piechart2.draw(data, piechart_options2);

        var barchart_options = {title:'top 10 Attempted penetrations',
                       width:400,
                       height:300,
                       legend: 'none'};
        var barchart = new google.visualization.BarChart(document.getElementById('barchart_div'));
        barchart.draw(data, barchart_options);
      }
```
