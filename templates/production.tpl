{include file='planet_header.tpl'}

<div class="content built">
  <h1>Completed Ships</h1>
  <table>
    <thead>
      <tr>
        <th></th>
        <th>Name</th>
      </tr>
    </thead>
    <tbody>
      {foreach from=$produced item=p}
        <tr>
          <td class="production-image"><img src="/images/ships/{$p.id}.jpg" alt="{$p.name}" title="{$p.name}"></td>
          <td class="production-name">{$p.qty} {$p.name}</td>
        </tr>
      {/foreach}
    </tbody>
  </table>
</div>


<div class="content queue">
  <h1>Production Queue</h1>
  <form id="production-queue" action="/ajax/production/queue/reorder/" method="post"{if !$productionQueue} style="display:none;"{/if}>
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
        {if $productionQueue}
          {foreach from=$productionQueue item=p}
            <tr id="hash_{$p.hash}"{if $p.started} class="nodrag"{/if}>
              <td class="rank">{$p.rank}</td>
              <td class="production-image"><img src="/images/ships/{$p.production_id}.jpg" alt="{$p.name}" title="{$p.name}"></td>
              <td class="production-name">{$p.name} ({$p.qty})</td>
              <td class="turns">{$p.turns}</td>
              <td class="status">
              {if $p.started}
                Started
              {else}
                {if $p.rank > 1}
                  Queued
                {else}
                  Starting
                {/if}
              {/if}
              </td>
              <td class="remove">{if !$p.started}<a href="/ajax/production/queue/remove/{$p.hash}/">[x]</a>{/if}</td>
            </tr>
          {/foreach}
        {/if}
      </tbody>
    </table>
    <input type="hidden" id="planet_id" name="planet_id" value="{$planet.id}">
  </form>


  <div class="empty-queue"{if $productionQueue} style="display:none"{/if}>
    <p>You do not have any ships in the production queue</p>
  </div>

</div>


<div class="content available">
  <h1>Ships Available</h1>
  <form id="production-list" action="/ajax/production/queue/add/" method="post">
    <table>
      <thead>
        <tr>
          <th></th>
          <th>Name</th>
          {foreach from=$resList item=r}
            {if !$r.global && $r.id==1 || $r.id==2|| $r.id==7}
              <th class="resource"><img src="/images/resources/{$r.id}.gif" alt="{$r.name}" title="{$r.name}"></th>
            {/if}
          {/foreach}
          <th><img src="/images/time.gif" alt="Construction Time" title="Construction Time"></th>
          <th>Qty.</th>
        </tr>
      </thead>
      <tbody>
        {foreach from=$availableProduction item=p}
          <tr>
            <td class="production-image"><img src="/images/ships/{$p.id}.jpg" alt="{$p.name}" title="{$p.name}"></td>
            <td class="production-name">{$p.name}</td>
            {foreach from=$resList item=r}
              {assign var=rid value=$r.id}
              {if !$r.global && $r.id==1 || $r.id==2 || $r.id==7}
                <td class="resource{$rid}">{$p.resources.$rid.cost_str}</td>
              {/if}
            {/foreach}
            <td>{$p.turns}</td>
            <td class="qty"><input type="text" name="production_id[{$p.id}]" class="qty" value="" /></td>
          </tr>
        {/foreach}
      </tbody>
    </table>
    <p><input type="hidden" name="planet_id" value="{$planet.id}"><input type="submit" value="Queue Production"></p>
  </form>
</div>

<div class="clear"></div>
