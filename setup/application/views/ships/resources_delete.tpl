<h1>Deleting {$ship.name} resource cost</h1>

<p><a href="/setup/ship/resources/{$ship.id}">Back to ship</a></p>

{if $messages}
  {foreach from=$messages key=type item=m}
    <div class="{$type}">
      {foreach from=$m item=message}
        <p>{$message}</p>
      {/foreach}
    </div>
  {/foreach}
{/if}
