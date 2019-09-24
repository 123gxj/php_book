<?php
 header("Content-type:text/html; charset=utf-8"); 
include_once("../includes/init.php");
include_once("common.php");

$id = isset($_GET['id']) && !empty($_GET['id']) ? intval($_GET['id']) : '';
if($id){
  $admin = $db->select()->from("admin")->where("id={$id}")->find();
  // var_dump($admin) ;die;
}

if($_POST){
    global $db;
  // echo $username;
  $username = isset($_POST['username']) && !empty($_POST['username']) ? trim($_POST['username']) : '';
  $password = isset($_POST['password']) && !empty($_POST['password']) ? trim($_POST['password']) : '';
  $email = isset($_POST['email']) && !empty($_POST['email']) ? trim($_POST['email']) : '';
  $register_time=time();
  
  $salt=isset($admin['salt']) && !empty($admin['salt']) ? $admin['salt']:'';
  $pwd=isset($admin['password']) && !empty($admin['password']) ? $admin['password']:'';
  if($password != $pwd){
    global $Strings;
     $salt = $Strings->randomStr();
     $password =md5($password.$salt);
  }else{
    $password = $pwd;
  }

  $data = array(
    'username' => $username,
    'password' => $password,
    'email' => $email,
    'salt' => $salt,
    'register_time' => $register_time,
  );
 
  if($id){
    $r=$db->update('admin',$data)->where("id={$id}")->edit();
  
    if($r){
      show('文章编辑成功...');die;
    }else{
      show('文章编辑失败...');die;
    }

  }else{

    $r = $db->insertInto('admin',$data)->add();
    if($r){
      show('文章添加成功...','admin_list.php');die;
    }else{
      show('文章添加失败...');die;
    }

  }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once('meta.php');?>
  </head>

  <body style="background-color:white;"> 

    <!-- 引入头部 -->
    <?php include_once('header.php');?>
    
    <?php include_once('menu.php');?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">
              管理员 <?php echo $id ? '编辑' : '添加' ?>
              </h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Index</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='admin_list.php'"><i class="icon-list"></i> 返回管理员列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post">
                            <label>管理员账号</label>
                            <input type="text" name="username" value="<?php echo isset($admin['username'])&&!empty($admin['username'])? $admin['username']:''; ?>" class="input-xxlarge" placeholder="请输入账号名称">
                            <label>账号密码</label>
                            <input type="text" name="password" required value="<?php echo isset($admin['password'])&&!empty($admin['password'])?$admin['password']:''; ?>" class="input-xxlarge" placeholder="请输入账号密码" />
                            <label>邮箱</label>
                            <input type="text" name="email" required value="<?php echo isset($admin['email'])&&!empty($admin['email'])?$admin['email']:''; ?>" class="input-xxlarge" placeholder="请输入邮箱" />
                            <label></label>
                            <input class="btn btn-primary" type="submit" value="提交" />
                        </form>
                      </div>
                  </div>
                </div>
                
                <footer>
                    <hr>
                    <p>&copy; 2017 <a href="#" target="_blank">copyright</a></p>
                </footer>
                    
            </div>
        </div>
    </div>
    
    <?php include_once('footer.php');?>

  </body>
</html>


