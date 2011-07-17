<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>{$meta_title}</title>
  <link rel="stylesheet" type="text/css" href="/setup/css/main.css">
</head>
<body>

<div id="background">
  <div id="container">

    <ul id="menu">
      <li class="home"><a href="/setup/">Home</a></li>
      <li class="planets"><a href="">Planets</a></li>
      <li class="fleets"><a href="">Fleets</a></li>
      <li class="navigation"><a href="">Navigation</a></li>
      <li class="research"><a href="">Research</a></li>
      <li class="alliances"><a href="">Alliances</a></li>
    </ul>
    <div class="content headbar menu">
      <p>Welcome to the Infinite Conflict Game Editor</p>
    </div>

    <div class="content">
      {if $content}
        {$content}
      {/if}
    </div>

    <div class="content headbar">
      <p>Page rendered in {literal}{elapsed_time}{/literal} seconds</p>
    </div>
  </div>
  </div>

</body>
</html>
