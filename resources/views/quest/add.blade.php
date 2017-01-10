@extends('layouts.app')

@section('content')
<style>
    #map 
    {
        height: 700px;
    }
</style>

<div id="markerFormBlock" hidden="true">
    <div class="panel panel-default" id="markerListItem">
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
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'placeholder'=>'Marker Name',
                                        'onkeyup'=>'updateText(this)')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Latitude') !!}
                        {!! Form::number('lat', null, 
                                        array('required', 
                                        'class'=>'form-control LatitudeId', 
                                        'readonly' => 'true',
                                        'placeholder'=>'Latitude')) !!}

                        {!! Form::label('Longitude') !!}
                        {!! Form::number('lng', null, 
                                        array('required', 
                                        'class'=>'form-control LongitudeId',
                                        'readonly' => 'true',  
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
                        {!! Form::button('Remove Marker', 
                          array('class'=>'btn btn-danger',
                                'onclick'=>'removeMarker(this)')) !!}
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
                                      <br/><br/>
                    
                            <a class="btn btn-primary" onclick="clearMap()">Clear Map</a> 
                            <a class="btn btn-primary" id="PolyButton" onclick="">Draw Polygon</a>
                        </div>
                    

                    <div class="col-md-8" id="map">
                    </div>

                    <div class="col-md-4">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::submit('Create Quest', 
                      array('class'=>'btn btn-success')) !!}
                </div>
                {{ Form::close() }}
            </div>
        </div>                        
    </div>
</div>

<script>
    var markerId = 0;
    var polygon;
    var drawPolygon = true;
    var map;
    var markerLocations = [];
    var polyLocations = [];
    var markers = [];
    var polyMarkers = [];
    var drawPolyButton = document.getElementById('PolyButton');

    function initMap() 
    {
        //default location for the camera to zoom zo
        var leerpark = {lat: 51.7986, lng: 4.68061};
        var map = new google.maps.Map(document.getElementById('map'), 
        {
            zoom: 16,
            center: leerpark,
            mapTypeId: 'terrain',
            disableDoubleClickZoom: true
        });

        //add on-click listener to the map so we can place markers 
        google.maps.event.addListener(map, "click", function(event) 
        {
            //store the location the user has clicked
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            var newLocation = {lat: lat, lng: lng};
            
            //check of we are in polygon draw state or place markers state
            if (drawPolygon) 
            {
                 var newMarker = new google.maps.Marker
                ({
                    position: newLocation,
                    map: map,
                    icon: 'http://www.googlemapsmarkers.com/v1/p/0099FF/'
                });
                newMarker.metadata = {poly: true};
            }
            else
            {
                //create a new google marker with the location info we got
                var newMarker = new google.maps.Marker
                ({
                    position: newLocation,
                    map: map,
                    icon: 'http://www.googlemapsmarkers.com/v1/m/009900/'
                });
                //set poly to false to insicate that this is a polygon marker and give an id
                newMarker.metadata = {poly: false, id:markerId};
                markerId++;
            }

            ///add a on-click listener to the google marker we just created and zoom/pan to it 
                newMarker.addListener('click', function() {
                map.setZoom(17);
                map.setCenter(newMarker.getPosition());
                console.log(newMarker.metadata.id);
            });

            //check in what state we are and add the location to the appropiate array
            if (drawPolygon) 
            {
                polyLocations.push(newLocation);
                polyMarkers.push(newMarker);
            }
            else
            {
                markerLocations.push(newLocation);
                markers.push(newMarker);           
                updateMarkerList();
            }
        });

        //add a on-click listerer to the button that 
        //draws the polygon between the markers in the marker array
        google.maps.event.addDomListener(drawPolyButton, "click", function() 
        {
            if (drawPolygon) //draw the polygon if we are in draw polygon state
            {
                drawPolygon = false;

                //draw the polygon
                polygon = new google.maps.Polygon
                ({
                    paths: polyLocations,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.1,
                    clickable: false
                });
                
                polygon.setMap(map);
                //remove the polygon markers from the map
                clearPolyMarkers();
                //change the button text to remove
                document.getElementById("PolyButton").innerHTML = 'Remove Polygon';
            }
            else //if we are not in draw polygon state we remove the polygon
            {
                //remove the polygon from the map
                polygon.setMap(null);
                //go back into draw polygon state
                drawPolygon = true;
                //clear the array of poly locations
                polyLocations = [];
                //change text back to draw
                document.getElementById("PolyButton").innerHTML = 'Draw Polygon';
            }          
        });   
    }

    function replaceAll(str, find, replace) 
    {
        return str.replace(new RegExp(find, 'g'), replace);
    }

    //returns true when elemets has classname cls
    function hasClass(element, cls) 
    {
        return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
    }

    //updates the list of created markers on the right side of the screen
    function updateMarkerList() 
    {
        if (markerLocations.length > 0)
        {
            var divList;
            
            for (i = 0; i < markerLocations.length; i++)
            {
               
                if ((i + 1) == markerLocations.length)
                {
                    document.getElementById('replaceThis').className += " in";
                }
                else if (hasClass(document.getElementById('replaceThis'), "in"))
                {
                    $("#replaceThis").removeClass("in");
                }

                var original = document.getElementById('markerFormBlock');
                var newDiv = original.cloneNode(true);
                var newDivInner = replaceAll(newDiv.innerHTML, "replaceThis", "markerCollapse" + i);

                if (divList != null)
                {
                    divList += newDivInner;
                }
                else
                {
                    divList = newDivInner;
                }
            }
                document.getElementById("accordion").innerHTML = divList;
            

            //loop through the markerlocations to set the latitude and longtitude in the form
            for (i = 0; i < markerLocations.length; i++)
            {
                document.getElementById("markerCollapse" + i).getElementsByClassName("LatitudeId")[0].value = markerLocations[i].lat;
                document.getElementById("markerCollapse" + i).getElementsByClassName("LongitudeId")[0].value = markerLocations[i].lng;
            }
        }
    }

    //resets the whole map
    function clearMap() 
    {
        markerId = 0;
        drawPolygon = true;
        polygon.setMap(null);
        setMapOnAll(null);
        document.getElementById("PolyButton").innerHTML = 'Draw Polygon';
        clearMarkers();
        clearPolyMarkers();
       
       //remove the marker collapse forms
        var acc = document.getElementById("accordion");
        while (acc.firstChild) 
        {
            acc.removeChild(acc.firstChild);
        }
    }

    //clear all normal location markers from the map
    function clearMarkers()
    {
        markerLocations = [];
        for (var i = markers.length - 1; i >= 0; i--)
        {
            markers[i].setMap(null);
        }
        markers = [];
    }

     //clears all polygon markers from the map, but lets the polygon itself remain
     function clearPolyMarkers()
     {
        polyLocations = [];
        for (var i = polyMarkers.length - 1; i >= 0; i--)
        {
            polyMarkers[i].setMap(null);
        }
        polyMarkers = [];
    }

    // Sets the map on all markers in the array.
    function setMapOnAll(map) 
    {
        for (var i = 0; i < markers.length; i++) 
        {
          markers[i].setMap(map);
        }
    }

    function removeMarker(removebtn)
    {
        var selectedMarker;
        //find the entire marker panel
        selectedMarker = removebtn.parentElement.parentElement.parentElement.id;

         //if it is not the first one the order of elements is different, need 1 extra parent
        if (parseInt(selectedMarkerId) != 0)
        {
           selectedMarker = removebtn.parentElement.parentElement.parentElement.parentElement.id;
        }

        //get the id of the marker by removing "markerCollapse"
        var selectedMarkerId = selectedMarker.substring('markerCollapse'.length);
        
        //find the marker with the same id as the one of wich the remove button was clicked
        for (var i = 0 ; i < markers.length; i++) 
        {
            if (markers[i].metadata.id == selectedMarkerId) 
            {
                //remove marker from map and arrays
                markers[i].setMap(null);
                markers.splice(i, 1);
                markerLocations.splice(i, 1);
                //remove the marker collapse
                if (selectedMarkerId != 0)
                {
                    document.getElementById(selectedMarker).parentElement.remove();
                }
                //if it was the last marker we also need to remove the accordion
                else
                {
                    var lastparent = document.getElementById(selectedMarker).parentElement;
                    var acc = document.getElementById("accordion");
                    while (acc.firstChild) 
                    {
                        acc.removeChild(acc.firstChild);
                    }
                }
                    
                updateMarkerList();
                //decrement markerid so that the next marker added still has the right id
                markerId--; 
            }
        }

        //renew the id's on the markers
        for (var i = 0; i < markers.length; i++) 
        {
            markers[i].metadata.id = i;
        }
    }

    //updates the Marker Name text while you type
    function updateText(input)
    {
        //find the marker heading
        var markerName = input.parentElement.parentElement.parentElement.parentElement.parentElement.firstChild.nextSibling.firstChild.nextElementSibling;
        //set text to input value
        markerName.innerText = input.value;
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD80w686NAZVpXDIDK7sbUbe7R6zYUU-OI&callback=initMap"></script>
@endsection