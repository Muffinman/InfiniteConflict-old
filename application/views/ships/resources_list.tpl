<h1>{$ship.name} resources</h1>

<p><a href="/ships">Back to ships</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Construction Cost</th>
      <th>Storage</th>
      <th>Refund</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="9"><a href="/ships/resources/{$ship.id}/add">Add</a></td>
    </tr>
    {if $resources}
      {foreach from=$resources item=r}
        <tr>
          <td><a href="/ships/resources/{$ship.id}/edit/{$r.resource_id}">Edit</a></td>
          <td><a href="/ships/resources/{$ship.id}/delete/{$r.resource_id}">Delete</a></td>
          <td>{$r.name}</td>
          <td>{$r.cost}</td>
          <td>{$r.storage}</td>
          <td>{$r.refund}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
