$(document).ready(function(){
	
	$("#building-list").submit(function(e){
	  e.preventDefault();
	  $.post('/ajax/buildings/queue/add/', $(this).serialize(), function(data){
      redrawBuildingQueue(data);
      redrawBuildingList(data);
	  }, 'json');
	  return false;
	});
	
	$("#production-list").submit(function(e){
	  e.preventDefault();
	  $.post('/ajax/production/queue/add/', $(this).serialize(), function(data){
      redrawProductionQueue(data);
      redrawProductionList(data);
	  }, 'json');
	  return false;
	});

	$("#building-queue table tbody").sortable({
	  items: 'tr:not(.nodrag)',
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
        redrawBuildingQueue(data);
  	  }, 'json');
    }
	});

  $("#building-queue .remove a").live('click', function(e){
    e.preventDefault();
	  $.post($(this).attr('href'), $(this).parents('form').serialize(), function(data){
      redrawBuildingQueue(data);
      redrawBuildingList(data);
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



  var redrawBuildingQueue = function(data){
    $("#building-queue tbody").html('');
    $("#building-queue").css('display','block');
    $(".empty-queue").css('display','none');
    if (data.queue){
      for (i in data.queue){
        $("#building-queue tbody").append(
          '<tr '+(data.queue[i].started==1 ? 'class="nodrag"' : '')+' id="hash_'+data.queue[i].hash+'">'
          +'<td class="rank">'+data.queue[i].rank+'</td>'
          +'<td class="building-image"><img src="/images/buildings/'+data.queue[i].building_id+'.jpg" alt="'+data.queue[i].name+'" title="'+data.queue[i].name+'"></td>'
          +'<td class="building-name">'+data.queue[i].name+'</td>'
          +'<td class="turns">'+data.queue[i].turns+'</td>'
          +'<td class="status">'
          + (data.queue[i].started ? 'Started' : (data.queue[i].rank > 1 ? 'Queued' : 'Starting' ))
          +'</td>'
          +'<td class="remove">'+(data.queue[i].started==1 ? '' : '<a href="/ajax/buildings/queue/remove/'+data.queue[i].hash+'/">[x]</a>')+'</td>'
          +'</tr>'
        );
      }
    }else{
      $("#building-queue").css('display','none');
      $(".empty-queue").css('display','block');
    }
  }

  var redrawBuildingList = function(data){
    $("#building-list tbody").html('');
    $("#building-list").css('display','block');
    if (data.available){
      for (i in data.available){
        var bld = data.available[i];
        html = '<tr>';
        html += '<td class="building-image"><img src="/images/buildings/'+bld.id+'.jpg" alt="'+bld.name+'" title="'+bld.name+'"></td>'
        html += '<td class="building-name">'+bld.name+'</td>';

        
        for (res in data.resources){
          var rid = data.resources[res].id;
          if (rid <= 2){
            //console.log('Appending '+data.resources[res].name);
            html += '<td class="resource'+rid+'">'+(bld.resources[rid] ? bld.resources[rid].cost_str : '')+'</td>';
          }
          if (rid == 4){
            //console.log('Appending '+data.resources[res].name);
            html += '<td class="resource'+rid+'">'+(bld.resources[rid] ?  bld.resources[rid].output_str : '')+'</td>';
          }             
          if (rid > 4 && rid < 8){
            //console.log('Appending '+data.resources[res].name);
            html += '<td class="resource'+rid+'">'+(bld.resources[rid] ? bld.resources[rid].cost_str : '')+'</td>';
          }
        }
        
        html += '<td>'+bld.turns+'</td>';
        html += '<td><label><input type="radio" name="building_id" value="'+bld.id+'"></label></td>';
        html += '</tr>';
        $("#building-list tbody").append(html);
      }
    }
  }

});
