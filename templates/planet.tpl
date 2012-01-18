<div id="planet">

{include file='planet_header.tpl'}
	
	<div class="content built">
	  <h1>Completed Structures</h1>
	  <table>
	    <thead>
	      <tr>
	        <th colspan="2">Name</th>
	        {foreach from=$resList item=r}
	          {if $r.id <= 6}
	            <th class="resource"><img src="/images/resources/{$r.id}.gif" alt="{$r.name}" title="{$r.name}"></th>
	          {/if}
	        {/foreach}
	      </tr>
	    </thead>
	    <tbody>
	      {foreach from=$buildings item=b}
	        <tr>
	          <td rowspan="2" class="building-image"><img src="/images/buildings/{$b.id}.jpg" alt="{$b.name}" title="{$b.name}"></td>
	          <td colspan="7" class="building-name">{$b.qty} {$b.name} {if $b.demolish}<a href="#" class="demolish" id="{$b.id}">[x]</a>{/if}</td>
	        </tr>
	        <tr>
	          <td>&nbsp;</td>
	          {foreach from=$resList item=r}
	            {assign var=rid value=$r.id}
	            {if $r.id <= 4}
	              <td class="resource{$rid}">{if $b.resources.$rid.total_output}{$b.resources.$rid.total_output_str}{/if}</td>
	            {/if}
	            {if  $r.id > 4 && $r.id <= 6}
	              <td class="resource{$rid}">{$b.resources.$rid.total_cost}</td>
	            {/if}
	          {/foreach}
	        </tr>
	      {/foreach}
	    </tbody>
	  </table>
	</div>
	
	<div class="content queue">
	  <h1>Structure Queue</h1>
	  <form id="building-queue" action="/ajax/buildings/queue/reorder/" method="post"{if !$buildingsQueue} style="display:none;"{/if}>
	    <table>
	      <thead>
	        <tr>
	          <th class="rank">Order</th>
	          <th class="image"></th>
	          <th>Name</th>
	          <th class="turns"><img src="/images/time.gif" alt="Turns Left" title="Turns Left"></th>
	          <th class="status">Status</th>
	          <th class="remove">Remove</th>
	        </tr>
	      </thead>
	      <tbody>
	        {if $buildingsQueue}
	          {foreach from=$buildingsQueue item=b}
	            <tr {if $b.started}class="nodrag" {/if}id="hash_{$b.hash}">
	              <td class="rank">{$b.rank}</td>
	              <td class="building-image"><img src="/images/buildings/{$b.building_id}.jpg" alt="{$b.name}" title="{$b.name}"></td>
	              <td class="building-name">{$b.name}{if $b.demolish} (Demolish){/if}</td>
	              <td class="turns">{$b.turns}</td>
	              <td class="status">
	              {if $b.started}
	                Started
	              {else}
	                {if $b.rank > 1}
	                  Queued
	                {else}
	                  Starting
	                {/if}
	              {/if}
	              </td>
	              <td class="remove">{if !$b.started}<a href="/ajax/buildings/queue/remove/{$b.hash}/">[x]</a>{/if}</td>
	            </tr>
	          {/foreach}
	        {/if}
	      </tbody>
	    </table>
	    <input type="hidden" id="planet_id" name="planet_id" value="{$planet.id}">
	  </form>
	
	
	  <div class="empty-queue"{if $buildingsQueue} style="display:none"{/if}>
	    <p>You do not have any structures in the queue</p>
	  </div>
	
	</div>
	
	<div class="content available">
	  <h1>Structures Available</h1>
	  <form id="building-list" action="/ajax/buildings/queue/add/" method="post">
	    <table>
	      <thead>
	        <tr>
	          <th></th>
	          <th>Name</th>
	          {foreach from=$resList item=r}
	            {if !$r.global && $r.id != 3 && $r.id < 8}
	              <th class="resource"><img src="/images/resources/{$r.id}.gif" alt="{$r.name}" title="{$r.name}"></th>
	            {/if}
	          {/foreach}
	          <th><img src="/images/time.gif" alt="Construction Time" title="Construction Time"></th>
	          <th></th>
	        </tr>
	      </thead>
	      <tbody>
	        {foreach from=$availableBuildings item=b}
	          <tr>
	            <td class="building-image"><img src="/images/buildings/{$b.id}.jpg" alt="{$b.name}" title="{$b.name}"></td>
	            <td class="building-name">{$b.name}</td>
	            {foreach from=$resList item=r}
	              {assign var=rid value=$r.id}
	              {if $rid <= 2}
	                <td class="resource{$rid}">{$b.resources.$rid.cost_str}</td>
	              {/if}
	              {if $rid == 4}
	                <td class="resource{$rid}">{$b.resources.$rid.output_str}</td>
	              {/if}
	              {if $rid > 4 && $rid < 8}
	              	{if $b.resources.$rid.output && !$b.resources.$rid.cost}
	              		<td class="resource{$rid}">{$b.resources.$rid.output_str}</td>
	              	{else}
	                	<td class="resource{$rid}">{$b.resources.$rid.cost_str}</td>
	                {/if}
	              {/if}
	            {/foreach}
	            <td>{$b.turns}</td>
	            <td><label><input type="radio" name="building_id" value="{$b.id}"></label></td>
	          </tr>
	        {/foreach}
	      </tbody>
	    </table>
	    <p><input type="hidden" name="planet_id" value="{$planet.id}"><input type="submit" value="Queue Structure"></p>
	  </form>
	</div>

	<div class="clear"></div>

</div>
