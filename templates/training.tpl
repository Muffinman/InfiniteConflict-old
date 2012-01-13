<div id="planet">
	
	{include file='planet_header.tpl'}
	
	<div class="content built">
	  <h1>Completed Units</h1>
	  <table>
	    <thead>
	      <tr>
	        <th></th>
	        <th>Name</th>
	      </tr>
	    </thead>
	    <tbody>
	      {foreach from=$resources key=res item=t}
	      	{if $t.creatable && $t.stored > 0}
		        <tr>
		          <td class="training-image"><img src="/images/resources/{$t.id}.gif" alt="{$t.name}" title="{$t.name}"></td>
		          <td class="training-name">{$t.stored_str} {$res}</td>
		        </tr>
	        {/if}
	      {/foreach}
	    </tbody>
	  </table>
	</div>
	
	<div class="content queue">
	  <h1>Training Queue</h1>
	  <form id="training-queue" action="/ajax/training/queue/reorder/" method="post"{if !$trainingQueue} style="display:none;"{/if}>
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
	        {if $trainingQueue}
	          {foreach from=$trainingQueue item=t}
	            <tr id="hash_{$t.hash}"{if $t.started} class="nodrag"{/if}>
	              <td class="rank">{$t.rank}</td>
	              <td class="training-image"><img src="/images/resources/{$t.resource_id}.gif" alt="{$t.name}" title="{$t.name}"></td>
	              <td class="training-name">{$t.name} ({$t.qty})</td>
	              <td class="turns">{$t.turns}</td>
	              <td class="status">
	              {if $t.started}
	                Started
	              {else}
	                {if $t.rank > 1}
	                  Queued
	                {else}
	                  Starting
	                {/if}
	              {/if}
	              </td>
	              <td class="remove">{if !$t.started}<a href="/ajax/training/queue/remove/{$t.hash}/">[x]</a>{/if}</td>
	            </tr>
	          {/foreach}
	        {/if}
	      </tbody>
	    </table>
	    <input type="hidden" id="planet_id" name="planet_id" value="{$planet.id}">
	  </form>
	
	
	  <div class="empty-queue"{if $trainingQueue} style="display:none"{/if}>
	    <p>You do not have any training in the queue</p>
	  </div>
	
	</div>
	
	<div class="content available">
	  <h1>Units Available</h1>
	  <form id="training-list" action="/ajax/training/queue/add/" method="post">
	    <table>
	      <thead>
	        <tr>
	          <th></th>
	          <th>Name</th>
	          {foreach from=$resList item=r}
	            {if !$r.global && $r.id==1 || $r.id==2 || $r.id==3 || $r.id==7}
	              <th class="resource"><img src="/images/resources/{$r.id}.gif" alt="{$r.name}" title="{$r.name}"></th>
	            {/if}
	          {/foreach}
	          <th><img src="/images/time.gif" alt="Construction Time" title="Construction Time"></th>
	          <th>Qty.</th>
	        </tr>
	      </thead>
	      <tbody>
	        {foreach from=$availableTraining item=t}
	          <tr>
	            <td class="training-image"><img src="/images/resources/{$t.id}.gif" alt="{$t.name}" title="{$t.name}"></td>
	            <td class="training-name">{$t.name}</td>
	            {foreach from=$resList item=r}
	              {assign var=rid value=$r.id}
	              {if !$r.global && $r.id==1 || $r.id==2 || $r.id==3 || $r.id==7}
	                <td class="resource{$rid}">{$t.resources.$rid.cost_str}</td>
	              {/if}
	            {/foreach}
	            <td>{$t.turns}</td>
	            <td class="qty"><input type="text" name="training_id[{$t.id}]" class="qty" value="" /></td>
	          </tr>
	        {/foreach}
	      </tbody>
	    </table>
	    <p><input type="hidden" name="planet_id" value="{$planet.id}"><input type="submit" value="Queue Training"></p>
	  </form>
	</div>
	
	<div class="clear"></div>

</div>
