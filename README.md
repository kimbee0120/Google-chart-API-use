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
*There are lots of good examples in Google Chart website.*
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

