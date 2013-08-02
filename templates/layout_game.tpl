<!doctype html>
<html lang="en">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{$title}</title>
    <meta name="description" content="{$description}">
    <meta name="keywords" content="{$keywords}">
    <meta name="author" content="Matt Jones">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="/styles.css">
    <link href='http://fonts.googleapis.com/css?family=Play:400,700&v2' rel='stylesheet' type='text/css'>
    <script  type="text/javascript" src="/scripts.js"></script>

    <script type="text/javascript">
	    var update_next = {$time_till_update};
	    var update_interval = {$config.turn_length};
    </script>

  </head>
  <!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
  <!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
  <!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
  <!--[if (gt IE 8)|!(IE)]><!--> <body> <!--<![endif]-->
    
    <div id="ajax">
      <img alt="Loading... Please wait." src="/images/ajax.gif">
    </div>

    <div id="logo">
      <h1>Infinite<span>Conflict</span></h1>
      <h2>The Alpha approaches...</h2>
    </div>

    <div id="userbox">
      <p class="avatar"><img src="{$ruler.avatar}" alt="{$ruler.name}"></p>
      <p>{$ruler.name} <a href="/logout">[Logout]</a> - Turn : <a href="/turns" id="turn_counter">{$config.turn}</a> {$smarty.now|date_format:"%H:%M %Z"}</p>
      <p class="messages"><a href="/messages">Messages</a></p>
      <p class="news"><a href="/news">News</a></p>
      <p class="ql" title="Researched Queue Length">QL: {$ruler.QL}</p>
      <p class="pl" title="Researched Planet Limit">PL: {$ruler.PL}</p>
    </div>


    <div id="outer">
      <div id="container">

        <ul id="menu">
          <li class="home{if $request.0 == ''} active{/if}"><a href="/"><span>Home</span></a></li>
          <li class="planets{if $request.0 == 'planets' || $request.0 == 'planet'} active{/if}"><a href="/planets"><span>Planets</span></a></li>
          <li class="fleets{if $request.0 == 'fleets' || $request.0 == 'fleet'} active{/if}"><a href="/fleets"><span>Fleets</span></a></li>
          <li class="navigation{if $request.0 == 'navigation'} active{/if}"><a href="/navigation"><span>Nav</span></a></li>
          <li class="research{if $request.0 == 'research'} active{/if}"><a href="/research"><span>Research</span></a></li>
          <li class="alliances{if $request.0 == 'alliances'} active{/if}"><a href="/alliances"><span>Alliances</span></a></li>
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
            <p>Page generated in {$page_time}s ({$page_query_time}s database). {$page_queries} Queries. Next update in <span id="update_next">{$time_till_update}</span>s.</p>
          </div>
        </div>
      </div>
    </div>
	</body>
</html>
