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
	
	$("#building-list").submit(function(e){
	  e.preventDefault();
	  $.post('/ajax/buildings/queue/add/', $(this).serialize(), function(data){
      if (data.queue){
        redrawBuildingMenu(data);
      }
	  }, 'json');
	  return false;
	});

	$("#building-queue table tbody").sortable({
	  items: 'tr',
	  start: function(event, ui){
	    $(ui.item).find('img').animate({width: '60px', height: '60px'}, 250);
	    $(ui.item).find('td').not('.building-image').css({display: 'none'});
	  },
	  beforeStop: function(event, ui){
	    $(ui.item).find('img').animate({width: '28px', height: '28px'}, 250);
	    $(ui.item).find('td').css({display: 'table-cell'});
	  },
    stop: function(event, ui){
  	  $.post('/ajax/buildings/queue/reorder/', $(this).sortable('serialize') + '&planet_id=' + $("#planet_id").val(), function(data){
        if (data.queue){
          redrawBuildingMenu(data);
        }
  	  }, 'json');
    }
	});

  $("#building-queue .remove a").live('click', function(e){
    e.preventDefault();
	  $.post($(this).attr('href'), $(this).parents('form').serialize(), function(data){
      if (data.queue){
        redrawBuildingMenu(data);
      }
	  }, 'json');
    return false;
  });

	/*
	 * Display message
	 */
	$("#onload_message").hide();
	$("#onload_message").show(1000, function() {
		setTimeout("$('#onload_message').fadeOut(1500)", 5000);
	});

});


var redrawBuildingMenu = function(data){
  $("#building-queue tbody").html('');
  $("#building-queue").css('display','block');
  for (i in data.queue){
    $("#building-queue tbody").append(
      '<tr id="hash_'+data.queue[i].hash+'">'
      +'<td class="rank">'+data.queue[i].rank+'</td>'
      +'<td class="building-image"><img src="/images/buildings/'+data.queue[i].building_id+'.jpg" alt="'+data.queue[i].name+'" title="'+data.queue[i].name+'"></td>'
      +'<td class="building-name">'+data.queue[i].name+'</td>'
      +'<td class="turns">'+data.queue[i].turns+'</td>'
      +'<td class="status">'
      + (data.queue[i].started ? 'Started' : (data.queue[i].rank > 1 ? 'Queued' : 'Waiting' ))
      +'</td>'
      +'<td class="remove"><a href="/ajax/buildings/queue/remove/'+data.queue[i].hash+'/">Remove</a></td>'
      +'</tr>'
    );
  }
}
