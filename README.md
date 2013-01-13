InfiniteConflict
================

Tick Based Strategy Game

Idea
----

The principle of IC was born from a project called [TurnEngine](http://www.turnengine.com/forums/). Who's creators, although very talented, had little idea of how to complete a project in a timely fasion, or keep their user base happy.

TurnEngine attempted to remove the compexity from creating a turn (actually 'tick') based stategy game, by creating a layer of abstraction below the game code, which handled all the common tasks that any tick based game might want to perform. Requring the game designer to merely define the units/structures, and generate set of rules and boundries within the game to operate in.

Using this technique they rebuilt their already popular game [DarkGalaxy](http://www.darkgalaxy.com) on top of TurnEngine, and to great success ran 5 or 6 rounds of the game on this code. At it's peak the game had about 30000 players, of which maybe 10000 were active.

Unfortunately the developers gave up on the project claiming that it was too difficult to maintain and too time consuming to administate the game. Even though numerous community members, including myself, offered to help both admin the game and develop the code, all offers were rejected and the game was closed down indefinitely.

Recently the developers have restarted the project, unfortunately it still suffers from the same issues as before; lack of activity and lack of letting the community help.

IC was started with the same concept, allow users to create great games with minimum effort, by writing a core code and allowing developers to either integrate directly with it, or extend it to suit their needs.

This example game is a clone of the original DarkGalaxy game concept, with some much needed improvements and modifications, built on top of the ICEngine.

System Requirements
-------------------

Apache 2 (other web servers will work providing you convert the supplied .htaccess file to work with your webserver)
PHP 5.3
MySQL 5

Newer versions of the above will work, these are just the minimum.

Directory Structure
-------------------

* **css/** - Stylesheets go here, new ones will also require an entry in index.php in order to be cached and minified
* **images/**
* **includes/** - Libraries and main codebase
* **includes/ajax/** - all /ajax/[scriptName] requests call files in this folder with [scriptName]
* **includes/classes/** - all libraries and class files here
* **includes/pages/** - all /[scriptName] requests will call the file named [scriptName] in this folder
* **js/** - Javascript files go here, new ones will also require an entry in index.php in order to be cached and minified
* **originals/** - Should be here, to be deleted
* **setup/** - This is a little test site I created to setup/modify the game config. It is built on CodeIgniter.
* **templates/** - All smarty template files here
* **templates_c/** - All template cache files here, including cached/minified styles.css and scripts.js files.

Development Hints
-----------------

This code makes use of FirePHP to log various data to the Firebug console. In order to make use of this, you will need Firefox, the Firebug addon, and either Developer Companion addon or the FirePHP addon installed. I recommend the Developer Companion addon as it provides a tider interface for displaying the logged messages.

Areas of Active Development
--------------------------

* Alliances *in progress*
* Combat
* News
* Messaging
