<?

$db->Edit("DELETE FROM session WHERE ruler_id='" . $db->esc($_SESSION['ruler_id']) . "' AND session_id='" . $db->esc($_COOKIE[COOKIE_NAME]) . "'");

setcookie(COOKIE_NAME, '', time()-3600, '/');
session_destroy();
unset($_SESSION);
header('Location: /');
?>
