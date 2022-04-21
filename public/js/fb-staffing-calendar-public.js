(function( $ ) {
	'use strict';


	// var timepicker = new TimePicker('datetime_from', {
	// 	lang: 'en',
	// 	theme: 'dark'
	// });
	// timepicker.on('change', function(evt) {
	//
	// var value = (evt.hour || '00') + ':' + (evt.minute || '00');
	// evt.element.value = value;
	//
	// });


	$(document).on('click', '.new_shift_sched', function(){
		$('#add-edit-span').html('');
		$('.fb-form-elem').val('');
		$('#submit_shift').val("Add");
	});

	$(document).on('click', '.btn-delete-shift', function(){

		if (confirm("Confirm delete.")) {
			var dataid = $(this).parents('tr').attr('data-id');

			$('.fb-form-elem').attr('disabled','disabled');
			var request = $.ajax({
				url: ajaxArr.ajaxUrl,
				type: 'POST',
				data: 'ajax=1&action=deleteShiftScheduleData' +
				'&dataid=' + dataid,
				dataType: "json"
			});

	        request.done(function(response) {
				location.reload();
			});

		} else {

		}

	});

	$(document).on('click', '.btn-edit-shift', function(){
		var dataid = $(this).parents('tr').attr('data-id');

		$('.fb-form-elem').attr('disabled','disabled');
		var request = $.ajax({
			url: ajaxArr.ajaxUrl,
			type: 'POST',
			data: 'ajax=1&action=getShiftScheduleData' +
			'&dataid=' + dataid,
			dataType: "json"
		});

        request.done(function(response) {
			$('#add-edit-span').html('Updating #'+ response.shift_schedules_id);

			$('.fb-form-elem').removeAttr('disabled');
			$('#hidden_shift_id').val(response.shift_schedules_id);
			$('#location_id').val(response.shift_schedules_location_id);
			$('#shift_id').val(response.shift_schedules_shifttype_id);
			$('#date_from').val(response.shift_schedules_datefrom);
			$('#time_from').val(response.shift_schedules_timefrom);
			$('#date_to').val(response.shift_schedules_dateto);
			$('#time_to').val(response.shift_schedules_timeto);

			$('#submit_shift').val("Update");


		});

		request.fail(function(response) {
			$('.fb-form-elem').removeAttr('disabled');
			// console.log('fail');
		});
	});



})( jQuery );
