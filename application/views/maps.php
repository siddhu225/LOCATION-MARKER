
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdQzk7wfrmLQVnH2D9NtUVxZXue1t09nU"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



</head>
<body>

  <a  href="<?php echo base_url('user/user_logout');?>" >  <button type="button" class="b1" style="top:10px;right:10px;" >Logout</button></a>

 <div id="Map" style="width: 1350px; height: 600px">



 </div>


</div>



</body>
</html>

<script type="text/javascript">
var latitude;
var longitude;

window.onload = function () {
    var mapOptions = {
        center: new google.maps.LatLng(21.0000, 78.0000),
        zoom: 5,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("Map"), mapOptions);

    var map_element= <?php echo json_encode($coords); ?>;

    var x;
    for(x=0;x<map_element.length;x++){
      console.log(map_element[x]);


      var marker=new google.maps.Marker({
        position: new google.maps.LatLng({lat:parseFloat(map_element[x].lat),lng:parseFloat(map_element[x].lng)}),
        map: map

      });



    }


      google.maps.event.addListener(map, 'click', function (e) {

        var location = e.latLng;

        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
          getCoords({"lat":location.lat(),"lng":location.lng()});

        google.maps.event.addListener(marker, "click", function (e) {
            var infoWindow = new google.maps.InfoWindow({
                content: 'Latitude: ' + location.lat() + '<br />Longitude: ' + location.lng()
            });
            infoWindow.open(map, marker);

        });


    });

};




function getCoords(data) {
      //  alert(data.latStart); //the alert show the values is hasnt have problem

        $.ajax({
                url: 'http://localhost/codeigniter/user/maps_user',
                type: 'POST',
                data: {"lat":data["lat"],"lng":data["lng"]} ,
                cache: false,
                success: function(rsp){
                    alert("Location Saved!"); //show an empty alert
                },
                error: function (jqXHR, exception) {
                       var msg = '';
                       if (jqXHR.status === 0) {
                           msg = 'Not connect.\n Verify Network.';
                       } else if (jqXHR.status == 404) {
                           msg = 'Requested page not found. [404]';
                       } else if (jqXHR.status == 500) {
                           msg = 'Internal Server Error [500].';
                       } else if (exception === 'parsererror') {
                           msg = 'Requested JSON parse failed.';
                       } else if (exception === 'timeout') {
                           msg = 'Time out error.';
                       } else if (exception === 'abort') {
                           msg = 'Ajax request aborted.';
                       } else {
                           msg = 'Uncaught Error.\n' + jqXHR.responseText;
                       }
                  console.log(msg);
               }
        });

}

</script>
