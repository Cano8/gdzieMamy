$(function () {
    function addDays(date, days) {
        var result = new Date(date);
        result.setDate(date.getDate() + days);
        return result;
    }

    var rangeStart = new Date();
    var rangeEnd = new Date();

    function setDates(baseDate) {
        var baseDay = baseDate.getDay();
        var day = new Date();
        day = addDays(baseDate, 1 - baseDay);
        rangeStart.setTime(day.getTime());
        rangeStart.setHours(0);
        rangeStart.setMinutes(0);
        rangeStart.setSeconds(0, 0);
        $('.dateMon').html(day.getDate() + ' ' + (day.getMonth() + 1) + ' ' + day.getFullYear());
        day = addDays(day, 1);
        $('.dateTue').html(day.getDate() + ' ' + (day.getMonth() + 1) + ' ' + day.getFullYear());
        day = addDays(day, 1);
        $('.dateWed').html(day.getDate() + ' ' + (day.getMonth() + 1) + ' ' + day.getFullYear());
        day = addDays(day, 1);
        $('.dateThu').html(day.getDate() + ' ' + (day.getMonth() + 1) + ' ' + day.getFullYear());
        day = addDays(day, 1);
        $('.dateFri').html(day.getDate() + ' ' + (day.getMonth() + 1) + ' ' + day.getFullYear());
        day = addDays(day, 1);
        $('.dateSat').html(day.getDate() + ' ' + (day.getMonth() + 1) + ' ' + day.getFullYear());
        day = addDays(day, 1);
        rangeEnd.setTime(day.getTime());
        rangeEnd.setHours(24);
        rangeEnd.setMinutes(0);
        rangeEnd.setSeconds(0, 0);
        $('.dateSun').html(day.getDate() + ' ' + (day.getMonth() + 1) + ' ' + day.getFullYear());

        display();
    }

    var date = new Date();
    setDates(date);

    $('#nextWeek').on('click', function () {
        date = addDays(date, 7);
        setDates(date);
    });

    $('#previousWeek').on('click', function () {
        date = addDays(date, -7);
        setDates(date);
    });

    $('#resetWeek').on('click', function () {
        date = new Date();
        setDates(date);
    });

    $('#check').on('click', function () {
        console.log(rangeStart + ' ' + rangeEnd);
    });

    function display() {
        var location = window.location.href;
        location = location.replace(/\/+$/, "");
        var n = location.indexOf('/timetable/group/');
        location = location.substr(n+17)
        $.ajax({

            url: "/app_dev.php/xhr/getTimetable/" + location
        })
            .done(function (data) {
                var boxes = [[]];

                for (i = 0; i < data.length; i++) {
                    boxes[i] = [];
                    boxes[i]['date'] = new Date(data[i]['YYYY'], (data[i]['MM'] - 1), data[i]['DD'], 12, 0, 0, 0);
                    boxes[i]['startHH'] = data[i]['startTime'].substring(0, 2);
                    boxes[i]['startMM'] = data[i]['startTime'].substring(3, 5);
                    boxes[i]['endHH'] = data[i]['endTime'].substring(0, 2);
                    boxes[i]['endMM'] = data[i]['endTime'].substring(3, 5);
                }

                $('.classMarker').remove();

                for (var i = 0; i < boxes.length; i++) {
                    dayNumber = boxes[i]['date'].getDay() - 1;
                    if (dayNumber < 0)
                        dayNumber += 7;

                    if (boxes[i]['date'].getTime() > rangeStart.getTime() && boxes[i]['date'].getTime() < rangeEnd.getTime()) {
                        $('#markers').append('<div id="'+i+'" class="classMarker"></div>');
                        fTime = 56 + (parseFloat(boxes[i]['startHH']) + parseFloat(boxes[i]['startMM'] / 60) - 7) / (21 - 7) * 544;
                        fLength = ((parseFloat(boxes[i]['endHH']) - parseFloat(boxes[i]['startHH'])) + (parseFloat(boxes[i]['endMM']) / 60 - parseFloat(boxes[i]['startMM'] / 60))) / (21 - 7) * 544;
                        fTime = fTime + 'px';
                        fDay = 125 + (dayNumber * 125);
                        $('#' + i).css({top: fTime}).css({height: fLength}).css({left: fDay}).html(data[i]['type'] + ', sala: ' + data[i]['classroom'] + ', prowadzący: ' + data[i]['teacher']);
                    }
                }
            });
    }


});
