{foreach from=$planets item=planet}
<div class="content planet planet-list">
  <div class="planet-image">
    <a href="/planet/{$planet.id}"><img src="/images/planets/{$planet.type}.jpg" alt="{$planet.name}"></a>
  </div>

  <div class="planet-info">
    <h1>{$planet.name}</h1>

    <p class="static-resources">
      {foreach from=$planet.resources key=res item=r}
        {if !$r.output}
          <span class="resource">
            <img src="/images/resources/{$r.id}.gif" alt="{$res}" title="{$res}"> {$r.stored_str}
          </span>
        {/if}
      {/foreach}
    </p>

    <div class="clear"></div>

    <table class="variable-resources" style="margin:10px 0;">
      <tbody>
        <tr>
          {foreach from=$planet.resources key=res item=r}
            {if $r.output}
              <td class="resource{$r.id} nopadding"><img src="/images/resources/{$r.id}.gif" alt="{$res}" title="{$res}"> {$r.stored_str} ({$r.output_str}) {$r.abundance_str}%</td>
            {/if}
          {/foreach}
        </tr>
      </tbody>
    </table>
  </div>
  <div class="clear"></div>
</div>
{/foreach}
