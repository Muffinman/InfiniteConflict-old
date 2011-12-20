$(document).ready(function() {

  $(document).ajaxStop(function(){
    $("#ajax").fadeOut(250);
  });

  $(document).ajaxStart(function(){
    $("#ajax").fadeIn(0);
    //setTimeout(checkAjax, 1000);
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
