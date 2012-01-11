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
      {foreach from=$ships item=s}
        <tr>
          <td class="ship-image"><img src="/images/ships/{$s.id}.jpg" alt="{$s.name}" title="{$s.name}"></td>
          <td class="ship-name">{$s.qty} {$s.name}</td>
        </tr>
      {/foreach}
    </tbody>
  </table>
</div>

<div class="content queue">
  <h1>Production Queue</h1>
  <form id="ship-queue" action="/ajax/production/queue/reorder/" method="post"{if !$productionQueue} style="display:none;"{/if}>
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
            <tr id="hash_{$p.hash}">
              <td class="rank">{$p.rank}</td>
              <td class="ships-image"><img src="/images/ships/{$p.ships_id}.jpg" alt="{$p.name}" title="{$p.name}"></td>
              <td class="ships-name">{$p.name}</td>
              <td class="turns">{$p.turns}</td>
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
              <td class="remove"><a href="/ajax/production/queue/remove/{$p.hash}/">Remove</a></td>
            </tr>
          {/foreach}
        {/if}
      </tbody>
    </table>
    <input type="hidden" id="planet_id" name="planet_id" value="{$planet.id}">
  </form>


  <div class="empty-queue"{if $productionQueue} style="display:none"{/if}>
    <p>You do not have any ships in the queue</p>
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
            {if !$r.global && $r.id != 3 && $r.id < 8}
              <th class="resource"><img src="/images/resources/{$r.id}.gif" alt="{$r.name}" title="{$r.name}"></th>
            {/if}
          {/foreach}
          <th><img src="/images/time.gif" alt="Construction Time" title="Construction Time"></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        {foreach from=$availableProduction item=s}
          <tr>
            <td class="ship-image"><img src="/images/ships/{$s.id}.jpg" alt="{$s.name}" title="{$s.name}"></td>
            <td class="ship-name">{$s.name}</td>
            {foreach from=$resList item=r}
              {assign var=rid value=$r.id}
              {if $rid <= 2}
                <td class="resource{$rid}">{$s.resources.$rid.cost_str}</td>
              {/if}
              {if $rid == 4}
                <td class="resource{$rid}">{$s.resources.$rid.output_str}</td>
              {/if}
              {if $rid > 4 && $rid < 8}
                <td class="resource{$rid}">{$s.resources.$rid.cost_str}</td>
              {/if}
            {/foreach}
            <td>{$s.turns}</td>
            <td><input type="radio" name="ship_id" value="{$s.id}"></td>
          </tr>
        {/foreach}
      </tbody>
    </table>
    <p><input type="hidden" name="planet_id" value="{$planet.id}"><input type="submit" value="Queue Production"></p>
  </form>
</div>

<div class="clear"></div>
