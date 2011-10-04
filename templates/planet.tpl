<div class="content planet">
  <div class="planet-image">
    <img src="/images/planets/{$planet.type}.jpg" alt="{$planet.name}">
  </div>

  <div class="planet-info">
    <h1>{$planet.name}</h1>

    <p class="static-resources">
      {foreach from=$resources key=res item=r}
        {if !$r.output}
          <span class="resource">
            <img src="/images/resources/{$r.id}.gif" alt="{$res}" title="{$res}"> {$r.stored_str}
            {if $r.req_storage && $r.storage}
              ({$r.storage_str} capacity)
            {/if}
            {if $r.id == 7}
              ({$r.busy_str} busy)
            {/if}
          </span>
        {/if}
      {/foreach}
    </p>

    <div class="clear"></div>
  </div>

  <div class="planet-info">
    <table class="variable-resources">
      <thead>
        <tr>
          <th></th>
          {foreach from=$resources key=res item=r}
            {if $r.output}
              <th class="resource{$r.id}"><img src="/images/resources/{$r.id}.gif" alt="{$res}" title="{$res}"> {$res}</th>
            {/if}
          {/foreach}
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Stored</td>
          {foreach from=$resources key=res item=r}
            {if $r.output}
              <td class="resource{$r.id}">{$r.stored_str}</td>
            {/if}
          {/foreach}
        </tr>
        <tr>
          <td>Output</td>
          {foreach from=$resources key=res item=r}
            {if $r.output}
              <td class="resource{$r.id}">{$r.output_str}</td>
            {/if}
          {/foreach}
        </tr>
        <tr>
          <td>Abundance</td>
          {foreach from=$resources key=res item=r}
            {if $r.output}
              <td class="resource{$r.id}">{$r.abundance_str}%</td>
            {/if}
          {/foreach}
        </tr>
      </tbody>
    </table>
  </div>

  <ul class="planet-actions">
    <li class="planet-info action building">
      <h1><a href="/planet/{$planet.id}">Building</a></h1>
    </li>
    <li class="planet-info action production">
      <h1><a href="/planet/{$planet.id}/production">Production</a></h1>
    </li>
    <li class="planet-info action training">
      <h1><a href="/planet/{$planet.id}/training">Training</a></h1>
    </li>
    <li class="planet-info action communications">
      <h1><a href="/planet/{$planet.id}/comms">Communications</a></h1>
    </li>
  </ul>

  <div class="clear"></div>
</div>

<div class="clear"></div>

<div class="content buildings">
  <h1>Completed Structures</h1>
  <table>
    <thead>
      <tr>
        <th></th>
        <th>Name</th>
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
          <td colspan="7" class="building-name">{$b.qty} {$b.name} {if $b.demolish}<a href="#">(x)</a>{/if}</td>
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
            <tr id="hash_{$b.hash}">
              <td class="rank">{$b.rank}</td>
              <td class="building-image"><img src="/images/buildings/{$b.building_id}.jpg" alt="{$b.name}" title="{$b.name}"></td>
              <td class="building-name">{$b.name}</td>
              <td class="turns">{$b.turns}</td>
              <td class="status">
              {if $b.started}
                Started
              {else}
                {if $b.rank > 1}
                  Queued
                {else}
                  Waiting
                {/if}
              {/if}
              </td>
              <td class="remove"><a href="/ajax/buildings/queue/remove/{$b.hash}/">Remove</a></td>
            </tr>
          {/foreach}
        {/if}
      </tbody>
    </table>
    <input type="hidden" id="planet_id" name="planet_id" value="{$planet.id}">
  </form>

  {if !$buildingsQueue}
    <div>
      <p>You do not have any structures in the queue</p>
    </div>
  {/if}
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
                <td class="resource{$rid}">{$b.resources.$rid.cost_str}</td>
              {/if}
            {/foreach}
            <td>{$b.turns}</td>
            <td><input type="radio" name="building_id" value="{$b.id}"></td>
          </tr>
        {/foreach}
      </tbody>
    </table>
    <p><input type="hidden" name="planet_id" value="{$planet.id}"><input type="submit" value="Queue Structure"></p>
  </form>
</div>

<div class="clear"></div>
