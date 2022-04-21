(function( $ ) {
'use strict';

    $(document).on('click', '#calendardays .days .selectable', function(){
        $('.shifts-overlay').show();

        var year = $('#calendardays').attr('data-year');
        var month = $('#calendardays').attr('data-month');
        var day = $(this).attr('data-day');
        
        var selectedDate = new Date(year, (month-1), day);
        $('.shifts-overlay .ymd-label').text(selectedDate.toDateString());
    });
    function pad(num, size) {
        num = num.toString();
        while (num.length < size) num = "0" + num;
        return num;
    }

    $(document).on('click', '.shifts-overlay', function(){
        $('.shifts-overlay').hide();
    });

    $(document).on('click', '#choose-ym-calendar', function(){

        trigger_ym_calendar();
    });

    // $('.example-popover').popover({
    //     container: 'body'
    // })

    trigger_ym_calendar();


    function trigger_ym_calendar()
    {
        $('#fb-month').attr('disabled','disabled');
        $('#fb-year').attr('disabled','disabled');
        $('#choose-ym-calendar').attr('disabled','disabled');
        var month = $('#fb-month').val();
        var year = $('#fb-year').val();

        var request = $.ajax({
            url: ajaxArr.ajaxUrl,
            type: 'POST',
            data: 'ajax=1&action=getCalendarDays' +
            '&month=' + month +
            '&year=' + year,
            dataType: "html"
        });

        request.done(function(response) {
            $('#calendardays').html(response);
            $('#calendardays').attr('data-month',month);
            $('#calendardays').attr('data-year',year);
            $('#fb-month').removeAttr('disabled');
            $('#fb-year').removeAttr('disabled');
            $('#choose-ym-calendar').removeAttr('disabled');
            //
            // $('.fb-form-elem').removeAttr('disabled');
            // $('#hidden_shift_id').val(response.shift_schedules_id);
            // $('#location_id').val(response.shift_schedules_location_id);
            // $('#shift_id').val(response.shift_schedules_shifttype_id);
            // $('#date_from').val(response.shift_schedules_datefrom);
            // $('#time_from').val(response.shift_schedules_timefrom);
            // $('#date_to').val(response.shift_schedules_dateto);
            // $('#time_to').val(response.shift_schedules_timeto);
            //
            // $('#submit_shift').val("Update");


        });

        request.fail(function(response) {
            // $('.fb-form-elem').removeAttr('disabled');
            // console.log('fail');
        });
    }
})(jQuery);
