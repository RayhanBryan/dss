        <?php
        function get_crips_option($kriteria, $selected = 0){
            global $db;
            $rows = $db->get_results("SELECT kode_crips, nilai, keterangan FROM tb_crips 
            WHERE kode_kriteria='$kriteria' ORDER BY kode_crips");
            foreach($rows as $row){
                if($row->kode_crips==$selected)
                    $a.="<option value='$row->kode_crips' selected>$row->keterangan</option>";
                else
                    $a.="<option value='$row->kode_crips'>$row->keterangan</option>";
            }
            return $a;
        }
        $row = $db->get_row("SELECT * FROM tb_alternatif WHERE kode_alternatif='$_GET[ID]'"); 
        ?>
        <div class="page-header">
            <h1>Ubah nilai bobot &raquo; <small><?=$row->nama_alternatif?></small></h1>
        </div>
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="aksi.php?act=rel_alternatif_ubah&ID=<?=$row->kode_alternatif?>">
                    <?php
                    $rows = $db->get_results("SELECT ra.ID, k.kode_kriteria, k.nama_kriteria, ra.kode_crips,k.maps,at.lat,at.lng FROM tb_rel_alternatif ra INNER JOIN tb_kriteria k ON k.kode_kriteria=ra.kode_kriteria INNER JOIN tb_alternatif at ON at.kode_alternatif = ra.kode_alternatif WHERE at.kode_alternatif='$_GET[ID]' ORDER BY kode_kriteria");
                    foreach($rows as $row):
                        if($row->maps=='jarak'):?>
                            <div class="form-group">
                                <label><?=$row->nama_kriteria?></label>
                                <h6>Dalam kilometer</h6>    
                                <input type="hidden" name="lat" id="lat" value="<?=$row->lat?>"/>
                                <input type="hidden" name="lng" id="lng" value="<?=$row->lng?>"/>
                                <input type="hidden" name="latend" id="latend" value="<?=$row->lat?>"/>
                                <input type="hidden" name="lngend" id="lngend" value="<?=$row->lng?>"/>
                            </div>
                            <div class="panel-body">           
                                <div id="map" style="height: 300px;"></div>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="ID-<?=$row->ID?>" id="total_jarak" readonly="" value=""/>
                            </div>
                            <?php elseif($row->maps=='jumlah'):?>
                               <div class="form-group">
                                <label><?=$row->nama_kriteria?></label>   
                                <div class="form-group">
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="pac-jarak" placeholder="Masukan Nama Tempat" />
                                    </div>
                                </div>
                                <div class="panel-body">           
                                    <div id="mapjarak" style="height: 300px;"></div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="ID-<?=$row->ID?>" id="total_jumlah" readonly="" value=""/>
                                </div>
                            </div>
                            <?php else:?>
                                <div class="form-group">
                                    <label><?=$row->nama_kriteria?></label>    
                                    <select class="form-control" name="ID-<?=$row->ID?>"><?=get_crips_option($row->kode_kriteria, $row->kode_crips)?></select>
                                </div>
                                <?php
                            endif;
                        endforeach?>
                        <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                        <a class="btn btn-danger" href="?m=rel_alternatif"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                    </form>
                </div>
            </div>


            <script>

                function initMap() {
                    var directionsService = new google.maps.DirectionsService;
                    var directionsDisplay = new google.maps.DirectionsRenderer;
                    var map = new google.maps.Map(document.getElementById('map'), {
                      zoom: 7,
                      center: {
                        lat : parseFloat($('#lat').val()), 
                        lng : parseFloat($('#lng').val())
                    }
                });
                    directionsDisplay.setMap(map);

                  // document.getElementById('start').addEventListener('change', onChangeHandler);
                  // document.getElementById('end').addEventListener('change', onChangeHandler);

                  var marker = new google.maps.Marker({
                    position:  {
                        lat : parseFloat($('#lat').val()), 
                        lng : parseFloat($('#lng').val())
                    },
                    map: map,
                    title: 'Click to zoom',
                    draggable:true
                });

                  var input = document.getElementById('pac-input');
                  var autocomplete = new google.maps.places.Autocomplete(input);
                  autocomplete.bindTo('bounds', map);

                  marker.addListener('drag', handleEvent);
                  marker.addListener('dragend', handleEvent);

                  var infowindow = new google.maps.InfoWindow({
                    content: '<h4>Drag untuk pindah lokasi</h4>'
                });

                  infowindow.open(map, marker);
                  var infowindowContent = document.getElementById('infowindow-content');

                  autocomplete.addListener('place_changed', function() {
                      infowindow.close();
                      marker.setVisible(false);
                      var place = autocomplete.getPlace();
                      if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

              // If the place has a geometry, then present it on a map.
              if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);


            document.getElementById('latend').value = place.geometry.location.lat();
            document.getElementById('lngend').value = place.geometry.location.lng();

            var address = '';
            if (place.address_components) {
                address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindow.setContent(place.name + '');
            infowindow.open(map, marker);

            calculateAndDisplayRoute(directionsService, directionsDisplay);
        });
              }

              function calculateAndDisplayRoute(directionsService, directionsDisplay) {
                console.log($('#lat').val());
                directionsService.route({
                  origin: {
                    lat : parseFloat($('#lat').val()), 
                    lng : parseFloat($('#lng').val()), 
                },
                destination: {
                    lat : parseFloat($('#latend').val()), 
                    lng : parseFloat($('#lngend').val()), 
                },
                travelMode: 'DRIVING'
            }, function(response, status) {
              if (status === 'OK') {
                $('#total_jarak').val(response.routes[0].legs[0].distance.value / 1000);
                directionsDisplay.setDirections(response);
            } else {      
                window.alert('Directions request failed due to ' + satus);
            }
        });
            }
            function handleEvent(event) {
                document.getElementById('latend').value = event.latLng.lat();
                document.getElementById('lngend').value = event.latLng.lng();
            }

            function initMapjarak(jarakinput) {

                var map, places, tmpLatLng, markers = [];
                var pos = new google.maps.LatLng( parseFloat($('#lat').val()), parseFloat($('#lng').val()));
                var mapOptions = {
                    zoom: 17,
                    center: new google.maps.LatLng( parseFloat($('#lat').val()), parseFloat($('#lng').val()))
                };
                map = new google.maps.Map(document.getElementById('mapjarak'),
                  mapOptions);
        // create the map and reference the div#mapjarak container
        var markerBounds = new google.maps.LatLngBounds();
        var service = new google.maps.places.PlacesService(map);


              // fetch the existing places (ajax) 
              // and put them on the map

              console.log(jarakinput);
              var request = {
                  location: pos,
                  radius: 200, 
                  name: jarakinput
              };


              function callback(results, status) {
                  if (status == google.maps.places.PlacesServiceStatus.OK) {
                    for (var i = 0; i < results.length; i++) {
                      createMarker(results[i]);
                  }
                  $('#mapjarak').attr("data-markers",results.length);
                  $('#total_jumlah').val(markers.length);                  
              } else {
                console.log("Places request failed: "+status);
            }
                } // end callback

                function createMarker(place) {
                  var prequest = {
                    reference: place.reference
                };
                var tmpLatLng = place.geometry.location;
                var marker = new google.maps.Marker({
                    map: map,
                    position: place.geometry.location
                });
                markers.push(marker);
                markerBounds.extend( tmpLatLng );
                } // end createMarker
                service.nearbySearch(request, callback);

            }

            $(function(){
                initMap();
                $("#pac-jarak").keyup(function() {
                    initMapjarak($('#pac-jarak').val());
                });
                map = new google.maps.Map(document.getElementById("map"), {
                  zoom: 17,
                  center: {
                    lat : parseFloat($('#lat').val()), 
                    lng : parseFloat($('#lng').val())
                }
            });
                google.maps.event.addListener(map, 'click', function(event) {
                   document.getElementById('latend').value = event.latLng.lat();
                   document.getElementById('lngend').value = event.latLng.lng();
                   var directionsService = new google.maps.DirectionsService;
                   var directionsDisplay = new google.maps.DirectionsRenderer;
                   calculateAndDisplayRoute(directionsService, directionsDisplay);
                   directionsDisplay.setMap(map);
               });


            })




        </script>