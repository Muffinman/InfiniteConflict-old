var timer;

$(document).ready(function() {

  $(document).ajaxStop(function(){
    $("#ajax").fadeOut(250);
  });

  $(document).ajaxStart(function(){
    $("#ajax").fadeIn(0);
    //setTimeout(checkAjax, 1000);
  });
  
  timer = setTimeout(updateTimout, 1000);
  
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

var updateTimout = function(){
	timer = setTimeout(updateTimout, 1000);
	update_next -= 1;
	if (update_next == 0){
		update_next = update_interval;
		$("#turn_counter").text(parseInt($("#turn_counter").text()) + 1);
	}
	$("#update_next").text(update_next);
}