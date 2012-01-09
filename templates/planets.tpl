<div class="planet-list">
	
	{foreach from=$planets item=planet name=planets}
	<div class="content planet {if $smarty.foreach.planets.index % 2 == 0}odd{else}even{/if}">
	  <div class="planet-image">
	    <a href="/planet/{$planet.id}"><img src="/images/planets/{$planet.type}.jpg" alt="{$planet.name}"></a>
	  </div>
	
	  <div class="planet-info">
	    <h1>{$planet.name}</h1>
	
	    <p class="static-resources">
	      {foreach from=$planet.resources key=res item=r}
	        {if !$r.net_output && !$r.global}
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
	            {if $r.net_output}
	              <td class="resource{$r.id} nopadding"><img src="/images/resources/{$r.id}.gif" alt="{$res}" title="{$res}"> {$r.stored_str} ({$r.output_str}) {$r.abundance_str}%</td>
	            {/if}
	          {/foreach}
	        </tr>
	      </tbody>
	    </table>
	    
	    <ul class="building">
	    	<li><a href="/planet/{$planet.id}">Building:</a> {if $planet.building.0}{$planet.building.0.name} ({$planet.building.0.turns} turns){else}None{/if}</li>
	    	<li><a href="/planet/{$planet.id}/production">Production:</a> {if $planet.production.0}{$planet.production.0.qty}x {$planet.production.0.name} ({$planet.production.0.turns} turns){else}None{/if}</li>
	    	<li><a href="/planet/{$planet.id}/training">Training:</a> {if $planet.training.0}{$planet.training.0.qty}x {$planet.training.0.name} ({$planet.training.0.turns} turns){else}None{/if}</li>	    
	    </ul>
	    
	    {if $planet.fleets}
	    	<p class="fleets"></p>
	    {/if}
	    
	  </div>
	  <div class="clear"></div>
	</div>
	{/foreach}
	
</div>