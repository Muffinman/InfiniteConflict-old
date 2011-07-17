<h1>{$building.name} prerequisites</h1>

<p><a href="/setup/buildings">Back to buildings</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Prerequisite Name</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="2"><a href="/buildings/buildings_preq/{$building.id}/add">Add</a></td>
    </tr>
    {if $prereq}
      {foreach from=$prereq item=p}
        <tr>
          <td><a href="/buildings/buildings_preq/{$building.id}/delete/{$p.id}">Delete</a></td>
          <td>{$p.name}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
