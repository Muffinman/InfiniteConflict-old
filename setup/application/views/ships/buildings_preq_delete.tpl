<h1>Deleting {$ship.name} prerequisites</h1>

<p><a href="/setup/ships/building_preq/{$ship.id}">Back to ship</a></p>

{if $messages}
  {foreach from=$messages key=type item=m}
    <div class="{$type}">
      {foreach from=$m item=message}
        <p>{$message}</p>
      {/foreach}
    </div>
  {/foreach}
{/if}
