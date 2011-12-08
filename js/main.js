$(document).ready(function() {

  $(document).ajaxStop(function(){
    $("#ajax").css({'display':'none'});
  });

  $(document).ajaxStart(function(){
    $("#ajax").css({'display':'block'});
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
