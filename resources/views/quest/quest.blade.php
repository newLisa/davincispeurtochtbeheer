@extends('layouts.app')

@section('content')
<style>
       #map {
        height: 800px;
       }
    </style>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
    @if(isset($quest))
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Quest</div>
                <div class="panel-body">
                    <h2>Edit {{ $quest->naam }}</h2>
                    {{ Form::open(array('url' => 'quest/put/' . $quest->id)) }}
                        <div class="form-group">
                        {!! Form::label('Quest Name') !!}
                        {!! Form::text('name', $quest->naam, 
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
                            {!! Form::textarea('info', $quest->informatie, 
                                array('required', 
                                      'class'=>'form-control', 
                                      'placeholder'=>'Quest Information')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Edit Quest', 
                              array('class'=>'btn btn-primary')) !!}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Place Polygon</div>
                <div class="panel-body">
                <a onclick="clearMarkers()">clear</a>











                    <h3>My Google Maps Demo</h3>
                    <div class="col-md-8" id="map"></div>
                    <script>
                        var map;
                        var markers = [];
                        function initMap() {
                            var uluru = {lat: 50.363, lng: 131.044};
                            var leerpark = {lat: 51.7986, lng: 4.68061};
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 16,
                                center: leerpark
                            });
                            var marker = new google.maps.Marker({
                                position: leerpark,
                                map: map
                            });
                            google.maps.event.addListener(map, "rightclick", function(event) {
                                var lat = event.latLng.lat();
                                var lng = event.latLng.lng();
                                var newMarker = {lat: lat, lng: lng};
                                // populate yor box/field with lat, lng
                                var marker = new google.maps.Marker({
                                    position: newMarker,
                                    map: map
                                });
                                markers.push(marker);
                            });
                        }


                        // Removes the markers from the map, but keeps them in the array.
                          function clearMarkers() {
                            setMapOnAll(null);
                          }

                        // Sets the map on all markers in the array.
                          function setMapOnAll(map) {
                            for (var i = 0; i < markers.length; i++) {
                              markers[i].setMap(map);
                            }
                          }

                    </script>
                    

                    <script type="text/javascript">
                        

                    </script>
                    <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD80w686NAZVpXDIDK7sbUbe7R6zYUU-OI&callback=initMap">
                    </script>












                </div>
            </div>
        </div>
    @else
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Quest</div>
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
                </div>
            </div>
        </div>
    @endif

                
            
    </div>
</div>
@endsection
