{include file="alliances.tpl"}

{if $alliance}
	<div class="content">
		<h1>Alliance Members</h1>
		<ul>	
			{foreach from=$members item=m}
				<li>{$m.name}</li>
			{/foreach}
		</ul>
	</div>
{/if}