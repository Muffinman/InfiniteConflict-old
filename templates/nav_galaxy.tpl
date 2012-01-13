<div class="content" id="nav">
  <h1>Navigation: <a href="/navigation">Universe</a> / Galaxy {$galaxy.id}</h1>
  <div class="galaxy">
    <ul class="nav sys">
      {foreach from=$systems item=s}
        <li class="sys{$s.type} {$s.status} col{$s.col}">
          <a href="/navigation/{$galaxy.id}/{$s.id}"><img src="/images/systems/{$s.type}.jpg" width="32" height="32"></a>
        </li>
      {/foreach}
    </ul>
    <div class="clear"></div>
  </div>
</div>
