<h1>Editing {$research.name}</h1>

<p><a href="/research">Back to research</a></p>

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
