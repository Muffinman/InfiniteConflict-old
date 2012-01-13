<div class="content" id="nav">
  <h1>Navigation: Universe</h1>
  <div id="nav" class="universe">
    <ul class="nav gal">
      {foreach from=$galaxies item=g}
        <li class="gal{$g.type} {$g.status}">
          <a href="/navigation/{$g.id}"><img src="/images/galaxies/{$g.type}.jpg" width="100" height="100"></a>
        </li>
      {/foreach}
    </ul>
    <div class="clear"></div>
  </div>
</div>
