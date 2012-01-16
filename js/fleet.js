$(document).ready(function(){
	$("#transfer-dest").change(function(){
		$("#transfer input[type=text]").val('');
		$("#transfer").submit();
	});
});