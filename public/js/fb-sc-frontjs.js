(function( $ ) {
'use strict';

    function openClaimformOvelay() {
        $('.claimform-overlay').show();
    }

    var claimshiftid = $(this).attr('data-id');
    var allowOverlayClose = true;
    $(document).on('click', '#fb_sc_claimbtn', function(e){
        e.preventDefault();
        claimShift();
    });
    $(document).on('click', '.btn-claim-sched', function(e){
        openClaimformOvelay();
        claimshiftid = $(this).attr('data-id');
    });

    function claimShift()
    {
        var email = $('#fb_sc_email').val();
        var name = $('#fb_sc_name').val();
        var newuser_chk = $('#newuser_chk').is(":checked") ? 1 : 0;

        // var email = prompt("Please enter your email:");
        if (email == null || email == "" || name == null || name == "") {
            alert('Please fill up all of the fields');
        } else {
            allowOverlayClose = false;

            $('#fb_sc_name').attr('disabled','disabled');
            $('#fb_sc_email').attr('disabled','disabled');
            $('#newuser_chk').attr('disabled','disabled');
            $('.btn-claim-sched').attr('disabled','disabled');
            $('#fb_sc_claimbtn').attr('disabled','disabled');

            var request = $.ajax({
                url: ajaxArr.ajaxUrl,
                type: 'POST',
                data: 'ajax=1&action=updateShiftEmail' +
                '&email=' + email +
                '&name=' + name +
                '&newuser_chk=' + newuser_chk +
                '&dataid=' + claimshiftid,
                dataType: "json"
            });

            request.done(function(response) {
                allowOverlayClose = true;

                $('.claimform-overlay').hide();
                $('.btn-claim-sched').removeAttr('disabled');
                $('#fb_sc_name').removeAttr('disabled');
                $('#fb_sc_email').removeAttr('disabled');
                $('#fb_sc_claimbtn').removeAttr('disabled');
                $('#newuser_chk').removeAttr('disabled');

                $('#fb_sc_email').val('');
                $('#fb_sc_name').val('');
                $('#newuser_chk').removeAttr('checked');

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
                    openDateOvelay();
                }
            });

            request.fail(function(response) {
                allowOverlayClose = true;
            });

        }
    }

    $(document).on('click', '#add-user-shift', function(){
        openRequestShiftOvelay();
    });

    function openRequestShiftOvelay() {
        $('.requrest-shifts-overlay').show();
    }

    $(document).on('click', '#calendardays .days .selectable', function(){
        var day = $(this).attr('data-day');
        $('#selectedDay').val(day);
        openDateOvelay();
    });

    function openDateOvelay(day) {
        $('.shifts-overlay').show();

        var year = $('#calendardays').attr('data-year');
        var month = $('#calendardays').attr('data-month');
        var day = $('#selectedDay').val();
        var formattedDate = year + '/' + month + '/' + pad(day, 2);


        var shifttype = $('#fb-shifttype').val();
        var location = $('#fb-location').val();

        var selectedDate = new Date(year, (month-1), day);
        $('.shifts-overlay .ymd-label').text(selectedDate.toDateString());

        getDateShifts(formattedDate, shifttype, location, 1);
    }

    function pad(num, size) {
        num = num.toString();
        while (num.length < size) num = "0" + num;
        return num;
    }

    $(document).on('click', '.overlays', function(e){
        if ( allowOverlayClose == true ) {
            $(this).hide();
            if ( $(this).attr('data-overlay') == 'shifts-overlay' ) {
                $('#selectedDay').val('');
                trigger_ym_calendar();
            }
        }
    });

    $(document).on('click', '.btn-overlay-close', function(e){
        if ( allowOverlayClose == true ) {
            $(this).parents('.overlays').hide();
            if ( $(this).parents('.overlays').attr('data-overlay') == 'shifts-overlay' ) {
                $('#selectedDay').val('');
                trigger_ym_calendar();
            }
        }
    });


    $(document).on('click', '.overlay-card', function(e){
        e.stopPropagation();
    });


    $(document).on('click', '#choose-ym-calendar', function(){
        trigger_ym_calendar();
    });

    $(document).on('click', '.pw-submit', function(e){
        e.preventDefault();
        $('#pw-protect-field').attr('disabled','disabled');
        $('.pw-submit').attr('disabled','disabled');

        $('#login-notice').text('');
        $('#login-notice').attr('class','');

        var request = $.ajax({
            url: ajaxArr.ajaxUrl,
            type: 'POST',
            data: 'ajax=1&action=addCalendarPwSession' +
            '&pw_val=' + $('#pw-protect-field').val(),
            dataType: "json"
        });
        request.done(function(response) {
            if (response.success == 1) {
                $('.main-calendar').addClass('loggedin');
                $('.main-auth').addClass('loggedin');
                // $('.main-calendar').show();
                // $('.main-auth').hide();
            } else {
                // alert('Invalid password');
                $('#login-notice').text('Invalid password');
                $('#login-notice').attr('class','alert alert-warning');
            }

            $('#pw-protect-field').removeAttr('disabled');
            $('.pw-submit').removeAttr('disabled');
        });
        request.fail(function(response) {
            $('#pw-protect-field').removeAttr('disabled');
            $('.pw-submit').removeAttr('disabled');
        });
    });


    // $('.example-popover').popover({
    //     container: 'body'
    // })

    trigger_ym_calendar();

	$(document).on('click', '.fb_sc_maindiv .pagination .page-link', function(e){
		e.preventDefault();
		var page = $(this).attr('data-page');
		var pageitem = $(this).parents('.page-item');

		if ( $(pageitem).hasClass('active') ) {
			return;
		}
		var datatable = $(this).parents('.tablediv').attr('data-table');

		if ( datatable == 'available-shifts-table-div') {

            var year = $('#calendardays').attr('data-year');
            var month = $('#calendardays').attr('data-month');
            var day = $('#selectedDay').val();
            var formattedDate = year + '/' + month + '/' + pad(day, 2);

			getDateShifts(formattedDate, page);
		}

	});

    function getDateShifts(date, shifttype, location, page)
    {
        $('#available-shifts-table-div').html('<div class="loadertd"><div class="loader"></div></div>');
        allowOverlayClose = false;
        var request = $.ajax({
            url: ajaxArr.ajaxUrl,
            type: 'POST',
            data: 'ajax=1&action=getDateShifts' +
            '&date=' + date +
            '&shifttype=' + shifttype +
            '&location=' + location +
            '&page=' + page,
            dataType: "html"
        });

        request.done(function(response) {
            $('#available-shifts-table-div').html(response);
            // $('#available-shifts-table tbody').html(response);
            allowOverlayClose = true;
        });

        request.fail(function(response) {
            allowOverlayClose = true;
        });

    }

    function trigger_ym_calendar()
    {
        $('#fb-location').attr('disabled','disabled');
        $('#fb-shifttype').attr('disabled','disabled');
        $('#fb-month').attr('disabled','disabled');
        $('#fb-year').attr('disabled','disabled');
        $('#choose-ym-calendar').attr('disabled','disabled');
        var month = $('#fb-month').val();
        var year = $('#fb-year').val();
        var shifttype = $('#fb-shifttype').val();
        var location = $('#fb-location').val();

        var request = $.ajax({
            url: ajaxArr.ajaxUrl,
            type: 'POST',
            data: 'ajax=1&action=getCalendarDays' +
            '&location=' + location +
            '&shifttype=' + shifttype +
            '&month=' + month +
            '&year=' + year,
            dataType: "html"
        });

        request.done(function(response) {
            $('#calendardays').html(response);
            $('#calendardays').attr('data-month',month);
            $('#calendardays').attr('data-year',year);
            $('#fb-location').removeAttr('disabled');
            $('#fb-shifttype').removeAttr('disabled');
            $('#fb-month').removeAttr('disabled');
            $('#fb-year').removeAttr('disabled');
            $('#choose-ym-calendar').removeAttr('disabled');

        });

        request.fail(function(response) {

            $('#calendardays').html(response);
            $('#calendardays').attr('data-month',month);
            $('#calendardays').attr('data-year',year);
            $('#fb-location').removeAttr('disabled');
            $('#fb-shifttype').removeAttr('disabled');
            $('#fb-month').removeAttr('disabled');
            $('#fb-year').removeAttr('disabled');
            $('#choose-ym-calendar').removeAttr('disabled');
        });
    }


})(jQuery);
