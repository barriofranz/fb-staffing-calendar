(function( $ ) {
'use strict';

    var allowOverlayClose = true;
    $(document).on('click', '.btn-claim-sched', function(){

        var email = prompt("Please enter your email:");
        if (email == null || email == "") {

        } else {
            allowOverlayClose = false;
            $('.btn-claim-sched').attr('disabled','disabled');
            var dataid = $(this).attr('data-id');
            var request = $.ajax({
                url: ajaxArr.ajaxUrl,
                type: 'POST',
                data: 'ajax=1&action=updateShiftEmail' +
                '&email=' + email +
                '&dataid=' + dataid,
                dataType: "json"
            });

            request.done(function(response) {
                allowOverlayClose = true;
                $('#fb-year').removeAttr('disabled');
                var doreload = false;
                if ( response.success == 1) {
                    alert("Success");
                    doreload = true;
                } else if ( response.success == 2) {
                    alert("Invalid email");
                } else {
                    alert("Unable to claim shift.");
                    doreload = true;
                }

                if ( doreload ) {
                    openDateOvelay($('#selectedDay').val());
                }
            });

            request.fail(function(response) {
                allowOverlayClose = true;
            });

        }

    });

    $(document).on('click', '#calendardays .days .selectable', function(){
        var day = $(this).attr('data-day');
        $('#selectedDay').val(day);
        openDateOvelay(day);
    });

    function openDateOvelay(day) {
        $('.shifts-overlay').show();

        var year = $('#calendardays').attr('data-year');
        var month = $('#calendardays').attr('data-month');

        var selectedDate = new Date(year, (month-1), day);
        $('.shifts-overlay .ymd-label').text(selectedDate.toDateString());

        $('#available-shifts-table tbody').html('<tr><td colspan="6" class="loadertd"><div class="loader"></div></td></tr>');

        var formattedDate = year + '/' + month + '/' + pad(day, 2);
        getDateShifts(formattedDate);
    }

    function pad(num, size) {
        num = num.toString();
        while (num.length < size) num = "0" + num;
        return num;
    }

    $(document).on('click', '.shifts-overlay, .btn-overlay-close', function(e){

        if ( allowOverlayClose == true ) {
            $('.shifts-overlay').hide();
            $('#selectedDay').val('');
            trigger_ym_calendar();
        }
    });
    $(document).on('click', '.shifts-overlay-card', function(e){
        e.stopPropagation();
    });

    $(document).on('click', '#choose-ym-calendar', function(){

        trigger_ym_calendar();
    });

    // $('.example-popover').popover({
    //     container: 'body'
    // })

    trigger_ym_calendar();


    function getDateShifts(date)
    {

        var request = $.ajax({
            url: ajaxArr.ajaxUrl,
            type: 'POST',
            data: 'ajax=1&action=getDateShifts' +
            '&date=' + date,
            dataType: "html"
        });

        request.done(function(response) {
            $('#available-shifts-table tbody').html(response);

        });

        request.fail(function(response) {
        });

    }

    function trigger_ym_calendar()
    {
        $('#fb-shifttype').attr('disabled','disabled');
        $('#fb-month').attr('disabled','disabled');
        $('#fb-year').attr('disabled','disabled');
        $('#choose-ym-calendar').attr('disabled','disabled');
        var month = $('#fb-month').val();
        var year = $('#fb-year').val();
        var shifttype = $('#fb-shifttype').val();

        var request = $.ajax({
            url: ajaxArr.ajaxUrl,
            type: 'POST',
            data: 'ajax=1&action=getCalendarDays' +
            '&shifttype=' + shifttype +
            '&month=' + month +
            '&year=' + year,
            dataType: "html"
        });

        request.done(function(response) {
            $('#calendardays').html(response);
            $('#calendardays').attr('data-month',month);
            $('#calendardays').attr('data-year',year);
            $('#fb-shifttype').removeAttr('disabled');
            $('#fb-month').removeAttr('disabled');
            $('#fb-year').removeAttr('disabled');
            $('#choose-ym-calendar').removeAttr('disabled');

        });

        request.fail(function(response) {

            $('#calendardays').html(response);
            $('#calendardays').attr('data-month',month);
            $('#calendardays').attr('data-year',year);
            $('#fb-month').removeAttr('disabled');
            $('#fb-year').removeAttr('disabled');
            $('#choose-ym-calendar').removeAttr('disabled');
        });
    }
})(jQuery);
