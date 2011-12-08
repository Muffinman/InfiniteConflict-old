$(document).ready(function(){
	
	$("#research-list").submit(function(e){
	  e.preventDefault();
	  $.post('/ajax/research/queue/add/', $(this).serialize(), function(data){
      redrawResearchQueue(data);
      redrawResearchList(data);
	  }, 'json');
	  return false;
	});
	
	var redrawResearchQueue = function(data){
	
	};
	
	var redrawResearchList = function(data){
	
	};
	
	
});
