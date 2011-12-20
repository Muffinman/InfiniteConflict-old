$(document).ready(function(){
	
	$("#research-list").submit(function(e){
	  e.preventDefault();
	  $.post('/ajax/research/queue/add/', $(this).serialize(), function(data){
      redrawResearchQueue(data);
      redrawResearchList(data);
	  }, 'json');
	  return false;
	});

  $("#research-queue .remove a").live('click', function(e){
    e.preventDefault();
	  $.post($(this).attr('href'), $(this).parents('form').serialize(), function(data){
      redrawResearchQueue(data);
      redrawResearchList(data);
	  }, 'json');
    return false;
  });

	var redrawResearchQueue = function(data){
    $("#research-queue tbody").html('');
    $("#research-queue").css('display','table');
    $(".empty-queue").css('display','none');
    if (data.queue){
      var j=1;
      for (i in data.queue){
        $("#research-queue tbody").append(
          '<tr id="hash_'+data.queue[i].hash+'">'
          +'<td>'+data.queue[i].name+'</td>'
          +'<td>'+data.queue[i].turns+'</td>'
          +'<td>'
          + (data.queue[i].started ? 'Started' : (j > 1 ? 'Queued' : 'Starting' ))
          +'</td>'
          +'<td class="remove"><a href="/ajax/research/queue/remove/'+data.queue[i].hash+'/">[x]</a></td>'
          +'</tr>'
        );
        j++;
      }
    }else{
      $("#research-queue").css('display','none');
      $(".empty-queue").css('display','block');
    }
	};

	var redrawResearchList = function(data){
    $("#research-list tbody").html('');
    $("#research-list").css('display','block');
    if (data.available){
      for (i in data.available){
        var research = data.available[i];
        html = '<tr>';
        html += '<td class="research-name">'+research.name+'</td>';
        html += '<td class="turns">'+research.turns+'</td>';
        html += '<td class="cost">'+research.resources[10].cost+'</td>';
        html += '<td><input type="radio" name="research" value="'+research.id+'"></td>';
        html += '</tr>';
        $("#research-list tbody").append(html);
      }
    }
	};

	
});
