<h1>Starting Resource Editor</h1>

<p><a href="/setup/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th colspan="3">&nbsp;</th>
      <th colspan="4">Home Gals</th>
      <th colspan="4">Free Gals</th>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Min Stored</th>
      <th>Max Stored</th>
      <th>Min Abundance</th>
      <th>Max Abundance</th>
      <th>Min Stored</th>
      <th>Max Stored</th>
      <th>Min Abundance</th>
      <th>Max Abundance</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td colspan="11"><a href="/setup/gal_resources/add">Add</a></td>
    </tr>

    {if $res}
      {foreach from=$res item=r}
        <tr>
          <td><a href="/setup/gal_resources/edit/{$r.resource_id}">Edit</a></td>
          <td><a href="/setup/gal_resources/delete/{$r.resource_id}">Delete</a></td>
          <td>{$r.name}</td>
          <td>{$r.home_min_stored}</td>
          <td>{$r.home_max_stored}</td>
          <td>{$r.home_min_abundance}</td>
          <td>{$r.home_max_abundance}</td>
          <td>{$r.free_min_stored}</td>
          <td>{$r.free_max_stored}</td>
          <td>{$r.free_min_abundance}</td>
          <td>{$r.free_max_abundance}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
