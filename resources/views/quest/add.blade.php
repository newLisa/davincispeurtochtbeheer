@extends('layouts.app')

<style>
    #map 
    {
        height: 700px;
    }
</style>

@section('content')
@include('includes.questionModel');
@include('includes.blankMarkerListItem');

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
                                                              'style'=>'width:200px; height:36px')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('Quest Informatie') !!}
                            {!! Form::textarea('info', null, 
                                array('required', 
                                      'class'=>'form-control', 
                                      'id'=>'questInfo',
                                      'placeholder'=>'Quest Informatie')) !!}
                          
                            <br/><br/>
                            <button type=button class="btn btn-primary" onclick="clearMap()">Reset Map</button> 
                            <button type=button class="btn btn-primary" id="PolyButton" onclick="">Teken Polygoon</button>
                        </div>

                    <div class="col-md-6" id="map">
                    </div>

                    <div class="col-md-6">
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
@endsection

@section('javascript')
<script>
    var modal = document.getElementById('questionModal');
    var modalContent = document.getElementById("modal-content");
    var close = document.getElementById("closeQuestionModel");
    var markerId = 1;
    var polyMarkerId = 1;
    var polygon;
    var drawPolygon = true;
    var map;
    var polyLocations = [];
    var markers = [];
    var polyMarkers = [];
    var drawPolyButton = document.getElementById('PolyButton');

    //question Model setup
    // When the user clicks on the button, open the modal
    function showQuestionModel(clickedMarkerId)
    {
        //show the modal
        $('#questionModal').modal('toggle');
        //set the markerId on the savebutton
        document.getElementsByName('saveButton')[0].id = "saveButton" + clickedMarkerId;

        //check to see if the question has been filled in
        for(i = 0; i < markers.length; i++)
        {
            if (markers[i].metadata.id == clickedMarkerId)
            {
                //if we have question metadata on the marker, we fill in the form
                if (markers[i].metadata.question != "")
                {
                    document.getElementsByName('question')[0].value = markers[i].metadata.questions.question;
                    document.getElementsByName('answer1')[0].value = markers[i].metadata.questions.answer1;
                    document.getElementsByName('answer2')[0].value = markers[i].metadata.questions.answer2;
                    document.getElementsByName('answer3')[0].value = markers[i].metadata.questions.answer3;
                    document.getElementsByName('answer4')[0].value = markers[i].metadata.questions.answer4;
                    document.getElementsByName('points')[0].value = markers[i].metadata.questions.points;
                }
                else //if we do not have data on the marker, show an empty form
                {
                    ocument.getElementsByName('question')[0].value = "";
                    document.getElementsByName('answer1')[0].value = "";
                    document.getElementsByName('answer2')[0].value = "";
                    document.getElementsByName('answer3')[0].value = "";
                    document.getElementsByName('answer4')[0].value = "";
                    document.getElementsByName('points')[0].value = 0;
                }
            }
        }
    }

    //closes the question modal
    function closeQuestionModel()
    {
        $('#questionModal').modal('toggle');
    }

    //saves all the values of the question-from to the marker metadata
    function saveQuestionForm(saveBtn)
    {
        var question = document.getElementsByName("question")[0].value; 
        var answer1 = document.getElementsByName("answer1")[0].value;
        var answer2 = document.getElementsByName("answer2")[0].value;
        var answer3 = document.getElementsByName("answer3")[0].value;
        var answer4 = document.getElementsByName("answer4")[0].value;
        var points = document.getElementsByName("points")[0].value;
      
        var id = saveBtn.id.substring('saveButton'.length);
        //find the marker associated with this form
        for(i = 0; i<markers.length; i++)
        {
            if (markers[i].metadata.id == id)
            {
                markers[i].metadata.questions.question = question;
                markers[i].metadata.questions.answer1 = answer1;
                markers[i].metadata.questions.answer2 = answer2;
                markers[i].metadata.questions.answer3 = answer3;
                markers[i].metadata.questions.answer4 = answer4;
                markers[i].metadata.questions.points = points;
            }
        }
        console.log(markers[0].metadata);
    }

    // When the user clicks on <span> (x), close the modal
    close.onclick = function() 
    {
        $('#questionModal').modal('toggle');
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) 
    {
        if (event.target == modalContent) 
        {
            $('#questionModal').modal('toggle');
        }
    }

    //Map setup
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
                    icon: '/images/greenmarker.png',
                    labelContent: "2"
                });
                //set marker name and add marker metadata
                var markerName = "Marker " + markerId;
                var questions = {question:"", answer1:"", answer2:"", answer3:"", answer4:"", correntAnswer:"", points:0};

                newMarker.metadata = {id:markerId, name:markerName, markerInfo:"", location:newLocation, isQR:0, isVisible:0, questions:questions};

                markers.push(newMarker);           
                updateMarkerList();
                document.getElementById("markerNameInput" + markerId).focus();

               ///add a on-click listener to the google marker we just created 
                newMarker.addListener('click', function() 
                {
                    openMarkerCollapse(newMarker.metadata.id);
                    document.getElementById("markerNameInput" + newMarker.metadata.id).focus();

                    //pan to the clicked marker
                    map.panTo(newMarker.getPosition());
                });

                makeQRCode(markerId);

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

    function makeQRCode (qrCodeText) 
    {        
        var qrcode;
        var qr = document.getElementById("qr-code"+ markerId);
        var options = 
        {
            width: 65,
            height: 65,
            colorDark : "#000000",
            colorLight : "#FFFFFF"
        };

        qrcode = new QRCode(qr, options);
        qrcode.makeCode(qrCodeText);
    }

    function openMarkerCollapse(markerId)
    {
        document.getElementById('markerCollapse' + markerId).className += " in";
        
        for (i = 0; i < markers.length; i++)
        {
            console.log(hasClass(document.getElementById('markerCollapse' + markers[i].metadata.id), " in"));
            //close the collapses
            if (markers[i].metadata.id != markerId)
            {
                console.log(markerId + " " + markers[i].metadata.id);

                $("#markerCollapse" + markers[i].metadata.id).removeClass("in");
            }
        }
    }

    //adds a new blank markerlist item to to list on the right side
    function updateMarkerList() 
    {
        if (markers.length > 0)
        {
            var divList;
            
            for (i = 0; i < markers.length; i++)
            {
                var markerId = markers[i].metadata.id;

                //clone the original form and give the right id's to the elements
                var original = document.getElementById('markerFormBlock');
                var newDiv = original.cloneNode(true);

                var newDivInner = replaceAll(newDiv.innerHTML, "MarkerId", markers[i].metadata.id);
                var newDivInner = replaceAll(newDivInner, "markerId", markers[i].metadata.id);

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

                if (i + 1 == markers.length) 
                {
                    openMarkerCollapse(markers[i].metadata.id);
                }
            }
        }
    }

    function removeMarker(removebtn)
    {
        //get the id of the marker by removing "removeMarkerButton"
        var selectedMarkerId = removebtn.id.substring('removeMarkerButton'.length);

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
        }
        updateMarkerList();
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

    //saves all the values in the form to the marker metadata
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

    //Check en update de marker image van een specifieke marker
    function updateMarkerImage($markerId)
    {
        for(var i = 0; i < markers.length; ++i)
        {
            if (markers[i].metadata.id == $markerId) 
            {
                if (document.getElementById("qrCheck" + markers[i].metadata.id).checked == true && document.getElementById("visibleCheck" + markers[i].metadata.id).checked == false)
                {
                    markers[i].setIcon('/images/greenqr.png');  
                }
                else if (document.getElementById("qrCheck" + markers[i].metadata.id).checked == false && document.getElementById("visibleCheck" + markers[i].metadata.id).checked == true)
                {
                    markers[i].setIcon('/images/orangemarker.png');  
                }
                else if (document.getElementById("qrCheck" + markers[i].metadata.id).checked == true && document.getElementById("visibleCheck" + markers[i].metadata.id).checked == true)
                {
                    markers[i].setIcon('/images/orangeqrmarker.png');  
                }
                else
                {
                    markers[i].setIcon('/images/greenmarker.png');  
                }
            }
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
