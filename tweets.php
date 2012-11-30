<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Twitter Results</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet/less" type="text/css" href="style.css" />
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUzyEaszncy5tactSdYzJDkcd-fYJSris&sensor=false">
    </script>
  </head>
  <body>
    <script>
      var locations = new Array();
    </script>
    <div id="tweets">
      <?php
        require('twitter.class.php');
        $twitter = new twitter_class();
        $searchType= $_GET['searchType'];
        if ($searchType == 'geo') {
          $lat= $_GET['lat'];
          $long= $_GET['long'];
          $radius= $_GET['radius'];
          $searchTerm= $lat . ',' . $long . ',' . $radius . 'mi';
        } else {
          $searchTerm = $_GET['search'];
        }
        echo $twitter->getTweets($searchType, $searchTerm, 10);
      ?>
    </div>

    <div id="map_canvas" style="height: 500px; width: 60%;">
    </div>

    <footer>
      <script>

        // create markers from locations
        var markers = new Array();
        for ( var i = 0; i < locations.length; i++ ) {
          markers[i] = [ i + "",
                        locations[i].substring(0, locations[i].indexOf(' ') ),
                        locations[i].substring(locations[i].indexOf(' ')+1, locations[i].length)];
        }

        // get avg lat and long
        var latsum  = 0;
        var longsum = 0;
        var numMarkers = 0;
        for ( var i = 0; i < markers.length; i++ ) {
          if ( markers[i][1] && markers[i][2] ) {
          latsum += parseFloat( markers[i][1] );
          longsum += parseFloat( markers[i][2] );
          numMarkers++;
          }
        }
        var latavg = latsum / numMarkers;
        var longavg = longsum / numMarkers;

        function initializeMaps() {
          var latlng = new google.maps.LatLng(latavg, longavg);
          var myOptions = {
              zoom: 15,
              center: latlng,
              mapTypeId: google.maps.MapTypeId.ROADMAP,
              mapTypeControl: false
          };
          var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
          var infowindow = new google.maps.InfoWindow(), marker, i;
          for (i = 0; i < markers.length; i++) {  
              marker = new google.maps.Marker({
                  position: new google.maps.LatLng(markers[i][1], markers[i][2]),
                  map: map
              });
              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                  return function() {
                      infowindow.setContent(markers[i][0]);
                      infowindow.open(map, marker);
                  }
              })(marker, i));
          }
        }
        window.onload = initializeMaps();
      </script>
    </footer>
  </body>
</html>