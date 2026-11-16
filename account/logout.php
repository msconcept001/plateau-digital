<?php
require_once __DIR__.'/../includes/account.php';if(!empty($_SESSION['user_id']))account_log((int)$_SESSION['user_id'],'Signed out');unset($_SESSION['user_id']);session_regenerate_id(true);header('Location: login.php');exit;
