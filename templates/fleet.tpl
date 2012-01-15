<div id="fleets">
	<div class="content">
		<h1>{$fleet.name}</h1>
		<div class="fleet-info">
			<p>
			{if $fleet.moving}
				Moving to <a href="{if $fleet.queue.0.planet_ruler == $ruler.id}/planets/{$fleet.queue.0.planet_id}{else}/navigation/{$fleet.queue.0.galaxy_id}/{$fleetqueue.0.system_id}{/if}">{$fleet.queue.0.planet_name} ({$fleet.queue.0.planet_id}) ({$fleet.queue.0.turns} turns)</a>
			{else}
				Waiting at <a href="{if $fleet.planet_ruler == $ruler.id}/planets/{$fleet.planet_id}{else}/navigation/{$fleet.galaxy_id}/{$fleet.system_id}{/if}">{$fleet.planet_name} ({$fleet.planet_id})</a>
			{/if}
			</p>			
		</div>
	</div>
</div>