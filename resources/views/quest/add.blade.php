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
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#replaceThis" aria-expanded="true" aria-controls="replaceThis" id="markerHeader">
              Marker Name
            </a>
          </h4>
        </div>
        <div id="replaceThis" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
                {{ Form::open(array('url' => 'quests/post')) }}
                    <div class="form-group">
                        {!! Form::label('Locatie Naam') !!}
                        {!! Form::text('Name', null, 
                                        array('required', 
                                        'class'=>'form-control', 
                                        'id' => 'markerNameInput',
                                        'placeholder'=>'Locatie Naam',
                                        'onkeyup'=>'updateText(this)')) !!}
                    </div>


                    <div class="form-group">
                        {!! Form::label('Locatie Informatie') !!}
                        {!! Form::textarea('info', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Locatie Informatie',
                                  'id'=>'markerInfo')) !!}

                        
                    </div>
                    <div class="form-check">
                        {!! Form::checkbox('isQr', null, false,
                            array('class'=>'form-check-input', 'id'=>'qrCheck')) 
                        !!}
                        {!! Form::label('QR Marker') !!}
                    </div>
                    <div class="form-check">
                        {!! Form::checkbox('isVisible', null, false,
                            array('class'=>'form-check-input', 'id'=>'visibleCheck')) 
                        !!}
                        {!! Form::label('Altijd Zichtbaar') !!}
                        
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
                        {!! Form::button('Verwijder Locatie', 
                          array('class'=>'btn btn-danger',
                                'id' => 'removeMarkerButton',
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
                    Quest Toevoegen
                </div>
                <div class="panel-body">
                    <h2>Quest Toevoegen</h2>

                    {{ Form::open(array('url' => 'quests/post')) }}
                        <div class="form-group">
                            {!! Form::label('Quest Naam') !!}
                            {!! Form::text('name', null, 
                                            array('required', 
                                            'class'=>'form-control', 
                                            'id'=>'questName',
                                            'placeholder'=>'Quest Naam')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('Quest Opleiding') !!}
                            <br>
                            {!! Form::select('course', array('Ict' => 'Ict',
                                                             'Kapper' => 'Kapper'),
                                                              null,
                                                              array('class'=>'form-control', 
                                                              'id'=>'questCourse',
                                                              'style'=>'width:200px')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('Quest Informatie') !!}
                            {!! Form::textarea('info', null, 
                                array('required', 
                                      'class'=>'form-control', 
                                      'id'=>'questInfo',
                                      'placeholder'=>'Quest Informatie')) !!}
                          
                            <br/><br/>
                            <a class="btn btn-primary" onclick="clearMap()">Reset Map</a> 
                            <a class="btn btn-primary" id="PolyButton" onclick="">Teken Polygoon</a>
                        </div>
                    

                    <div class="col-md-8" id="map">
                    </div>

                    <div class="col-md-4">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::submit('Opslaan', 
                      array('class'=>'btn btn-success')) !!}
                </div>
                {{ Form::close() }}
            </div>
        </div>                        
    </div>
</div>

<script>
    var markerId = 1;
    var polyMarkerId = 1;
    var polygon;
    var drawPolygon = true;
    var map;
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
            updateFormValues();
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
                    icon: 'http://www.googlemapsmarkers.com/v1/p' + polyMarkerId + '/0099FF/'
                });
                polyMarkerId++;

                 polyLocations.push(newLocation);
                polyMarkers.push(newMarker);
            }
            else
            {
                //create a new google marker with the location info we got
                var newMarker = new google.maps.Marker
                ({
                    position: newLocation,
                    map: map,
                    icon: 'http://www.googlemapsmarkers.com/v1/' + markerId + '/009900/'
                });
                //set marker name and add marker metadata
                var markerName = "Marker " + markerId;
                newMarker.metadata = {id:markerId, name:markerName, markerInfo:"", location:newLocation, isQR:0, isVisible:0};

                markers.push(newMarker);           
                updateMarkerList();

               ///add a on-click listener to the google marker we just created 
                newMarker.addListener('click', function() 
                {
                    for (i = 0; i < markers.length; i++)
                    {
                        //open the right collapse 
                        if (markers[i].metadata.id == newMarker.metadata.id)
                        {
                            document.getElementById('markerCollapse'+newMarker.metadata.id).className += " in";
                        }
                        //close the other collapses
                        else if (hasClass(document.getElementById('markerCollapse'+markers[i].metadata.id), "in"))
                        {
                            $("#markerCollapse"+markers[i].metadata.id).removeClass("in");
                        }
                    }
                    //pan to the clicked marker
                    map.panTo(newMarker.getPosition());
                });
                
                markerId++;
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
                document.getElementById("PolyButton").innerHTML = 'Verwijder Polygoon';
            }
            else //if we are not in draw polygon state we remove the polygon
            {
                polyMarkerId = 1;
                //remove the polygon from the map
                polygon.setMap(null);
                //go back into draw polygon state
                drawPolygon = true;
                //clear the array of poly locations
                polyLocations = [];
                //change text back to draw
                document.getElementById("PolyButton").innerHTML = 'Teken Polygoon';
            }          
        });   
    }

    //updates the list of created markers on the right side of the screen
    function updateMarkerList() 
    {
        if (markers.length > 0)
        {
            var divList;
            
            for (i = 0; i < markers.length; i++)
            {
                //fold open last collapse
                if ((i + 1) == markers.length)
                {
                    document.getElementById('replaceThis').className += " in";
                }
                //close the other collapses
                else if (hasClass(document.getElementById('replaceThis'), "in"))
                {
                    $("#replaceThis").removeClass("in");
                }

                //clone the original form and give the right id's to the elements
                var original = document.getElementById('markerFormBlock');
                var newDiv = original.cloneNode(true);
                var newDivInner = replaceAll(newDiv.innerHTML, "replaceThis", "markerCollapse" + markers[i].metadata.id);
                var newDivInner = replaceAll(newDivInner, "markerHeader", "markerHeader" + markers[i].metadata.id);
                var newDivInner = replaceAll(newDivInner, "markerNameInput", "markerNameInput" + markers[i].metadata.id);
                var newDivInner = replaceAll(newDivInner, "removeMarkerButton", "removeMarkerButton" + markers[i].metadata.id);
                var newDivInner = replaceAll(newDivInner, "qrCheck", "qrCheck" + markers[i].metadata.id);
                var newDivInner = replaceAll(newDivInner, "visibleCheck", "visibleCheck" + markers[i].metadata.id);
                var newDivInner = replaceAll(newDivInner, "markerInfo", "markerInfo" + markers[i].metadata.id);

                //add the div to the list
                if (divList != null)
                {
                    divList += newDivInner;
                }
                else
                {
                    divList = newDivInner;
                }
            }
            
            //set the divlist in the accordion
            document.getElementById("accordion").innerHTML = divList;

            //loop through the markerlocations to set the values in the form
            for (i = 0; i < markers.length; i++)
            {
                document.getElementById("markerHeader" + markers[i].metadata.id).innerText = markers[i].metadata.name;
                if (markers[i].metadata.name != ("Marker " + markers[i].metadata.id)) 
                {
                    document.getElementById("markerNameInput" + markers[i].metadata.id).value = markers[i].metadata.name;
                }
                document.getElementById("markerInfo" + markers[i].metadata.id).value = markers[i].metadata.markerInfo;
                document.getElementById("qrCheck" + markers[i].metadata.id).checked = markers[i].metadata.isQR;
                document.getElementById("visibleCheck" + markers[i].metadata.id).checked = markers[i].metadata.isVisible;
                document.getElementById("markerCollapse" + markers[i].metadata.id).getElementsByClassName("LatitudeId")[0].value = markers[i].metadata.location.lat;
                document.getElementById("markerCollapse" + markers[i].metadata.id).getElementsByClassName("LongitudeId")[0].value = markers[i].metadata.location.lng;
                
                if (document.getElementById("markerNameInput" + markers[i].metadata.id).value != null) 
                {
                    if (document.getElementById("markerNameInput" + markers[i].metadata.id).value != "") 
                    {
                        markers[i].metadata.name = document.getElementById("markerNameInput" + markers[i].metadata.id).value;
                        
                    }
                }
            }
        }
    }

    function removeMarker(removebtn)
    {
        //get the id of the marker by removing "removeMarkerButton"
        var selectedMarkerId = removebtn.id.substring('removeMarkerButton'.length);;

        //find the marker with the same id as the one of wich the remove button was clicked
        for (var i = 0 ; i < markers.length; i++) 
        {
            if (markers[i].metadata.id == selectedMarkerId) 
            {
                //remove marker from map and array
                markers[i].setMap(null);
                markers.splice(i, 1);

                //remove the marker collapse
                document.getElementById('markerCollapse' + selectedMarkerId).parentElement.remove();

                i--;
            }

            //opens the last marker collapse after removal
            if ((i + 1) == markers.length)
            {
                var lastmarkerId = markers[i].metadata.id;
                document.getElementById('markerCollapse' + lastmarkerId).className += " in";
            }
        }
    }

    //updates the Marker Name text while you type
    function updateText(input)
    {
        //find the marker id
        var markerId = input.id.substring('markerNameInput'.length);
        //set text to input value
        document.getElementById("markerHeader" + markerId).innerText = input.value;
        if (input.value == "") 
        {
            document.getElementById("markerHeader" + markerId).innerText = "Marker " + markerId;
        }
    }

    //saves all the values in the form
    function updateFormValues()
    {
        for(var i = 0; i < markers.length; ++i)
        {
            if (document.getElementById("markerNameInput" + markers[i].metadata.id).value != "") 
            {
                markers[i].metadata.name = document.getElementById("markerNameInput" + markers[i].metadata.id).value;
            }

            markers[i].metadata.markerInfo = document.getElementById("markerInfo" + markers[i].metadata.id).value;
            markers[i].metadata.isQR = document.getElementById("qrCheck" + markers[i].metadata.id).checked;
            markers[i].metadata.isVisible = document.getElementById("visibleCheck" + markers[i].metadata.id).checked;
        }
    }

    //clear all normal location markers from the map
    function clearMarkers()
    {
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

    //resets the whole map
    function clearMap() 
    {
        markerId = 1;
        polyMarkerId = 1;
        drawPolygon = true;
        polygon.setMap(null);
        setMapOnAll(null);
        document.getElementById("PolyButton").innerHTML = 'Teken Polygoon';
        clearMarkers();
        clearPolyMarkers();
       
       //remove the marker collapse forms
        var acc = document.getElementById("accordion");
        while (acc.firstChild) 
        {
            acc.removeChild(acc.firstChild);
        }
    }

    //replaces all occurences of "find" in "str", and replaces with "replace"
    function replaceAll(str, find, replace) 
    {
        return str.replace(new RegExp(find, 'g'), replace);
    }

    //returns true when elemets has classname cls
    function hasClass(element, cls) 
    {
        return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
    }

</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD80w686NAZVpXDIDK7sbUbe7R6zYUU-OI&callback=initMap"></script>
@endsection