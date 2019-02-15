<?php
session_start();


if(!$_SESSION) {
	header("Location: login.php");
}
?>
<p>your login was successful!</p>