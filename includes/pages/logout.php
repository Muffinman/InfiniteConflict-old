<?
$q = "DELETE FROM session WHERE ruler_id='" . $db->esc($_SESSION['ruler']['id']) . "' AND session_id='" . $db->esc($_COOKIE[COOKIE_NAME]) . "'";
$db->Edit($q);

setcookie(COOKIE_NAME, 'destroyed', time()-3600, '/');
setcookie('PHPSESSID', 'destroyed', time()-3600, '/');


session_unset();
session_destroy();
unset($_SESSION);

session_regenerate_id(true);

header('Location: /');
?>
