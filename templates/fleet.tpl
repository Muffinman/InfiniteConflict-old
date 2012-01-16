<div id="fleets">
	<div class="content">
		<h1>{$fleet.name}</h1>
		<div class="fleet-info">
			<p>
			{if $fleet.moving}
				Moving to <a href="{if $fleet.queue.0.planet_ruler == $ruler.id}/planet/{$fleet.queue.0.planet_id}{else}/navigation/{$fleet.queue.0.galaxy_id}/{$fleetqueue.0.system_id}{/if}">{$fleet.queue.0.planet_name} ({$fleet.queue.0.planet_id}) ({$fleet.queue.0.turns} turns)</a>
			{else}
				Waiting at <a href="{if $fleet.planet_ruler == $ruler.id}/planet/{$fleet.planet_id}{else}/navigation/{$fleet.galaxy_id}/{$fleet.system_id}{/if}">{$fleet.planet_name} ({$fleet.planet_id})</a>
			{/if}
			</p>			
		</div>
	</div>
	
	<div class="content fleet-queue">
		<h1>Fleet Queue</h1>
		{if $fleet.queue}
			
		{else}
			<div class="fleet-info">
				<p>The fleet currently has no orders</p>
			</div>
		{/if}
	</div>
	
	<div class="content fleet-transfer">
		<h1>Resource Transfer</h1>
		
		<div class="fleet-info">

			<form action="/fleet/{$fleet.id}/transfer/" method="post" id="transfer">

				{if $fleets || $planet}
					<p>Transfer resources to and from:
						<select name="transfer-dest" id="transfer-dest">
							{if $planet}
								<option value="planet_{$planet.id}"{if $dest_type=='planet' && $dest_id==$planet.id} selected="selected"{/if}>{$planet.name} (planet)</option>
							{/if}
							{if $fleets}
								{foreach from=$fleets item=f}
									<option value="fleet_{$f.id}"{if $dest_type=='fleet' && $dest_id==$f.id} selected="selected"{/if}>{$f.name} (fleet)</option>							
								{/foreach}
							{/if}
						</select>
					</p>
				{else}
					<p>You currently have no planets or fleets to transfer to.</p>
				{/if}
			</div>
		
			{if $fleets || $planet}
				<h2 class="margin">Ships and resources available in {$fleet.name}</h2>
				<table class="transfer-available">
					<thead>
						<tr>
							<th class="amount">Amount</th>
							<th>Resource</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						{if $fleet.produced}
							{foreach from=$fleet.produced item=p}
								{if $p.qty}
									<tr>
										<td class="amount"><input type="text" name="produced[{$p.id}]" /></td>
										<td><image src="/images/ships/{$p.id}.jpg" alt="{$p.name}" /> {$p.name}</td>
										<td>{$p.qty}</td>
									</tr>
								{/if}
							{/foreach}
						{/if}
						{if $fleet.resources}
							{foreach from=$fleet.resources item=res}
								{if $res.transferable && $res.stored}
									<tr>
										<td class="amount"><input type="text" name="resource[{$res.resource_id}]" /></td>
										<td><image src="/images/resources/{$res.resource_id}.gif" alt="{$res.name}" /> {$res.name}</td>
										<td>{$res.stored}</td>
									</tr>
								{/if}
							{/foreach}
						{/if}
					</tbody>
				</table>
				<p style="text-align:center; margin-top:5px;"><input type="submit" name="from-current-fleet" value="Transfer from Fleet" /></p>
			{/if}
		</form>
		
			
		{if $planet && $dest_type=='planet' && $dest_id==$planet.id}
			<form action="/fleet/{$fleet.id}/transfer/" method="post" id="transfer">
				<h2 class="margin">Ships and resources available at {$planet.name}</h2>
				<table class="transfer-available">
					<thead>
						<tr>
							<th class="amount">Amount</th>
							<th>Resource</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						{if $planet.produced}
							{foreach from=$planet.produced item=p}
								{if $p.qty}
									<tr>
										<td class="amount"><input type="text" name="produced[{$p.id}]" /></td>
										<td><image src="/images/ships/{$p.id}.jpg" alt="{$p.name}" /> {$p.name}</td>
										<td>{$p.qty}</td>
									</tr>
								{/if}
							{/foreach}
						{/if}
						{if $planet.resources}
							{foreach from=$planet.resources item=res}
								{if $res.transferable && $res.stored}
									<tr>
										<td class="amount"><input type="text" name="resource[{$res.resource_id}]" /></td>
										<td><image src="/images/resources/{$res.resource_id}.gif" alt="{$res.name}" /> {$res.name}</td>
										<td>{$res.stored}</td>
									</tr>
								{/if}
							{/foreach}
						{/if}
	
					</tbody>
				</table>
				<p style="text-align:center; margin-top:5px;"><input type="hidden" name="transfer-dest" value="planet_{$planet.id}" /><input type="submit" name="from-planet" value="Transfer from Planet" /></p>	
			</form>			
		{/if}
			
		{if $fleets && $dest_type=='fleet'}
			{foreach from=$fleets item=f}
				{if $f.id==$dest_id}
					<form action="/fleet/{$fleet.id}/transfer/" method="post" id="transfer">
						<h2 class="margin">Ships and resources available in {$f.name}</h2>
						<table class="transfer-available">
							<thead>
								<tr>
									<th class="amount">Amount</th>
									<th>Resource</th>
									<th>Quantity</th>
								</tr>
							</thead>
							<tbody>
								{if $f.produced}
									{foreach from=$f.produced item=p}
										{if $p.qty}
											<tr>
												<td class="amount"><input type="text" name="produced[{$p.id}]" /></td>
												<td><image src="/images/ships/{$p.id}.jpg" alt="{$p.name}" /> {$p.name}</td>
												<td>{$p.qty}</td>
											</tr>
										{/if}
									{/foreach}
								{/if}
								{if $f.resources}
									{foreach from=$f.resources item=res}
										{if $res.transferable && $res.stored}
											<tr>
												<td class="amount"><input type="text" name="resource[{$res.resource_id}]" /></td>
												<td><image src="/images/resources/{$res.resource_id}.gif" alt="{$res.name}" /> {$res.name}</td>
												<td>{$res.stored}</td>
											</tr>
										{/if}
									{/foreach}
								{/if}
	
							</tbody>
						</table>
						<p style="text-align:center; margin-top:5px;"><input type="hidden" name="transfer-dest" value="fleet_{$f.id}" /><input type="submit" name="from-other-fleet" value="Transfer from Fleet" /></p>
					</form>
				{/if}
			{/foreach}
		{/if}
					
	</div>
	
</div>