<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Twitter Search</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css" />
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUzyEaszncy5tactSdYzJDkcd-fYJSris&sensor=false">
    </script>
    <script>
      $.ajaxSetup ({ cache:false });
      $(document).ready(function() {
        $("#keyword_submit").click(function() {
          setInterval(function() {
            var search = document.getElementById("keyword").value;
            $("#results").load("tweets.php", "search=" + search + "&searchType=key");
          }, 20000);
        });
        $("#location_submit").click(function() {
          setInterval(function() {
            var latitude  = document.getElementById("lat").value;
            var longitude = document.getElementById("long").value;
            var radius    = document.getElementById("radius").value;
            $("#results").load("tweets.php", "lat=" + latitude + 
              "&long=" + longitude + "&radius=" + radius + "&searchType=geo");
          }, 20000);
        });
      });
    </script>
  </head>
  <body>
  <div id="page">
    <header>
      <h1>Twitter Maps</h1>
    </header>

    <nav>
    </nav>

    <section id="search_keyword">
      <p>Hi there, this is a simple Twitter search. Please enter
      what you would like to search twitter for. How about kitties?</p>
      <form method='get' action>
        Search: <input type='text' id='keyword' name='search' placeholder='kitties or from:LAtimes' />
        <input type='hidden' name='searchType' value='key'>
        <input id="keyword_submit" class="btn btn-info" type="button" value="keyword search">
      </form>
    </section>

    <section id="search_geolocation">
      <p>You can also define a search by location</p>
      <form method='get' action>
        Latitude: <input type='text' id='lat' name='lat' value='34.01055' /><br>
        Longitude: <input type='text' id='long' name='long' value='-118.491068' /><br>
        Radius (miles): <input type='text' id='radius' name='radius' value='1' /><br>
        <input type='hidden' name='searchType' value='geo'>
        <input id="location_submit" class="btn btn-info" type="button" value="location search">
      </form>
    </section>

    <div id="results">
    </div>

    <footer>
      <script>
      </script>
    </footer>
  </div>
  </body>
</html>
