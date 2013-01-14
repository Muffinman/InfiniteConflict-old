<div class="content" id="nav">
  <h1>Navigation: <a href="/navigation">Universe</a> / <a href="/navigation/{$galaxy.id}">Galaxy {$galaxy.id}</a> / System {$system.id}</h1>
  {if $system.previous}
  	<div class="prev"><a href="/navigation/{$galaxy.id}/{$system.previous}">&lt;</a></div>
  {/if}
  <div class="system">
    <ul class="nav planet">
      {foreach from=$planets item=p}
        <li class="planet{$p.type} {$p.status} col{$p.col}">
          {if $p.status == 'owned'}<a href="/planet/{$p.id}">{/if}
            <img src="/images/planets/{$p.type}.jpg" width="100" height="100">
            <span class="planet-id">{$p.id} {$p.name}</span>
            <span class="planet-ruler">{$p.ruler}</span>
            {if $p.alliance}
            	 <span class="planet-alliance">{$p.alliance}</span>
            {/if}
          {if $p.status == 'owned'}</a>{/if}
        </li>
      {/foreach}
    </ul>
    <div class="clear"></div>
  </div>
  {if $system.next}
  	<div class="next"><a href="/navigation/{$galaxy.id}/{$system.next}">&gt;</a></div>
  {/if}
</div>
