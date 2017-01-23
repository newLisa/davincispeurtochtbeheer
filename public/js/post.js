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
        marker.push(markers[i].metadata);
    }

    var data = {
        quest:quest,
        marker:marker
    }
    console.log(data);
    $.ajax({
            type: "POST",
            url: url + 'postQuest/',
            data: data,
            succes:null,
            contentType: 'application/json'
            });
}
