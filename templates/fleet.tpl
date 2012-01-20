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

		<table id="fleet-queue"{if !$fleet.queue} style="display: none;"{/if}>
			<thead>
				<tr>
					<th>#</th>
					<th>Type</th>
					<th>Detail</th>
					<th>Qty</th>
					<th>Repeat</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{if $fleet.queue}
					{foreach from=$fleet.queue item=q}
						<tr {if $q.started}class="nodrag"{else}id="hash_{$q.hash}"{/if}>
							<td>{$q.rank}</td>
							<td>
								{if $q.planet_id}
									Move
								{/if}
								
								{if $q.type=='load'}
									Load 
								{/if}
								
								{if $q.type=='unload'}
									Unload
								{/if}
								
								{if $q.type=='unloadall'}
									Unload All
								{/if}
							</td>
							
							<td>
								{if $q.planet_id}
									{$q.planet_id} / {$q.planet_name}
								{/if}
								
								{if $q.resource_id}
									<img src="/images/resources/{$q.resource_id}.gif" alt="{$q.resource_name}" />
									{$q.resource_name}
								{/if}
								
								{if $q.production_id}
									<img src="/images/ships/{$q.production_id}.jpg" alt="{$q.production_name}" />
									{$q.production_name}
								{/if}						
							</td>
							<td>
							
							{if $q.turns}
								{$q.turns} turns
							{else}	
								{if $q.qty}
									{$q.qty}
								{/if}
							{/if}
							
							</td>
							<td>{if $q.repeat}Yes{/if}</td>
							<td class="remove">{if !$q.started}<a href="/ajax/fleets/queue/remove/{$q.hash}">[x]</a>{/if}</td>
						</tr>
					{/foreach}
				{/if}
			</tbody>
		</table>
			
		<div class="fleet-info empty-queue"{if $fleet.queue} style="display: none;"{/if}>
			<input type="hidden" id="fleet_id" name="fleet_id" value="{$fleet.id}"/>
			<p>The fleet currently has no orders</p>
		</div>

		<h2>Queue an action</h2>
		<table>
			<thead>
				<tr>
					<th>Actions</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<form action="/fleet/{$fleet.id}/queue/" method="post">
						<td>Move to planet:</td>
						<td>
							{if $planets}
							<select name="planet_id">
								{foreach from=$planets item=p}
									<option value="{$p.id}">{$p.name} / {$p.id}</option>
								{/foreach}
							</select>
							{/if}
						</td>	
						<td><label><input type="checkbox" value="1" name="repeat" /> Repeat?</label></td>
						<td><input type="submit" value="Queue"/></td>
					</form>
				</tr>
				<tr>
					<form action="/fleet/{$fleet.id}/queue/" method="post">
						<td>Move to planet ID:</td>
						<td><input value="" type="text" name="planet_id" /></td>
						<td><label><input type="checkbox" value="1" name="repeat" /> Repeat?</label></td>
						<td><input type="submit" value="Queue"/></td>
					</form>
				</tr>
				<tr>
					<form action="/fleet/{$fleet.id}/queue/" method="post">
						<td>Wait Turns:</td>
						<td><input value="" name="wait" /></td>
						<td><label><input type="checkbox" value="1" name="repeat" /> Repeat?</label></td>
						<td><input type="submit" value="Queue"/></td>
					</form>
				</tr>
				<tr>
					<form action="/fleet/{$fleet.id}/queue/" method="post">
						<td>Unload All:</td>
						<td><input type="hidden" value="1" name="unloadall" /></td>
						<td><label><input type="checkbox" value="1" name="repeat" /> Repeat?</label></td>
						<td><input type="submit" value="Queue"/></td>
					</form>
				</tr>
			</tbody>
		</table>

		<h2>Queue a transfer</h2>
		<form action="/fleet/{$fleet.id}/queue/" method="post">
			<table>
				<thead>
					<tr>
						<th>Qty</th>
						<th>Unit</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$resources item=r}
						{if $r.transferable}
							<tr>
								<td class="amount"><input type="text" name="resource[{$r.id}]" /></td>
								<td><img src="/images/resources/{$r.id}.gif" alt="{$r.name}" /> {$r.name}</td>
							</tr>
						{/if}
					{/foreach}
					{foreach from=$production item=p}
						<tr>
							<td class="amount"><input type="text" name="production[{$p.id}]" /></td>
							<td><img src="/images/ships/{$p.id}.jpg" alt="{$p.name}" /> {$p.name}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			<p style="text-align: center; margin-top: 5px;">
				<input type="submit" name="addtoqueue" value="Load" />
				<input type="submit" name="addtoqueue" value="Unload" />
				<input type="checkbox" value="1" name="repeat" /> Repeat?</label>
			</p>
		</form>
		

	</div>
	
	{if $colonise}
		<div class="content colonise fleet-transfer">
			<h1>Colonise Planet</h1>
			<div class="fleet-info">
				<form action="/ajax/fleets/colonise" method="post" id="colonise">
					<p style="margin-bottom: 10px; text-align: center;">You can colonise this planet!</p>
					<p>
						<label for="planet_name">Planet Name</label>
						<input type="text" name="planet_name" id="planet_name" value="" />
						<input type="hidden" name="fleet_id" id="fleet_id" value="{$fleet.id}" />
						<input type="submit" name="" value="Colonise!" />
					</p>
				</form>
			</div>
		</div>
	{/if}
	
	
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
					</tbody>
				</table>
				<p style="text-align:center; margin-top:5px;"><input type="submit" name="from-current-fleet" value="Transfer from Fleet" /></p>
			
			{else}
			
				<h2 class="margin">Ships and resources in {$fleet.name}</h2>
				<table class="transfer-available">
					<thead>
						<tr>
							<th>Resource</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>

						{if $fleet.resources}
							{foreach from=$fleet.resources item=res}
								{if $res.transferable && $res.stored}
									<tr>
										<td><image src="/images/resources/{$res.resource_id}.gif" alt="{$res.name}" /> {$res.name}</td>
										<td>{$res.stored}</td>
									</tr>
								{/if}
							{/foreach}
						{/if}
						{if $fleet.produced}
							{foreach from=$fleet.produced item=p}
								{if $p.qty}
									<tr>
										<td><image src="/images/ships/{$p.id}.jpg" alt="{$p.name}" /> {$p.name}</td>
										<td>{$p.qty}</td>
									</tr>
								{/if}
							{/foreach}
						{/if}
					</tbody>
				</table>
			
			
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
							</tbody>
						</table>
						<p style="text-align:center; margin-top:5px;"><input type="hidden" name="transfer-dest" value="fleet_{$f.id}" /><input type="submit" name="from-other-fleet" value="Transfer from Fleet" /></p>
					</form>
				{/if}
			{/foreach}
		{/if}
					
	</div>	
	
</div>