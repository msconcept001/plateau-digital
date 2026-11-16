<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__.'/../config/database.php';
function e($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function url($path=''){ return ($path ? ltrim($path,'/') : ''); }
function logged_in(){ return !empty($_SESSION['admin_id']); }
function require_admin(){ if(!logged_in()){ header('Location: login.php'); exit; } }
function flash($message=null){ if($message!==null){ $_SESSION['flash']=$message; return; } $m=$_SESSION['flash']??''; unset($_SESSION['flash']); return $m; }
function csrf_token(){ if(empty($_SESSION['csrf_token'])) $_SESSION['csrf_token']=bin2hex(random_bytes(32)); return $_SESSION['csrf_token']; }
function verify_csrf(){ $token=$_POST['csrf_token']??''; if(!is_string($token)||!hash_equals(csrf_token(),$token)){ http_response_code(419); exit('Your session token expired. Please go back, refresh the page and try again.'); } }
function slugify($text){ $text=iconv('UTF-8','ASCII//TRANSLIT//IGNORE',(string)$text); $text=preg_replace('/[^a-zA-Z0-9]+/','-',strtolower($text)); return trim($text,'-') ?: 'item'; }
function unique_slug(PDO $pdo,string $table,string $text,?int $excludeId=null){ $base=slugify($text); $slug=$base; $n=2; while(true){ $sql="SELECT id FROM `$table` WHERE slug=?"; $args=[$slug]; if($excludeId){$sql.=' AND id<>?';$args[]=$excludeId;} $st=$pdo->prepare($sql);$st->execute($args); if(!$st->fetch()) return $slug; $slug=$base.'-'.$n++; } }
