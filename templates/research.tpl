<div class="content queue">
  <h1>Research Queue</h1>
    <table class="reseach" id="research-queue"{if !$queue} style="display:none;"{/if}>
      <thead>
        <tr>
          <th class="name">Name</th>
          <th class="turns">Turns</th>
          <th class="status">Status</th>
          <th class="remove">Remove</th>
        </tr>
      </thead>
      <tbody>
        {if $queue}
          {foreach from=$queue item=r name=queue}
            <tr>
              <td>{$r.name}</td>
              <td>{if $r.turns_left}{$r.turns_left}{else}{$r.turns}{/if}</td>
              <td>{if $r.started == 1}Started{else}{if $smarty.foreach.queue.first}Starting{else}Queued{/if}{/if}</td>
              <td class="remove">{if !$r.started}<a href="/ajax/research/queue/remove/{$r.hash}/">[x]</a>{/if}</td>
            </tr>
          {/foreach}
        {/if}
      </tbody>
    </table>

  <div class="empty-queue"{if $queue} style="display:none"{/if}>
    <p>You do not have any research in the queue</p>
  </div>

</div>

<div class="content research">
  <form id="research-list" action="/ajax/research/queue/add/" method="post">
    <h1>Research <span style="float:right;">{$ruler.resources.0.qty|number_format:0:"":","} {$ruler.resources.0.name}</span></h1>
    {if $research}
      <table class="reseach">
        <thead>
          <tr>
            <th class="name">Name</th>
            <th class="turns">Turns</th>
            <th class="cost">Cost</th>
            <th class="queue"></th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$research item=r}
            <tr>
              <td class="name">{$r.name}</td>
              <td class="turns">{$r.turns}</td>
              <td class="cost">{$r.resources.10.cost}</td>
              <td><input type="radio" name="research" value="{$r.id}" /></td>
            </tr>
          {/foreach}
        </tbody>
      </table>
      
      <p><input type="submit" value="Queue" /></p>
    {/if}
  </form>
  <div class="clear"></div>
</div>
