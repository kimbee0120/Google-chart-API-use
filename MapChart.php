<!DOCTYPE html>
<!-- google map chart need API key. you can request API key for google map in google developer website-->
<html>
<head>
    <!-- Map size-->
	<style>
		#map {
			height: 600px;
			margin: 0px;
			padding: 0px;
		}
	</style>
</head>
<body>
	<?php 
	define("IN_CODE",1);
	include("dbh.php");

    //data: country, count, latitude, longitude
	$query = "SELECT country, count(ip) as num, latitude, longitude from BDTABLE where country is not null group by country order by num desc limit 10;";
	mysqli_set_charset( $con, 'utf8');
	$result = mysqli_query($con,$query);
	$row = mysqli_num_rows($result);

	$arr= array();
	$ct=0;
	while($line = mysqli_fetch_array($result))
	{
		$arr[] = $line;
		$country[$ct]=$line['country'];
		$num[$ct]=$line['num'];
		$ct++;
	}

    //center latitude and longitude
	$sum1 = 0;
	for($i=0; $i<$row; $i++){
		$sum1=$sum1+$arr[$i]['latitude'];
	}
	$latavg = $sum1/$row;

	$sum2 = 0;
	for($i=0; $i<$row; $i++){
		$sum2 = $sum2+$arr[$i]['longitude'];
	}
	$logavg = $sum2/$row;

	?>


 <div id="map" style="height: 400px; width: 720px; align: center;"></div>
<script >
    //google MAP chart function
	function initMap(){
		var mapOption = {
			zoom: 2,
			center : new google.maps.LatLng(<?php echo $latavg.",".$logavg; ?> ),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map"),mapOption);
		var infowindow = new google.maps.InfoWindow();
		var markerIcon = {
			scaledSize: new google.maps.Size(80,80),
			origin: new google.maps.Point(0, 0),
		  	anchor: new google.maps.Point(32,65),
		  	labelOrigin: new google.maps.Point(40,33)
			};

		var location;
		var mySymbol;
		var marker, m; 
        //Marker locations will encode in json
		var MarkerLocations = <?php echo json_encode($arr,JSON_UNESCAPED_UNICODE); ?>;

		for (m = 0; m < MarkerLocations.length; m++) {

        location = new google.maps.LatLng(MarkerLocations[m][2], MarkerLocations[m][3]),
        marker = new google.maps.Marker({ 
		    map: map, 
		    position: location, 
		    icon: markerIcon,	
		    label: {
			color: "black",
	    	fontSize: "16px",
	    	fontWeight: "bold"
	    }
	});
       google.maps.event.addListener(marker, 'click', (function(marker, m) {
        return function() {
          infowindow.setContent(MarkerLocations[m][0] + ".," + MarkerLocations[m][1]);
          infowindow.open(map, marker);
        }
      })(marker, m));
 }


	}
	google.maps.event.addDomListener(window, 'load', initMap);;
	
</script>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR-API-KEY&callback=initMap"></script>

</div>
<?php
//display in html chart
    echo "<br><TABLE border=1>\n";
    echo "<TR><TH>Country<TH>Count\n";
    for ($i=0;$i < count($country); $i++) {
              echo "<TR><TD>" . $country[$i] . "<TD>" . $num[$i] . "\n";
    }
    echo "</TABLE>\n";
?>

</body>
</html>
