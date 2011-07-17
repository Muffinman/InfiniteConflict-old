<h1>Research Editor</h1>

<p><a href="/setup/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Research Name</th>
      <th>Resources</th>
      <th>Prerequisites</th>
      <th>Creation Time</th>
      <th>Given</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="7"><a href="/research/add">Add</a></td>
    </tr>
    {if $research}
      {foreach from=$research item=r}
        <tr>
          <td><a href="/setup/research/edit/{$r.id}">Edit</a></td>
          <td><a href="/setup/research/delete/{$r.id}">Delete</a></td>
          <td>{$r.name}</td>
          <td><a href="/setup/research/resources/{$r.id}">Resources</a></td>
          <td><a href="/setup/research/research_preq/{$r.id}">Prereq</a></td>
          <td>{$r.turns}</td>
          <td>{if $r.given}Yes{else}No{/if}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
