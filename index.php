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
      var timer;
      $.ajaxSetup ({ cache:false });
      $(document).ready(function() {
        $("#submit_button").click(function Search() {
          var keyword   = document.getElementById("keyword").value;
          var latitude  = document.getElementById("lat").value;
          var longitude = document.getElementById("long").value;
          var radius    = document.getElementById("radius").value;
          $("#results").load("tweets.php", "keyword=" + keyword + "&lat=" + latitude +
            "&long=" + longitude + "&radius=" + radius + "&searchType=geo");
          timer = setTimeout(Search, 25000);
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

    <div class="search row-fluid">
      <div class="span6">
        <p>
          Hi there, this is a simple Twitter search. Please enter
          what you would like to search twitter for. The default searches for the keyword
          beach in the Santa Monica, Ca area.
        </p>
      </div>
      <div class="span6">
        Search: <input type='text' id='keyword' name='search' value='beach'
          onkeydown="if (event.keyCode == 13) document.getElementById('submit_button').click()"/><br>
        Latitude: <input type='text' id='lat' name='lat' value='34.01055'
          onkeydown="if (event.keyCode == 13) document.getElementById('submit_button').click()"/><br>
        Longitude: <input type='text' id='long' name='long' value='-118.491068'
          onkeydown="if (event.keyCode == 13) document.getElementById('submit_button').click()"/><br>
        Radius (miles): <input type='text' id='radius' name='radius' value='1'
          onkeydown="if (event.keyCode == 13) document.getElementById('submit_button').click()"/><br>
        <button id="submit_button" class="btn btn-info" type="button">search</button>
      </div>
    </div>
    <div id="results">
    </div>

    <footer>
      <script>
      </script>
    </footer>
  </div>
  </body>
</html>
