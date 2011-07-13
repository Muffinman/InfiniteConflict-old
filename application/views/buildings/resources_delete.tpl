<h1>Deleting {$building.name} resource cost</h1>

<p><a href="/buildings/resources/{$building.id}">Back to building</a></p>

{if $messages}
  {foreach from=$messages key=type item=m}
    <div class="{$type}">
      {foreach from=$m item=message}
        <p>{$message}</p>
      {/foreach}
    </div>
  {/foreach}
{/if}
