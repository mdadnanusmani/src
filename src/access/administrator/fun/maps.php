<div style="display: none"></div>
<?php
function bind_modeel($name,$lable,$array=''){
    echo '<div id="'.$name.'" style="display: none"> ';


    if($array!='')
    {
        $array=explode(",",$array);

    }else
    {
       $array[0]='18.2161394';
       $array[1]='42.50649';
       $array[2]='12';
    }
    ?>
<style>
  #map {
        height: 100%;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: "Roboto","sans-serif";
        line-height: 30px;
        padding-left: 10px;
      }
#description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
        </style>

      <script>
      var map;
      var markers = [];

      function initMap() {
        var haightAshbury = {lat:18.2161394, lng:42.50649};
        map = new google.maps.Map(document.getElementById("map"), {
          zoom: 12,
          center: haightAshbury,
        });

        var card = document.getElementById("pac-card");
        var input = document.getElementById("pac-input");

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo("bounds", map);
        autocomplete.addListener("place_changed", function() {

        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(16);  // Why 17? Because it looks good.
        }

        deleteMarkers();
        addMarker(place.geometry.location)

        });



        /////////////////////////
        map.addListener("click", function(evt) {
          deleteMarkers();
          addMarker(evt.latLng);
          bind_location( evt.latLng.lat(),evt.latLng.lng(), map.getZoom());
          //document.getElementById("coordinate").value="123";
        });


        addMarker(haightAshbury);
      }
      ///////////


      // Adds a marker to the map and push to the array.
      function addMarker(location) {

        var marker = new google.maps.Marker({
          draggable: true,
          position: location,
          map: map
        });

        marker.addListener("click", function(evt) {
          map.setZoom(16);
          map.setCenter(marker.getPosition());
        bind_location( evt.latLng.lat(),evt.latLng.lng(), map.getZoom());
        });

        google.maps.event.addListener(marker, "drag", function(e){
          map.setZoom(16);
          map.setCenter(marker.getPosition());
        });

        google.maps.event.addListener(marker, "dragend", function(evt){
        bind_location( evt.latLng.lat(),evt.latLng.lng(), map.getZoom());
           map.setCenter(marker.getPosition());
        });

        markers.push(marker);
        map.setZoom(16);
        map.setCenter(marker.getPosition());

      }

      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

     function bind_location(lat,lon,zoom)
      {
         /*document.getElementById("latitude").value=lat;
         document.getElementById("longitude").value=lon;
         document.getElementById("zoom").value=zoom;*/
         document.getElementById("qwe").value=lat+","+lon+","+zoom;
          document.getElementById("submitbtn").style.display = "block";
      }

    </script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAy3w5aPRK6YBwof7emcnSXFVlAYRSvbSs&language=ar&region=EG&libraries=places&callback=initMap" async defer></script>
    

        <div class="pac-card" id="pac-card">
            <div dir="rtl">
                <div id="title">
                البحث عن موقع
                </div>
                <div id="strict-bounds-selector" class="pac-controls">
                </div>
          </div>
          <div id="pac-container">
            <input id="pac-input" type="text" placeholder="">
          </div>
        </div>

        <div id="map" style="width: 100%; height: 500px"></div>

        <div id="infowindow-content">
          <img src="" width="16" height="16" id="place-icon">
          <span id="place-name"  class="title"></span><br>
          <span id="place-address"></span>
        </div>
         </div>

<?php }   ?>

