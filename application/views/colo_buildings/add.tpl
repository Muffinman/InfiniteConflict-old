<h1>Adding colonisation building</h1>

<p><a href="/colo_buildings">Back to buildings</a></p>

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