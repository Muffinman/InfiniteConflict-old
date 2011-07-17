<h1>Deleting {$building.name} prerequisites</h1>

<p><a href="/setup/buildings/research_preq/{$building.id}">Back to buildings</a></p>

{if $messages}
  {foreach from=$messages key=type item=m}
    <div class="{$type}">
      {foreach from=$m item=message}
        <p>{$message}</p>
      {/foreach}
    </div>
  {/foreach}
{/if}
