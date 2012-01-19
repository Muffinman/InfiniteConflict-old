$(document).ready(function(){
	$("#transfer-dest").change(function(){
		$("#transfer input[type=text]").val('');
		$("#transfer").submit();
	});
	
	$("#colonise").submit(function(e){
		e.preventDefault();
		$.post('/ajax/fleets/colonise', $(this).serialize(), function(data){
			if (data.planet){
				window.location = '/planet/' . data.planet;
			}	
		}, 'json');
		return false;
	});
	
	
	$("#fleet-queue tbody").sortable({
		items: 'tr:not(.nodrag)',
		start: function(event, ui){
			//$(ui.item).find('img').animate({width: '40px', height: '40px'}, 250);
			//$(ui.item).find('td').not('.training-image').css({display: 'none'});
		},
		beforeStop: function(event, ui){
			//$(ui.item).find('img').animate({width: '28px', height: '28px'}, 250);
			//$(ui.item).find('td').css({display: 'table-cell'});
		},
		stop: function(event, ui){
			$.post('/ajax/fleets/queue/reorder/', $(this).sortable('serialize') + '&fleet_id=' + $("#fleet_id").val(), function(data){
				redrawFleetQueue(data);
			}, 'json');
		}
	});

	$("#fleet-queue .remove a").live('click', function(e){
		e.preventDefault();
		$.post($(this).attr('href'), {fleet_id: $("#fleet_id").val()}, function(data){
			redrawFleetQueue(data);
		}, 'json');
		return false;
	});	


	var redrawFleetQueue = function(data){
		$("#fleet-queue tbody").html('');
		$("#fleet-queue").css('display','table');
		$(".empty-queue").css('display','none');
		if (data.queue){
			for (i in data.queue){
				
				html = '<tr '+(data.queue[i].started==1 ? 'class="nodrag"' : '')+' id="hash_'+data.queue[i].hash+'">'
					 + '<td class="rank">'+data.queue[i].rank+'</td>'
					 + '<td>';
					
				if (data.queue[i].planet_id){
					html += 'Move';
				}
				if (data.queue[i].type == 'load'){
					html += 'Load';
				}
				if (data.queue[i].type == 'unload'){
					html += 'Unload';
				}
				if (data.queue[i].type == 'unloadall'){
					html += 'Unload All';
				}
					
				html += '</td>';
				html += '<td>';
				
				if (data.queue[i].planet_id){
					html += data.queue[i].planet_id + ' / ' + data.queue[i].planet_name;
				}
				
				if (data.queue[i].resource_id){
					html += '<img src="/images/resources/'+data.queue[i].resource_id+'.gif" alt="'+data.queue[i].resource_name+'" /> ';
					html += data.queue[i].resource_name;
				}
				
				if (data.queue[i].production_id){
					html += '<img src="/images/ships/'+data.queue[i].production_id+'.jpg" alt="'+data.queue[i].production_name+'" /> ';
					html += data.queue[i].production_name;
				}
				
				html += '</td>';
				html += '<td>';
				
				if (data.queue[i].turns){
					html += data.queue[i].turns = ' turns';
				}else{
					if (data.queue[i].qty){
						html += data.queue[i].qty;
					}
				}
				
				html += '</td>';
				html += '<td>';
				
				if (data.queue[i].repeat){
					html += 'Yes';
				}
				
				html += '</td>';
				html += '<td class="remove">'+(data.queue[i].started==1 ? '' : '<a href="/ajax/fleets/queue/remove/'+data.queue[i].hash+'/">[x]</a>')+'</td>'					
					 + '</tr>';					
					
				$("#fleet-queue tbody").append(html);
			}
		}else{
			$("#fleet-queue").css('display','none');
			$(".empty-queue").css('display','block');
		} 	
	}
	
});