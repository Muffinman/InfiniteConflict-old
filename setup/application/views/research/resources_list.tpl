<h1>{$research.name} resources</h1>

<p><a href="/setup/research">Back to research</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Resource Cost</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="9"><a href="/setup/research/resources/{$research.id}/add">Add</a></td>
    </tr>
    {if $resources}
      {foreach from=$resources item=r}
        <tr>
          <td><a href="/setup/research/resources/{$research.id}/edit/{$r.resource_id}">Edit</a></td>
          <td><a href="/setup/research/resources/{$research.id}/delete/{$r.resource_id}">Delete</a></td>
          <td>{$r.name}</td>
          <td>{$r.cost}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
