<h1>Deleting {$resource.name} conversion cost</h1>

<p><a href="/resources/conversion/{$resource.id}">Back to resource</a></p>

{if $messages}
  {foreach from=$messages key=type item=m}
    <div class="{$type}">
      {foreach from=$m item=message}
        <p>{$message}</p>
      {/foreach}
    </div>
  {/foreach}
{/if}

<p><a href="/resources/conversion/{$resource.id}">Click here</a> to return to the conversion list.</p>
