{if $alliance}

	<div class="content">
		<h1>{$alliance.name}</h1>
		<div class="tabs">
			<ul>
				<li><a href="/alliances/members">Members</a></li>
				<li><a href="/alliances/requests">Requests</a></li>
				<li><a href="/alliances/forums">Forums</a></li>
				<li><a href="/alliances/diplomacy">Diplomacy</a></li>
			</ul>
		</div>
	</div>
	
{else}	

	
	<div class="content joinAlliance right">
		<h1>Join An Alliance</h1>
		{if $alliances}
			<table class="alliance-list">
				<thead>
					<tr>
						<th>Alliance Name</th>
						<th>Members</th>
						<th>Score</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$alliances item=i}
						<tr>
							<td>{$a.name}</td>
							<td>{$a.members}</td>
							<td>{$a.score}</td>
						</tr>					
					{/foreach}
				</tbody>
			</table>
		{else}
			<p>There are currently no alliances, please try creating a new one instead!</p>
		{/if}
	</div>	

	<div class="content createAlliance left">
		<h1>Create New Alliance</h1>
		<form action="/alliances/create" method="post">
			<p>
				<label for="name">Alliance Name</label>
				<input type="text" name="name" id="name" value="" />
				<input type="submit" value="Create" />
			</p>
		</form>
	</div>

	
{/if}