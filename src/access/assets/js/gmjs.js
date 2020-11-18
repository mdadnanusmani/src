

      var map;
      var markers = [];

      function initMap() {
        var haightAshbury = {lat: 18.2161394, lng: 42.50649};
        map = new google.maps.Map(document.getElementById("map"), {
          zoom: 12,
          center: haightAshbury,
        });

        // This event listener will call addMarker() when the map is clicked.
        map.addListener("click", function(evt) {
          deleteMarkers();
          addMarker(evt.latLng);
          bind_location( evt.latLng.lat(),evt.latLng.lng(), map.getZoom());
        });

        /*map.addListener("zoom_changed", function(e) {
         console.log("Zoom: " + map.getZoom());
        });*/

        // Adds a marker at the center of the map.
        addMarker(haightAshbury);
      }

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
         document.getElementById("latitude").value=lat;
         document.getElementById("longitude").value=lon;
         document.getElementById("zoom").value=zoom;
         document.getElementById("coordinate").value="123";
      }
