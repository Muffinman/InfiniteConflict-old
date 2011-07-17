<h1>{$building.name} prerequisites</h1>

<p><a href="/setup/buildings">Back to research</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Prerequisite Name</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="2"><a href="/setup/buildings/research_preq/{$building.id}/add">Add</a></td>
    </tr>
    {if $prereq}
      {foreach from=$prereq item=p}
        <tr>
          <td><a href="/setup/buildings/research_preq/{$building.id}/delete/{$p.id}">Delete</a></td>
          <td>{$p.name}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
