<h1>Adding ship</h1>

<p><a href="/ships">Back to ships</a></p>

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
