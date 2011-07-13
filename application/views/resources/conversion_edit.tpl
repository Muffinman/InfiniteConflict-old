<h1>Editing {$resource.name} {$conversion.name} conversion costs</h1>

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

{if $errors}
  {$errors}
{/if}
{$form}
