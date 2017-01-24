function PostData()
{
    updateFormValues()
    var url = 'http://www.intro.dvc-icta.nl/SpeurtochtApi/web/';
    var questName = document.getElementById('questName').value;
    var questCourse = document.getElementById('questCourse').value;
    var questInfo = document.getElementById('questInfo').value;

    var quest = {
        name: questName,
        course: questCourse,
        info: questInfo
    };
    var marker = [];

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
    var data = {
        quest:quest,
        marker:marker
    };
    console.log(JSON.stringify(data));
    $.ajax({
            type: "POST",
            url: url + 'postQuest/',
            data: JSON.stringify(data),
            succes:null,
            dataType: 'application/json'
            });
}
