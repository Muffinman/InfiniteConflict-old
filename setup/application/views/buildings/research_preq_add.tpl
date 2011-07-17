<h1>Adding {$building.name} prerequisite</h1>

<p><a href="/setup/buildings/research_preq/{$building.id}">Back to building prerequisites</a></p>

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
