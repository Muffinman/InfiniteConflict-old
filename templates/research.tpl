<div class="content queue">
  <h1>Research Queue</h1>
  {if $queue}
    <table class="reseach">
      <thead>
        <tr>
          <th>Name</th>
          <th>Turns</th>
          <th>Cost</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody>
        {foreach from=$queue item=r}
        <tr>
          <td>{$r.name}</td>
          <td>{$r.turns}</td>
          <td>{$r.resources.10.cost}</td>
          <td><a href="/ajax/research/queue/remove/{$r.hash}/">[x]</a></td>
        </tr>
        {/foreach}
      </tbody>
    </table>
  {/if}
</div>

<div class="content research">
  <form id="research-list" action="/ajax/research/queue/add/" method="post">
    <h1>Research</h1>
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
