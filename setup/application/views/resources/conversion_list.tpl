<h1>Cost of conversion for {$resource.name}</h1>

<p><a href="/setup/resources">Back to resources</a></p>

<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>Resource Name</th>
      <th>Quantity</th>
      <th>Refund</th>
    </tr>
  </thead>
  <tbody>

    <tr>
      <td colspan="7"><a href="/setup/resources/conversion/{$resource.id}/add">Add</a></td>
    </tr>

    {if $conversion}
      {foreach from=$conversion item=c}
        <tr>
          <td><a href="/setup/resources/conversion/{$resource.id}/edit/{$c.id}">Edit</a></td>
          <td><a href="/setup/resources/conversion/{$resource.id}/delete/{$c.id}">Delete</a></td>
          <td>{$c.name}</td>
          <td>{$c.qty}</td>
          <td>{$c.refund}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
