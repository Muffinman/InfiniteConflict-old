<h1>{$building.name} resources</h1>

<p><a href="/buildings">Back to buildings</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Construction Cost</th>
      <th>Output</th>
      <th>Stores</th>
      <th>Interest</th>
      <th>Abundance</th>
      <th>Refund</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="9"><a href="/buildings/resources/{$building.id}/add">Add</a></td>
    </tr>
    {if $resources}
      {foreach from=$resources item=r}
        <tr>
          <td><a href="/buildings/resources/{$building.id}/edit/{$r.resource_id}">Edit</a></td>
          <td><a href="/buildings/resources/{$building.id}/delete/{$r.resource_id}">Delete</a></td>
          <td>{$r.name}</td>
          <td>{$r.cost}</td>
          <td>{$r.output}</td>
          <td>{$r.stores}</td>
          <td>{$r.interest}</td>
          <td>{$r.abundance}</td>
          <td>{$r.refund}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
