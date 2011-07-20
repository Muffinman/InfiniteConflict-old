<div class="content planet">
  <div class="planet-image">
    <img src="/images/planets/{$planet.type}.jpg" alt="{$planet.name}">
  </div>
  <div class="planet-info">
    <h1>{$planet.name}</h1>
    
    {foreach from=$resources item=r}

    {/foreach}
    
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>
