function PostData()
{
    // We update all the data to make sure we have everything from the form fields
    updateFormValues();

    //set base url
    //TODO Put base url in laravel config
    var url = 'http://www.intro.dvc-icta.nl/SpeurtochtApi/web/';
    var questName = document.getElementById('questName').value;
    var questCourse = document.getElementById('questCourse').value;
    var questInfo = document.getElementById('questInfo').value;

    //Make quest object
    var quest = {
        name: questName,
        course: questCourse,
        info: questInfo
    };
    var marker = [];

    //Make array of marker objects
    for(i = 0; i < markers.length; i++)
    {
        marker.push({
            name: markers[i].metadata.name,
            markerInfo: markers[i].metadata.markerInfo,
            isQr: markers[i].metadata.isQR,
            isVisible: markers[i].metadata.isVisible,
            location: {
                lat: markers[i].metadata.location.lat,
                lng: markers[i].metadata.location.lng
            },
            questions: {
                answer1: markers[i].metadata.questions.answer1,
                answer2: markers[i].metadata.questions.answer2,
                answer3: markers[i].metadata.questions.answer3,
                answer4: markers[i].metadata.questions.answer4,
                correctAnswer: markers[i].metadata.questions.correctAnswer,
                points: markers[i].metadata.questions.points,
                question: markers[i].metadata.questions.question
            }
        });
    }

    //Put all objects in one json object
    var data = {
        quest:quest,
        marker:marker,
        polygonMarkers:polygonMarkers
    };

    //Post the object to the server as a whole quest
    $.ajax({
            type: "POST",
            url: url + 'postQuest/',
            data: JSON.stringify(data),
            succes:null,
            dataType: 'application/json'
            });

    //Redirect to HomePage
    //TODO redirect to the view page from the quest
    window.location.href = redirectLink;
}

function PutData()
{
    // We update all the data to make sure we have everything from the form fields
    updateFormValues();

    //set base url
    //TODO Put base url in laravel config
    var url = 'http://www.intro.dvc-icta.nl/SpeurtochtApi/web/';
    var questName = document.getElementById('questName').value;
    var questCourse = document.getElementById('questCourse').value;
    var questInfo = document.getElementById('questInfo').value;

    //Make quest object
    var quest = {
        id: questId,
        name: questName,
        course: questCourse,
        info: questInfo
    };


    var marker = [];
    var updateMarker = [];


    //Make 2 arrays with markers one for newly placed markers and one for the markers we need to update
    for(i = 0; i < markers.length; i++)
    {
        //We check if the id is higher than the Highest id we got from the database and if that is true it will add the marker to the Post Array
        if (markers[i].metadata.id <= highestEditId) 
        {
            updateMarker.push({
                id: markers[i].metadata.id,
                name: markers[i].metadata.name,
                markerInfo: markers[i].metadata.markerInfo,
                isQr: markers[i].metadata.isQR,
                isVisible: markers[i].metadata.isVisible,
                location: {
                    lat: markers[i].metadata.location.lat,
                    lng: markers[i].metadata.location.lng
                },
                questions: {
                    id: markers[i].metadata.questions.id,
                    answer1: markers[i].metadata.questions.answer1,
                    answer2: markers[i].metadata.questions.answer2,
                    answer3: markers[i].metadata.questions.answer3,
                    answer4: markers[i].metadata.questions.answer4,
                    correctAnswer: markers[i].metadata.questions.correctAnswer,
                    points: markers[i].metadata.questions.points,
                    question: markers[i].metadata.questions.question
                }
            });
        }
        else
        {
            marker.push({
                name: markers[i].metadata.name,
                markerInfo: markers[i].metadata.markerInfo,
                isQr: markers[i].metadata.isQR,
                isVisible: markers[i].metadata.isVisible,
                location: {
                    lat: markers[i].metadata.location.lat,
                    lng: markers[i].metadata.location.lng
                },
                questions: {
                    answer1: markers[i].metadata.questions.answer1,
                    answer2: markers[i].metadata.questions.answer2,
                    answer3: markers[i].metadata.questions.answer3,
                    answer4: markers[i].metadata.questions.answer4,
                    correctAnswer: markers[i].metadata.questions.correctAnswer,
                    points: markers[i].metadata.questions.points,
                    question: markers[i].metadata.questions.question
                }
            });
        }
    }

    //Make marker object for new Markers
    var postData = {
        markers: marker,
        questId: questId
    };

    //Make A object for the updated markers, Polygon and quest
    var putData = {
        markers: updateMarker,
        quest: quest,
        polygonMarkers: polygonMarkers
    }

    //Post the new markers
    $.ajax({
            type: "POST",
            url: url + 'marker/',
            data: JSON.stringify(postData),
            succes:null,
            dataType: 'application/json'
            });

    //Update the existing markers
    $.ajax({
            type: "POST",
            url: url + 'putQuest/',
            data: JSON.stringify(putData),
            succes:null,
            dataType: 'application/json'
            });

    //Redirect home
    //TODO redirect to the view page from the quest
    window.location.href = redirectLink;
}