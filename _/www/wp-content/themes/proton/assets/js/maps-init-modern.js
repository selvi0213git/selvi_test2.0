function initialize(){var a={zoom:17,scrollwheel:!1,center:new google.maps.LatLng(map_data.map_latitude,map_data.map_longtitude)};new google.maps.Map(document.getElementById("map"),a),new google.maps.LatLng(map_data.map_latitude,map_data.map_longtitude)}google.maps.event.addDomListener(window,"load",initialize);