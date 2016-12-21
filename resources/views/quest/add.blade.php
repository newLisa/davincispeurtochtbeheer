@extends('layouts.app')

@section('content')
<style>
       #map {
        height: 800px;
       }
       #map-canvas {display: block; height: 300px; width: 600px;}
    </style>
<div id="markerFormBlock" hidden="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#replaceThis" aria-expanded="true" aria-controls="replaceThis">
              Marker Name
            </a>
          </h4>
        </div>
        <div id="replaceThis" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
                {{ Form::open(array('url' => 'quests/post')) }}
                    <div class="form-group">
                        {!! Form::label('Marker Name') !!}
                        {!! Form::number('Lat', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Marker Name')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Latitude') !!}
                        {!! Form::number('lat', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Latitude')) !!}

                        {!! Form::label('Longitude') !!}
                        {!! Form::number('lng', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Longitude')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Location Information') !!}
                        {!! Form::textarea('info', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Location Information')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Remove Marker', 
                          array('class'=>'btn btn-danger')) !!}
                    </div>
                {{ Form::close() }}
          </div>
        </div>
    </div>
</div>
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
                              array('class'=>'btn btn-success')) !!}
                        </div>
                    {{ Form::close() }}
                    
                    <div class="col-md-8" id="map">
                    </div>
                    <div class="col-md-4">

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                          
                        </div>
                        <a class="btn btn-primary" onclick="clearMarkers()">Clear Map</a> 
                        <a class="btn btn-primary" id="drawPoly" onclick="drawPoly()">Draw Polygon</a>
                        
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
    var drawPolyButton = document.getElementById('drawPoly');
    function initMap() 
    {
        var leerpark = {lat: 51.7986, lng: 4.68061};
        var map = new google.maps.Map(document.getElementById('map'), 
        {
            zoom: 16,
            center: leerpark,
            mapTypeId: 'terrain',
            disableDoubleClickZoom: true
        });

        google.maps.event.addListener(map, "click", function(event) 
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
            updateMarkerList();
        });

        //draws the polygon between the markers in array
        google.maps.event.addDomListener(drawPolyButton, "click", function() 
        {
            markerLocations.push(markerLocations[0]);
            console.log(markerLocations);


            var polygon = new google.maps.Polygon
            ({
              paths: markerLocations,
              strokeColor: '#FF0000',
              strokeOpacity: 1,
              strokeWeight: 2,
              fillColor: '#FF0000',
              fillOpacity: 0.35
            });
            
            //console.log(polygon);
            polygon.setMap(map);
            
        });   


    }
    function replaceAll(str, find, replace) 
    {
        return str.replace(new RegExp(find, 'g'), replace);
    }

    function hasClass(element, cls) {
        return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
    }

    function updateMarkerList() {
        var divList;
        
        for (i = 0; i < markerLocations.length; i++)
        {
            if ((i + 1) == markerLocations.length)
            {
                document.getElementById('replaceThis').className += " in";
            }
            else if (hasClass(document.getElementById('replaceThis'), "in"))
            {
                console.log("Hij komt er");
                $("#replaceThis").removeClass("in");
            }
            var original = document.getElementById('markerFormBlock');
            var newDiv = original.cloneNode(true);
            console.log(i);
            console.log(markerLocations.length);
            newDiv.id = "formCopy" + i;
            var newDivInner = replaceAll(newDiv.innerHTML, "replaceThis", "markerCollapse" + i);
            divList += newDivInner;
        }

        document.getElementById("accordion").innerHTML = divList;
    }

    // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() 
      {
        setMapOnAll(null);
        polygon = null;

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
