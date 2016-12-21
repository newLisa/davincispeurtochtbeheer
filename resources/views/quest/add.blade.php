@extends('layouts.app')

@section('content')
<style>
       #map {
        height: 800px;
       }
       #map-canvas {display: block; height: 300px; width: 600px;}
    </style>
<div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Quest
                </div>
                <div class="panel-body">
                    <h2>Add Quest</h2>

                    {{ Form::open(array('url' => 'quests/post')) }}
                        <div class="form-group">
                            {!! Form::label('Quest Name') !!}
                            {!! Form::text('name', null, 
                                            array('required', 
                                            'class'=>'form-control', 
                                            'placeholder'=>'Quest name')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('Quest Course') !!}
                            <br>
                            {!! Form::select('course', array('Ict' => 'Ict', 'Kapper' => 'Kapper'), array('class'=>'form-control')); !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('Quest Information') !!}
                            {!! Form::textarea('info', null, 
                                array('required', 
                                      'class'=>'form-control', 
                                      'placeholder'=>'Quest Information')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Create Quest', 
                              array('class'=>'btn btn-primary')) !!}
                        </div>
                    {{ Form::close() }}
                    <a onclick="clearMarkers()">Clear Map</a>
                    <a onclick="drawPoly()">Draw Polygon</a>
                    <div class="col-md-8" id="map">
                    </div>
                </div>
            </div>
        </div>                        
    </div>
</div>


                    <script>
                        var map;
                        var markerLocations = [];
                        var markers = [];
                        function initMap() 
                        {
                            var leerpark = {lat: 51.7986, lng: 4.68061};
                            var map = new google.maps.Map(document.getElementById('map'), 
                            {
                                zoom: 16,
                                center: leerpark,
                                mapTypeId: 'terrain'
                            });
                            var marker = new google.maps.Marker
                            ({
                                position: leerpark,
                                map: 
                                map
                            });
                            markerLocations.push(leerpark);
                            markers.push(marker);

                            google.maps.event.addListener(map, "rightclick", function(event) 
                            {
                                var lat = event.latLng.lat();
                                var lng = event.latLng.lng();
                                var newLocation = {lat: lat, lng: lng};
                                // populate yor box/field with lat, lng
                                var newMarker = new google.maps.Marker
                                ({
                                    position: newLocation,
                                    map: map
                                });
                                markerLocations.push(newLocation);

                                markers.push(newMarker);
                            });
                        }


                        // Removes the markers from the map, but keeps them in the array.
                          function clearMarkers() 
                          {
                            setMapOnAll(null);
                          }

                            //draws the polygon between the markers in array
                            function drawPoly() 
                            {

                                var polygon = new google.maps.Polygon
                                ({
                                  paths: markerLocations,
                                  strokeColor: '#FF0000',
                                  strokeOpacity: 1,
                                  strokeWeight: 20,
                                  fillColor: '#FF0000',
                                  fillOpacity: 0.35
                                });
                                
                                console.log(polygon);
                                polygon.setMap(map);
                            }   

                        // Sets the map on all markers in the array.
                          function setMapOnAll(map) {
                            for (var i = 0; i < markers.length; i++) 
                            {
                              markers[i].setMap(map);
                            }
                          }
                    </script>
                    <script async defer
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD80w686NAZVpXDIDK7sbUbe7R6zYUU-OI&callback=initMap">
                     </script>
@endsection
