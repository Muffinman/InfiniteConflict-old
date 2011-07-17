$(document).ready(function() {

	/*
	 * Confirm certain actions
	 */
	$(".confirm").click(function(e) {
		if (!confirm('This action is non-reversable. Are you sure you want to continue?')) {
			e.preventDefault();
			return false;
		}
	});	
	
	/*
	 * Display message
	 */
	$("#onload_message").hide();
	$("#onload_message").show(1000, function() {
		setTimeout("$('#onload_message').fadeOut(1500)", 5000);
	});

});

