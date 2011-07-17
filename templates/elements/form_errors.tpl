{if $form_err_help}
<ul id="form_errors">
	{foreach from=$form_err_help item=error}
	<li>{$error}</li>
	{/foreach}
</ul>
{/if}