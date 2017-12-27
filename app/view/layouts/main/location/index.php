<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-map-marker" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase"> <?=$lang['callforhelp']?></span>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <a onclick="sos()" class="btn btn-danger btn-lg btn-block"><?=$lang['callforhelp']?></a>
      </div>
      <input type="hidden" name="id" id="id" value="<?=$_SESSION['social_id']?>">
    </div>
  </div>
</div>

<div class="portlet margin-bottom-30">
  <div class="portlet-title">
    <div class="caption caption-green">
      <i class="fa fa-map-marker" aria-hidden="true"></i>
      <span class="caption-subject text-uppercase">
        <?php
          if(sizeof($variables) >= 3){
            echo $lang['yourrelativewashere'];
          }else{
            echo $lang['yourlocation'];
          }
        ?>
      </span>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12" style="width:100%; height:50vh; display: block;">
        <div id="maps"></div>
      </div>
    </div>
  </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDInDR0AWu8J4I18qQWRPFt1kCxJ8ZVTqI&callback=initMap" async defer></script>

<script type="text/javascript">
  function initMap(){
    <?php if(sizeof($variables) >= 3){ ?>
    var userpage = <?=$variables[2]?>;
    drawUserMap(userpage);
    <?php }else{ ?>
    if (navigator.geolocation) {
        var position = navigator.geolocation.getCurrentPosition(drawMap, showError);
    } else {
        map.html("Geolocation is not supported by this browser.");
    }
    <?php } ?>
  }

  function drawUserMap(id){
    $.ajax({
      url: "/utilities/getLocation",
      type: "POST",
      dataType: "json",
      data: {id: id},
      success: function(result){
        var latlng = new google.maps.LatLng(result.lat, result.lng);
        var map = new google.maps.Map(document.getElementById('maps'), {
          zoom: 15,
          center: latlng
        });
        var marker = new google.maps.Marker({
          position: latlng,
          map: map,
          title: "<?=$lang['yourrelativewashere']?>"
        });
      }
    });
  }

  function drawMap(position){
    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    var map = new google.maps.Map(document.getElementById('maps'), {
      zoom: 15,
      center: latlng
    });
    var marker = new google.maps.Marker({
      position: latlng,
      map: map,
      title: "<?=$lang['yourehere']?>"
    });
  }

  function sos(){
    if (navigator.geolocation) {
        var position = navigator.geolocation.getCurrentPosition(helpLocation, showError);
    } else {
        map.html("Geolocation is not supported by this browser.");
    }
  }

  function helpLocation(position){
    var id = $("input#id").val();
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;

    $.ajax({
      url: "/utilities/saveLocation/true",
      type: "POST",
      data: {id: id, lat: lat, lng: lng},
      success: function(result){
        if(result == "Success"){
          alert("Success");
        }
      }
    });
  }

  function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
  }
</script>
