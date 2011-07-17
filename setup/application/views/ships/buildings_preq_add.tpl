<h1>Adding {$ship.name} prerequisite</h1>

<p><a href="/setup/ships/building_preq/{$ship.id}">Back to ship prerequisites</a></p>

{if $messages}
  {foreach from=$messages key=type item=m}
    <div class="{$type}">
      {foreach from=$m item=message}
        <p>{$message}</p>
      {/foreach}
    </div>
  {/foreach}
{/if}

{if $errors}
  {$errors}
{/if}
{$form}
