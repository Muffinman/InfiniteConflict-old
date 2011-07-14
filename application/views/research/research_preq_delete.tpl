<h1>Deleting {$research.name} prerequisites</h1>

<p><a href="/research/research_preq/{$research.id}">Back to research</a></p>

{if $messages}
  {foreach from=$messages key=type item=m}
    <div class="{$type}">
      {foreach from=$m item=message}
        <p>{$message}</p>
      {/foreach}
    </div>
  {/foreach}
{/if}
