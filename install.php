<?php
$host='127.0.0.1'; $dbname='plateau_digital'; $user='root'; $pass=''; $error=''; $success=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
 $host=trim($_POST['db_host']??$host); $dbname=trim($_POST['db_name']??$dbname); $user=trim($_POST['db_user']??$user); $pass=$_POST['db_pass']??'';
 $admin=trim($_POST['admin_name']??''); $email=trim($_POST['admin_email']??''); $password=$_POST['admin_password']??'';
 try{
  $pdo=new PDO("mysql:host=$host;charset=utf8mb4",$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
  $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
  $pdo->exec("USE `$dbname`");
  $sql=[
  "CREATE TABLE IF NOT EXISTS admins(id INT AUTO_INCREMENT PRIMARY KEY, full_name VARCHAR(150) NOT NULL,email VARCHAR(190) NOT NULL UNIQUE,password VARCHAR(255) NOT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB",
  "CREATE TABLE IF NOT EXISTS business_categories(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100) NOT NULL,slug VARCHAR(120) NOT NULL UNIQUE,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB",
  "CREATE TABLE IF NOT EXISTS businesses(id INT AUTO_INCREMENT PRIMARY KEY,category_id INT NULL,business_name VARCHAR(180) NOT NULL,slug VARCHAR(200) NOT NULL UNIQUE,description TEXT,phone VARCHAR(40),whatsapp VARCHAR(40),email VARCHAR(190),address VARCHAR(255),city VARCHAR(100) DEFAULT 'Jos',state VARCHAR(100) DEFAULT 'Plateau',website VARCHAR(190),logo VARCHAR(255),status ENUM('pending','approved','rejected') DEFAULT 'pending',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(category_id) REFERENCES business_categories(id) ON DELETE SET NULL) ENGINE=InnoDB",
  "CREATE TABLE IF NOT EXISTS talent_profiles(id INT AUTO_INCREMENT PRIMARY KEY,full_name VARCHAR(150) NOT NULL,email VARCHAR(190),headline VARCHAR(180),skills TEXT,portfolio_url VARCHAR(255),location VARCHAR(150),status ENUM('pending','published') DEFAULT 'pending',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB",
  "CREATE TABLE IF NOT EXISTS courses(id INT AUTO_INCREMENT PRIMARY KEY,title VARCHAR(180) NOT NULL,slug VARCHAR(200) NOT NULL UNIQUE,description TEXT,instructor VARCHAR(150),delivery ENUM('online','physical','hybrid') DEFAULT 'online',price DECIMAL(10,2) DEFAULT 0,status ENUM('draft','published') DEFAULT 'draft',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB",
  "CREATE TABLE IF NOT EXISTS service_requests(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(150) NOT NULL,email VARCHAR(190),phone VARCHAR(40),service VARCHAR(150),message TEXT,status ENUM('new','in_progress','completed') DEFAULT 'new',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB",
  "CREATE TABLE IF NOT EXISTS contact_messages(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(150),email VARCHAR(190),subject VARCHAR(180),message TEXT,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB"
  ]; foreach($sql as $q)$pdo->exec($q);
  $count=(int)$pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn();
  if(!$count){ if(!$admin||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($password)<8) throw new Exception('Enter an admin name, valid email and password of at least 8 characters.'); $st=$pdo->prepare('INSERT INTO admins(full_name,email,password) VALUES(?,?,?)');$st->execute([$admin,$email,password_hash($password,PASSWORD_DEFAULT)]); }
  $cfg="<?php
define('APP_NAME','Plateau Digital');
define('BASE_URL','');
define('DB_HOST',".var_export($host,true).");
define('DB_NAME',".var_export($dbname,true).");
define('DB_USER',".var_export($user,true).");
define('DB_PASS',".var_export($pass,true).");
";
  if(!is_dir(__DIR__.'/config'))mkdir(__DIR__.'/config',0755,true);file_put_contents(__DIR__.'/config/config.php',$cfg);
  $success=true;
 }catch(Throwable $ex){$error=$ex->getMessage();}
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Install Plateau Digital</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="install-page"><main class="install-card"><img class="install-logo" src="assets/images/plateau-digital-logo.jpg"><h1>Platform Installation</h1><?php if($success):?><div class="alert success">Installation completed successfully. <strong>Delete install.php now</strong>, then sign in to the admin dashboard.</div><a class="btn" href="admin/login.php">Open Admin Login</a><?php else:?><?php if($error):?><div class="alert error"><?=htmlspecialchars($error)?></div><?php endif;?><form method="post"><h3>Database settings</h3><label>Database host<input name="db_host" value="<?=htmlspecialchars($host)?>" required></label><label>Database name<input name="db_name" value="<?=htmlspecialchars($dbname)?>" required></label><label>Database username<input name="db_user" value="<?=htmlspecialchars($user)?>" required></label><label>Database password<input type="password" name="db_pass" value="<?=htmlspecialchars($pass)?>"></label><h3>Administrator account</h3><label>Full name<input name="admin_name" required></label><label>Email address<input type="email" name="admin_email" required></label><label>Password (minimum 8 characters)<input type="password" name="admin_password" minlength="8" required></label><button class="btn" type="submit">Install Plateau Digital</button></form><?php endif;?></main></body></html>
