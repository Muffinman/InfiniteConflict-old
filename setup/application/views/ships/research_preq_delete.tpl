<h1>Deleting {$ship.name} prerequisites</h1>

<p><a href="/setup/ships/research_preq/{$ship.id}">Back to ships</a></p>

{if $messages}
  {foreach from=$messages key=type item=m}
    <div class="{$type}">
      {foreach from=$m item=message}
        <p>{$message}</p>
      {/foreach}
    </div>
  {/foreach}
{/if}
