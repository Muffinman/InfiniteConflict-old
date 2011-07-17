<h1>Adding {$resource.name} conversion cost</h1>

<p><a href="/setup/resources/conversion/{$resource.id}">Back to resource</a></p>

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
