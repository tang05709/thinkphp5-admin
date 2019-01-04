<?php
// 为防止直接输入进来，需要判断是否存在lock，存在则跳转到首页

if (file_exists('/install.lock')) {
  header('Location: ' . $_SERVER['SERVER_NAME']);
  die;
}

$action = $_GET['step'] ?? '';

/**
 * 版本确认
 */
if ($action == 'step1') {
  //获取php版本
  if (version_compare(PHP_VERSION, '7.0.0') < 0) {
    echo "<script> alert('PHP版本过低，需要php7.0以上版本');javascript:history.back(-1); </script>"; 
    exit;
  }
  // 数据库配置文件读写
  $database_file = str_replace('\public\install', '', __DIR__) . '/application/database.php';
  $default_database_file = str_replace('\public\install', '', __DIR__) . '/application/database_default.php';
  if (!is_readable($default_database_file) && !is_writeable($database_file)) {
    echo "<script> alert('数据库配置文件不可读写，请检查/config/database.php和/config/database_default.php的读写权限！');javascript:history.back(-1); </script>"; 
    exit;
  }
  // sql文件是否可读
  if (!is_readable('./install.sql')) {
    echo "<script> alert('数据库文件不可读，请检查/public/install/install.sql的读写权限！');javascript:history.back(-1); </script>"; 
    exit;
  }
  // lock写入权限
  if (!is_readable(dirname(__FILE__))) {
    echo "<script> alert('install.lock文件不可写，请检查/public/install的读写权限！');javascript:history.back(-1); </script>"; 
    exit;
  }
  // 数据库信息
  require('./step1.html');
} 
/**
 * 数据库连接信息
 */
else if ($action == 'step2') {
  //获取数据库连接信息
  $dbname = $_POST['dbname'];
  $dbuser = $_POST['dbuser'];
  $dbpassword = $_POST['dbpassword'];
  $dbhost = $_POST['dbhost'];
  $dbprefix = $_POST['dbprefix'];
  if (empty($dbname) && empty($dbuser) && empty($dbpassword) && empty($dbhost)) {
    echo "<script> alert('请将信息填写完整');javascript:history.back(-1); </script>"; 
    exit;
  }
  $res = create_db($dbname, $dbuser, $dbpassword, $dbhost, $dbprefix);
  if ($res['error'] == 1) {
    echo "<script> alert('".$res['msg']."');javascript:history.back(-1); </script>"; 
    exit;
  }
  // 网站信息
  require('./step2.html');
} 
/**
 * 网站信息
 */
else if ($action == 'step3') {
  $web_name = $_POST['web_name'];
  $web_user = $_POST['web_user'];
  $web_password = $_POST['web_password'];
  $web_repassword = $_POST['web_repassword'];
  if (empty($web_user) && empty($web_password) && empty($web_repassword)) {
    echo "<script> alert('请将信息填写完整');javascript:history.back(-1); </script>"; 
    exit;
  }
  // 密码是否一致
  if ($web_password != $web_repassword) {
    echo "<script> alert('2次输入的密码不一致');javascript:history.back(-1); </script>"; 
    exit;
  }
  $res = insert_base_info ($web_user, $web_password, $web_name);
  if ($res['error'] == 1) {
    echo "<script> alert('".$res['msg']."');javascript:history.back(-1); </script>"; 
    exit;
  }
  // 完成安装
  require('./success.html');
}
/**
 * 欢迎页面
 */
else {
  require('./welcome.html');
}


/**
 * 创建数据库并创建表
 */
function create_db($dbname, $dbuser, $dbpassword, $dbhost, $dbprefix) {
  $res = [
    'error' => 1,
    'msg' => '不可预期错误！'
  ];
  // 连接数据库
  $conn = @mysqli_connect($dbhost, $dbuser, $dbpassword);
  if (!$conn) {
    $res = [
      'error' => 1,
      'msg' => '数据库连接错误，请核对数据库连接信息!'
    ];
    return $res;
  } 
  // 读取sql文件
  if (!file_exists('./install.sql')) {
    $res = [
      'error' => 1,
      'msg' => '数据库文件不存在，请检查/public/install/install.sql是否存在！'
    ];
    return $res;
  }  
  // database配置文件是否可写
  $database_file = str_replace('\public\install', '', __DIR__) . '/application/database.php';
  $default_database_file = str_replace('\public\install', '', __DIR__) . '/application/database_default.php';

  $sql_file = @file_get_contents('./install.sql');
  // 设置数据库编码
  $conn->query("SET NAMES 'utf8'");
  //创建数据库
  $sql = "CREATE DATABASE IF NOT EXISTS ".$dbname." default character set utf8 COLLATE utf8_general_ci;";
  if (!$conn->query($sql)) {
    $res = [
      'error' => 1,
      'msg' => '数据库创建失败！'
    ];
    return $res;
  }
  //选择数据库
  $conn->select_db($dbname);

  //替换数据表前缀
  if(!empty($dbprefix)) {
    $sql_file = str_replace('ty_', $dbprefix, $sql_file);
  }
  // sql文件语句以;号结束，将每条语句分割到属猪
  $sql_arr = explode(';', $sql_file);
  foreach($sql_arr as $val) {
    // sql运行需要;号，所以还得加上
    $sql = $val . ';';
    $conn->query($sql);
  }
  // 关闭数据库
  mysqli_close($conn);

  // 修改database配置
  $database_config = @file_get_contents($default_database_file);
  // 替换配置
  $database_config = str_ireplace('default_host', $dbhost, $database_config);
  $database_config = str_ireplace('default_database', $dbname, $database_config);
  $database_config = str_ireplace('default_user', $dbuser, $database_config);
  $database_config = str_ireplace('default_password', $dbpassword, $database_config);
  if (!empty($dbprefix)) {
    $database_config = str_ireplace('default_prefix', $dbprefix, $database_config);
  } else {
    $database_config = str_ireplace('default_prefix', 'ty_', $database_config);
  }

  @file_put_contents($database_file, $database_config);
}

/**
 * 保存基本信息
 */
function insert_base_info ($web_user, $web_password, $web_name) {
  $database_file = str_replace('\public\install', '', __DIR__) . '/application/database.php';
  $database_config = require($database_file);
  $conn = @mysqli_connect($database_config['hostname'], $database_config['username'], $database_config['password'], $database_config['database']);
  if (!$conn) {
    $res = [
      'error' => 1,
      'msg' => '数据库连接错误，请核对数据库连接信息!'
    ];
    return $res;
  }
  $conn->query("SET NAMES 'utf8'");
  // 插入用户名和密码
  $password = password_hash($web_password, PASSWORD_DEFAULT);
  $sql = "INSERT INTO " . $database_config['prefix'] . "admins (name, password, create_time, update_time) VALUES('". $web_user ."', '". $password ."', ". time() .", ". time() .")";
  $conn->query($sql);
  if (!empty($web_name)) {
    $web_name = "管理系统";
  }
  $sql = "INSERT INTO ". $database_config['prefix'] . "configs (name) VALUES('".$web_name."')";
  $conn->query($sql);
  mysqli_close($conn);
  //写入lock
  $content = "系统名称". $web_name .",创建时间: " .date("Y-m-d H:i:s");
  $file = fopen("./install.lock","w");
  fwrite($file, $content);
  fclose($file);
}
?>