<h1>Starting Resource Editor</h1>

<p><a href="/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Stored</th>
      <th>Abundance</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td colspan="11"><a href="/start_resources/add">Add</a></td>
    </tr>

    {if $res}
      {foreach from=$res item=r}
        <tr>
          <td><a href="/start_resources/edit/{$r.resource_id}">Edit</a></td>
          <td><a href="/start_resources/delete/{$r.resource_id}">Delete</a></td>
          <td>{$r.name}</td>
          <td>{$r.stored}</td>
          <td>{$r.abundance}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
