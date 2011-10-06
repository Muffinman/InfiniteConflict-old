$(document).ready(function() {

  $(document).ajaxStart(function(){
    $("#ajax").css({'display':'block'});
  }).ajaxStop(function(){
    $("#ajax").css({'display':'none'});
  });

	/*
	 * Confirm certain actions
	 */
	$(".confirm").click(function(e) {
		if (!confirm('This action is non-reversable. Are you sure you want to continue?')) {
			e.preventDefault();
			return false;
		}
	});	

});
