<h1>{$research.name} prerequisites</h1>

<p><a href="/research">Back to research</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Prerequisite Name</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="2"><a href="/research/research_preq/{$research.id}/add">Add</a></td>
    </tr>
    {if $prereq}
      {foreach from=$prereq item=p}
        <tr>
          <td><a href="/research/research_preq/{$research.id}/delete/{$p.id}">Delete</a></td>
          <td>{$p.name}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
