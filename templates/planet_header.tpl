<div class="content planet">
  <div class="planet-image">
    <img src="/images/planets/{$planet.type}.jpg" alt="{$planet.name}">
  </div>

  <div class="planet-info">
    <h1>{$planet.name} <a href="/navigation/{$planet.galaxy_id}/{$planet.system_id}">(<img src="/images/coords.gif" alt="coords" /> {$planet.id})</a></h1>

    <p class="static-resources">
      {foreach from=$resources key=res item=r}
        {if !$r.net_output && !$r.global}
          <span class="resource">
            <img src="/images/resources/{$r.id}.gif" alt="{$res}" title="{$res}"> {$r.stored_str}
            {if $r.req_storage && $r.storage}
              ({$r.storage_str} storage)
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
            {if $r.net_output}
              <th class="resource{$r.id}"><img src="/images/resources/{$r.id}.gif" alt="{$res}" title="{$res}"> {$res}</th>
            {/if}
          {/foreach}
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Stored</td>
          {foreach from=$resources key=res item=r}
            {if $r.net_output}
              <td class="resource{$r.id}">{$r.stored_str}</td>
            {/if}
          {/foreach}
        </tr>
        <tr>
          <td>Output</td>
          {foreach from=$resources key=res item=r}
            {if $r.net_output}
              <td class="resource{$r.id}">{$r.output_str}</td>
            {/if}
          {/foreach}
        </tr>
        <tr>
          <td>Abundance</td>
          {foreach from=$resources key=res item=r}
            {if $r.net_output}
              <td class="resource{$r.id}">{$r.abundance_str}%</td>
            {/if}
          {/foreach}
        </tr>
      </tbody>
    </table>
  </div>

  <ul class="planet-actions">
    <li class="planet-info action building">
      <a href="/planet/{$planet.id}">Building</a>
    </li>
    <li class="planet-info action production">
      <a href="/planet/{$planet.id}/production">Production</a>
    </li>
    <li class="planet-info action training">
      <a href="/planet/{$planet.id}/training">Training</a>
    </li>
    <li class="planet-info action communications">
      <a href="/planet/{$planet.id}/comms">Comms</a>
    </li>
  </ul>

  <div class="clear"></div>
</div>

<div class="clear"></div>
