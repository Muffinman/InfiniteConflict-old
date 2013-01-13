<?php

/*
 * This minifier can accept PHP files for dynamic CSS/JS but it's strongly advised
 * that these are included in their own request so all static content can be saved into
 * a cache file and the client can also cache it properly.
 */


FB::setEnabled(false);

FB::log($scripts);


/*
 * Check for cached file
 */ 
$create_new_cache = true;

if ($cache_dir) {
	$cache_filename = $cache_dir . $request[0];
} else {
	$cache_filename = SITE_ROOTPATH . 'templates_c/' . $request[0];
}

if (file_exists($cache_filename)) {
	$create_new_cache = false;
	$cache_update = filemtime($cache_filename);
	FB::log(date('r', $cache_update), 'Cache updated');
}

/*
 * Check for changes since the last cached version (PHP scripts always force a rebuild)
 */
$use_cache = true;
$last_update = 0;
foreach ($scripts as $file) {
	if (preg_match('/\.php$/i', $file)) {
		$use_cache = false;
		$create_new_cache = false;
	} else {
		if (filemtime($file) > $cache_update) {
			$use_cache = false;
			$create_new_cache = true;
		}
	}
}
FB::log($use_cache, 'Use existing cache');
FB::log($create_new_cache, 'Create new cache file');

// content type
$content_type = $minify_method == 'css' ? 'text/css' : 'application/javascript';

/*
 * Compile output (will optionally be saved to cache)
 */
if (!$use_cache) {

	if ($minify_method == 'css') {
		require_once 'cssmin.class.php';
	} else {
		require_once 'jsmin.class.php';
	}
	
	$output = '';
	foreach ($scripts as $file) {
		$t = '';
		if (preg_match('/\.php$/i', $file)) {
			ob_start();
			include $file;
			$t = ob_get_contents() . "\r\n";
			ob_end_clean();
			$t = $minify_method == 'css' ? CssMin::minify($t) : JSMin::minify($t);
		} else if (preg_match('/(\.|-)min\./i', $file)) {
			$t = file_get_contents($file) . "\r\n";
		} else {
			$t = file_get_contents($file) . "\r\n";
			$t = $minify_method == 'css' ? CssMin::minify($t) : JSMin::minify($t);
		}
		$output .= $t;
	}
	
	// write new cache?
	if ($create_new_cache) {
		$fp = fopen($cache_filename, 'w');
		fwrite($fp, $output . "\r\n");
		fclose($fp);
	} else {
		// output newly minified version (with no cache rules) then stop so it doesn't handle the cache file
		FB::log('Dumping dynamic content');
		header("Last-Modified: " . gmdate('D, d M Y H:i:s') . " GMT", true);
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT', true);
		header("Cache-Control: max-age=" . 0, true);
		header("Vary: Accept-Encoding", true);
		header("Content-Length: " . strlen($output), true);
		header('Content-type: ' . $content_type, true); 
		echo $output;
		exit();
	}
	unset($output);
}

$expires = 60 * 60 * 24;
$mtime = filemtime($cache_filename);
$etag = md5_file($cache_filename); 

header("Last-Modified: " . gmdate('D, d M Y H:i:s', $mtime) . " GMT", true);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT', true);
header("Etag: ".$etag, true); 
header("Cache-Control: max-age=" . $expires, true);

// don't sent data the browser doesn't need
FB::log($_SERVER['HTTP_IF_MODIFIED_SINCE'], 'HTTP_IF_MODIFIED_SINCE');
FB::log($_SERVER['HTTP_IF_NONE_MATCH'], 'HTTP_IF_NONE_MATCH');
if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $mtime || trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag) { 
	FB::log('Browser already has a cached copy so I\'m not sending it again.');
	header($_SERVER["SERVER_PROTOCOL"]." 304 Not Modified", true, 304);
	exit();
}

header("Vary: Accept-Encoding", true);
header("Content-Length: " . filesize($cache_filename), true);
header('Content-type: ' . $content_type, true); 
FB::log($cache_filename, 'Loading saved cache');
readfile($cache_filename); 
exit();