<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Twitter Search</title>
    <meta name="viewport" content="width=device-width" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="bootstrap-responsive.css">
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" type="image/png" href="favicon.png">
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUzyEaszncy5tactSdYzJDkcd-fYJSris&sensor=false">
    </script>
    <script type='text/javascript' src='jquery.locationpicker.js'></script>
    <script>
      var timer;
      $.ajaxSetup ({ cache:false });
      $(document).ready(function() {
        $("#submit_button").click(function Search() {
          var keyword   = document.getElementById("keyword").value;
          var latlng    = document.getElementById("latlng").value.split(",");
          var latitude  = latlng[0];
          var longitude = latlng[1];
          var radius    = document.getElementById("radius").value;
          $("#results").load("tweets.php", "keyword=" + keyword + "&lat=" + latitude +
            "&long=" + longitude + "&radius=" + radius + "&searchType=geo");
          timer = setTimeout(Search, 25000);
        });
      });
    </script>
    <script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('input#latlng').locationPicker();
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
      <div class="welcome-text span4 offset1">
        <p>
          See what's tweeting around you! Enter a keyword and location to see what
          what people are tweeting near by. The default searches for the keyword
          beach in the Santa Monica, Ca area.
        </p>
      </div>
      <div class="input-fields span4 offset2">
        <label>Keyword:</label>
        <input type='text' id='keyword' name='search' value='beach'
          onkeydown="if (event.keyCode == 13) document.getElementById('submit_button').click()"/><br>
        <label>Locaton (address or lat/long):</label>
        <input type='text' id='latlng' name='test' value='santa monica pier'
          onkeydown="if (event.keyCode == 13) document.getElementById('submit_button').click()"/><br>
        <label>Radius (miles):</label>
        <input type='text' id='radius' name='radius' value='1'
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
