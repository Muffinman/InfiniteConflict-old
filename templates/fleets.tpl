<div id="fleets">
	<div class="content">
		<h1>Fleets</h1>
		{if $fleets}
			<table class="fleets-list">
				<thead>
					<tr>
						<th>Fleet Nane</th>
						<th>Status</th>
						{foreach from=$resources item=r}
							{if $r.transferable && $r.id != 9}
								<th><img src="/images/resources/{$r.id}.gif" alt="{$r.name}" /></th>
							{/if}
						{/foreach}
					</tr>
				</thead>
				<tbody>
					{foreach from=$fleets item=f}
						<tr>
							<td><a href="/fleet/{$f.id}">{$f.name}</a></td>
							<td>
								{if $f.moving}
									Moving to <a href="{if $f.queue.0.planet_ruler == $ruler.id}/planet/{$f.queue.0.planet_id}{else}/navigation/{$f.queue.0.galaxy_id}/{$f.queue.0.system_id}{/if}">{$f.queue.0.planet_name} ({$f.queue.0.planet_id}) ({$f.queue.0.turns} turns)</a>
								{else}
									Waiting at <a href="{if $f.planet_ruler == $ruler.id}/planet/{$f.planet_id}{else}/navigation/{$f.galaxy_id}/{$f.system_id}{/if}">{$f.planet_name} ({$f.planet_id})</a>
								{/if}
							</td>
							{foreach from=$resources item=r}
								{if $r.transferable && $r.id != 9}
									{assign var=rid value=$r.id}
									<td>{$f.resources.$rid.stored}</td>
								{/if}
							{/foreach}
						</tr>
					{/foreach}
				</tbody>
			</table>
		{else}
			<p>You currently have no fleets</p>
		{/if}
	</div>
</div>