(function( $ ) {
	'use strict';


	$(document).on('click', '.fb_sc_submitbtn', function(e){
		e.preventDefault();
		// $(this).parents('form').trigger('submit');
		// $('.fb-form-elem, .new_shift_sched, .new_loc, .new_shifttype').attr('disabled','disabled');

	});

	$(document).on('click', '.new_shift_sched', function(){
		$('#add-edit-span').html('');
		$('.shiftform .fb-form-elem').val('');
		$('#submit_shift').val("Add");
	});

	$(document).on('click', '.new_loc', function(){
		$('#add-edit-span_loc').html('');
		$('.locform .fb-form-elem').val('');
		$('#submit_loc').val("Add");
	});

	$(document).on('click', '.new_shifttype', function(){
		$('#add-edit-span_shifttype').html('');
		$('.shifttypeform .fb-form-elem').val('');
		$('#submit_shifttype').val("Add");
	});

	$(document).on('click', '.btn-delete-shift', function(){

		if (confirm("Confirm delete.")) {
			var dataid = $(this).parents('tr').attr('data-id');

			$('.shiftform .fb-form-elem').attr('disabled','disabled');
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

	$(document).on('click', '.btn-delete-loc', function(){

		if (confirm("Confirm delete.")) {
			var dataid = $(this).parents('tr').attr('data-id');

			$('.locform .fb-form-elem').attr('disabled','disabled');
			var request = $.ajax({
				url: ajaxArr.ajaxUrl,
				type: 'POST',
				data: 'ajax=1&action=deleteLocData' +
				'&dataid=' + dataid,
				dataType: "json"
			});

	        request.done(function(response) {
				location.reload();
			});

		} else {

		}

	});

	$(document).on('click', '.btn-delete-shifttype', function(){

		if (confirm("Confirm delete.")) {
			var dataid = $(this).parents('tr').attr('data-id');

			$('.shifttypeform .fb-form-elem').attr('disabled','disabled');
			var request = $.ajax({
				url: ajaxArr.ajaxUrl,
				type: 'POST',
				data: 'ajax=1&action=deleteShiftTypeData' +
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

		$('.shiftform .fb-form-elem, .new_shift_sched').attr('disabled','disabled');
		var request = $.ajax({
			url: ajaxArr.ajaxUrl,
			type: 'POST',
			data: 'ajax=1&action=getShiftScheduleData' +
			'&dataid=' + dataid,
			dataType: "json"
		});

        request.done(function(response) {
			$('#add-edit-span').html('Updating #'+ response.shift_schedules_id);

			$('.shiftform .fb-form-elem, .new_shift_sched').removeAttr('disabled');
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
			$('.shiftform .fb-form-elem, .new_shift_sched').removeAttr('disabled');
			// console.log('fail');
		});
	});


	$(document).on('click', '.btn-edit-loc', function(){
		var dataid = $(this).parents('tr').attr('data-id');

		$('.locform .fb-form-elem, .new_loc').attr('disabled','disabled');
		var request = $.ajax({
			url: ajaxArr.ajaxUrl,
			type: 'POST',
			data: 'ajax=1&action=getLocData' +
			'&dataid=' + dataid,
			dataType: "json"
		});

        request.done(function(response) {
			$('#add-edit-span_loc').html('Updating #'+ response.location_id);

			$('.locform .fb-form-elem, .new_loc').removeAttr('disabled');
			$('#hidden_loc_id').val(response.location_id);
			$('#loc_name').val(response.location_name);

			$('#submit_loc').val("Update");

		});

		request.fail(function(response) {
			$('.locform .fb-form-elem, .new_loc').removeAttr('disabled');
			// console.log('fail');
		});
	});

	$(document).on('click', '.btn-edit-shifttype', function(){
		var dataid = $(this).parents('tr').attr('data-id');

		$('.shifttypeform .fb-form-elem, .new_shifttype').attr('disabled','disabled');
		var request = $.ajax({
			url: ajaxArr.ajaxUrl,
			type: 'POST',
			data: 'ajax=1&action=getShiftTypeData' +
			'&dataid=' + dataid,
			dataType: "json"
		});

        request.done(function(response) {
			$('#add-edit-span_shifttype').html('Updating #'+ response.shifttype_id);

			$('.shifttypeform .fb-form-elem, .new_shifttype').removeAttr('disabled');
			$('#hidden_shifttype_id').val(response.shifttype_id);
			$('#shifttype_name').val(response.shifttype_name);

			$('#submit_shifttype').val("Update");

		});

		request.fail(function(response) {
			$('.shifttypeform .fb-form-elem, .new_shifttype').removeAttr('disabled');
			// console.log('fail');
		});
	});



})( jQuery );
