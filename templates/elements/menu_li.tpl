<li{if $p.active} class="active"{/if}>
  <a href="{$site_url}{if $p.urlname != 'home'}{$p.urlname}/{/if}">{$p.reference}</a>
  {if $p.children}
    <ul>
      {foreach from=$p.children item=p}
        {include file='elements/menu_li.tpl'}
      {/foreach}
    </ul>
  {/if}
  
  {if $p.urlname == 'shop'}
    <ul class="cats">
      <li{if $browse == 'brands'} class="active"{/if}><a href="/shop/brands">BRANDS</a></li>
      <li{if $browse == 'categories'} class="active"{/if} style="margin-bottom:20px;"><a href="/shop/categories">CATEGORIES</a></li>
      
      {if $browse == 'categories'}
        {foreach from=$cat_menu item=p}
          {include file='elements/menu_li.tpl'}
        {/foreach}
      {/if}

      {if $browse == 'brands'}
        {foreach from=$brand_menu item=p}
          {include file='elements/menu_li.tpl'}
        {/foreach}
      {/if}
      
    </ul>  
  {/if}

  {if $p.urlname == 'training'}
    <ul class="training">
      {foreach from=$training_menu item=p}
        {include file='elements/menu_li.tpl'}
      {/foreach}
    </ul>  
  {/if}

</li>
