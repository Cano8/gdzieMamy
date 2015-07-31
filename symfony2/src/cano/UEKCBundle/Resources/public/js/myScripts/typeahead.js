var bestPictures = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    //prefetch: '',
    remote: {
        url: 'xhr/groupsOrTeachers/%QUERY',
        wildcard: '%QUERY'
    },
});

$('.searchInput').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        name: 'basicSearch',
        displayKey: 'name',
        limit: 8,
        source: bestPictures
    });

var gTId = undefined;
var gGId = undefined;

$(".searchInput").on("typeahead:selected typeahead:autocompleted", function(e, datum) {
    if (datum.tId != undefined ) {
        gTId = datum.tId;
        gGId = undefined;
    } else {
        if (datum.gId != undefined ) {
            gGId = datum.gId;
            gTId = undefined;
        }
    }
});

$(".searchInput").keyup(function(event){
    if(event.keyCode == 13){
        console.log('gGId: ' + gGId + ", gTId: " + gTId);
        if (gTId != undefined) {
            window.location.href = 'timetable/teacher/'+ gTId;
        } else {
            if (gGId != undefined) {
                window.location.href = 'timetable/group/'+ gGId;
            }
        }
    }
});