<h1>Adding research</h1>

<p><a href="/setup/research">Back to research</a></p>

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
