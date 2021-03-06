<h1>Starting Building Editor</h1>

<p><a href="/setup/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Building Name</th>
      <th>Qty</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td colspan="11"><a href="/setup/start_buildings/add">Add</a></td>
    </tr>

    {if $buildings}
      {foreach from=$buildings item=b}
        <tr>
          <td><a href="/setup/start_resources/edit/{$b.building_id}">Edit</a></td>
          <td><a href="/setup/start_resources/delete/{$b.building_id}">Delete</a></td>
          <td>{$b.name}</td>
          <td>{$b.qty}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
