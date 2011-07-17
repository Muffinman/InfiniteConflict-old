<h1>Ship Editor</h1>

<p><a href="/setup/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Ship Name</th>
      <th>Resources</th>
      <th colspan="2">Prerequisites</th>
      <th>Max Qty</th>
      <th>Creation Time</th>
      <th>Fleet Drive</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="9"><a href="/setup/ships/add">Add</a></td>
    </tr>
    {if $ships}
      {foreach from=$ships item=s}
        <tr>
          <td><a href="/setup/ships/edit/{$s.id}">Edit</a></td>
          <td><a href="/setup/ships/delete/{$s.id}">Delete</a></td>
          <td>{$s.name}</td>
          <td><a href="/setup/ships/resources/{$s.id}">Resources</a></td>
          <td><a href="/setup/ships/research_preq/{$s.id}">Research</a></td>
          <td><a href="/setup/ships/building_preq/{$s.id}">Buildings</a></td>
          <td>{if $s.max}{$s.max}{else}&#8734;{/if}</td>
          <td>{$s.turns}</td>
          <td>{$s.drive}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
