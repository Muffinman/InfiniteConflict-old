<!doctype html>
<html lang="en">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{$meta_title}</title>
    <meta name="description" content="{$description}">
    <meta name="keywords" content="{$keywords}">
    <meta name="author" content="Matt Jones">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="/css/styles.css.php?p={$request.0}">
    <link href='http://fonts.googleapis.com/css?family=Play:400,700&v2' rel='stylesheet' type='text/css'>
    <script src="/js/scripts.js.php?p={$request.0}"></script>

  </head>
  <!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
  <!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
  <!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
  <!--[if (gt IE 8)|!(IE)]><!--> <body> <!--<![endif]-->

    <img id="background" alt="" src="/images/background.jpg">
    <div id="ajax">
      <img alt="Loading... Please wait." src="/images/ajax.gif">
    </div>

    <div id="logo">
      <h1>Infinite<span>Conflict</span></h1>
      <h2>The Alpha approaches...</h2>
    </div>

    <div id="userbox">
      <p class="avatar"><img src="{$ruler.avatar}" alt="{$ruler.name}"></p>
      <p>{$ruler.name} <a href="/logout">[Logout]</a> - Turn : <a href="/turns">{$config.turn}</a> {$smarty.now|date_format:"%H:%M %Z"}</p>
      <p class="messages"><a href="/messages">Messages</a></p>
      <p class="news"><a href="/news">News</a></p>
      <p class="ql" title="Researched Queue Length">QL: {$ruler.QL}</p>
      <p class="pl" title="Researched Planet Limit">PL: {$ruler.PL}</p>
    </div>


    <div id="outer">
      <div id="container">

        <ul id="menu">
          <li class="home"><a {if $request.0 == ''}class="active" {/if}href="/">Home</a></li>
          <li class="planets"><a {if $request.0 == 'planets' || $request.0 == 'planet'}class="active" {/if}href="/planets">Planets</a></li>
          <li class="fleets"><a {if $request.0 == 'fleets'}class="active" {/if}href="/fleets">Fleets</a></li>
          <li class="navigation"><a {if $request.0 == 'navigation'}class="active" {/if}href="/navigation">Navigation</a></li>
          <li class="research"><a {if $request.0 == 'research'}class="active" {/if}href="/research">Research</a></li>
          <li class="alliances"><a {if $request.0 == 'alliances'}class="active" {/if}href="/alliances">Alliances</a></li>
        </ul>


        <div class="lower-content">
          <div class="content headbar menu">
            <!-- <p>Welcome to Infinite Conflict</p> -->
          </div>


          {if $content}
            {$content}
          {/if}
          <div class="clear"></div>

          <div class="content headbar footer">
            <p>Page generated in {$page_time}s ({$page_query_time}s database).</p>
          </div>
        </div>
      </div>
    </div>
	</body>
</html>
