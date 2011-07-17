<h1>Resource Editor</h1>

<p><a href="/setup/">Back to home</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Hit Points</th>
      <th>Attack Points</th>
      <th>Creatable</th>
      <th>Creation Time</th>
      <th>Interest Rate</th>
      <th>Requires Storage</th>
      <th>Global</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td colspan="11"><a href="/setup/resources/add">Add</a></td>
    </tr>

    {if $res}
      {foreach from=$res item=r}
        <tr>
          <td><a href="/setup/resources/edit/{$r.id}">Edit</a></td>
          <td><a href="/setup/resources/delete/{$r.id}">Delete</a></td>
          <td>{if $r.creatable}<a href="/setup/resources/conversion/{$r.id}">Conversion</a>{/if}</td>
          <td>{$r.name}</td>
          <td>{$r.hp}</td>
          <td>{$r.attack}</td>
          <td>{$r.creatable}</td>
          <td>{$r.turns}</td>
          <td>{$r.interest}</td>
          <td>{$r.req_storage}</td>
          <td>{$r.global}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
