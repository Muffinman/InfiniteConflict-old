<h1>Building Editor</h1>

<p><a href="/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Building Name</th>
      <th>Resources</th>
      <th colspan="2">Prerequisites</th>
      <th>Max Qty</th>
      <th>Creation Time</th>
      <th>Demolish</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="7"><a href="/buildings/add">Add</a></td>
    </tr>
    {if $buildings}
      {foreach from=$buildings item=b}
        <tr>
          <td><a href="/buildings/edit/{$b.id}">Edit</a></td>
          <td><a href="/buildings/delete/{$b.id}">Delete</a></td>
          <td>{$b.name}</td>
          <td><a href="/buildings/resources/{$b.id}">Resources</a></td>
          <td><a href="/buildings/buildings_preq/{$b.id}">Buildings</a></td>
          <td><a href="/buildings/research_preq/{$b.id}">Research</a></td>
          <td>{if $b.max}{$b.max}{else}&#8734;{/if}</td>
          <td>{$b.turns}</td>
          <td>{if $b.demolish}Yes: {$b.demolish}{else}No{/if}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
