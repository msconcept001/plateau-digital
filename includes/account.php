<?php
require_once __DIR__.'/functions.php';
function account_schema(): void {
 $pdo=db();
 $pdo->exec("CREATE TABLE IF NOT EXISTS user_accounts (id INT AUTO_INCREMENT PRIMARY KEY, full_name VARCHAR(150) NOT NULL, email VARCHAR(190) NOT NULL UNIQUE, phone VARCHAR(40) NULL, password VARCHAR(255) NOT NULL, account_type ENUM('business','talent','student','customer') NOT NULL DEFAULT 'customer', status ENUM('active','suspended') NOT NULL DEFAULT 'active', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
 $pdo->exec("CREATE TABLE IF NOT EXISTS account_activity (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, activity VARCHAR(255) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, INDEX(user_id), FOREIGN KEY(user_id) REFERENCES user_accounts(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}
function account_user(): ?array { if(empty($_SESSION['user_id'])) return null; $st=db()->prepare('SELECT id,full_name,email,phone,account_type,status FROM user_accounts WHERE id=?');$st->execute([$_SESSION['user_id']]);$u=$st->fetch();return $u?:null; }
function require_account(): array { $u=account_user();if(!$u){header('Location: login.php');exit;}if($u['status']!=='active'){session_destroy();exit('Your account is currently suspended. Please contact support.');}return $u; }
function account_log(int $id,string $activity): void {$st=db()->prepare('INSERT INTO account_activity(user_id,activity) VALUES(?,?)');$st->execute([$id,$activity]);}
