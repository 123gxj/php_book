<?php
include_once("../includes/init.php");
include_once("common.php");

if($_POST)
{
  $username = isset($_POST['username']) && !empty($_POST['username']) ? trim($_POST['username']) : '';
  $password = isset($_POST['password']) && !empty($_POST['password']) ? trim($_POST['password']) : '';
  $email = isset($_POST['email']) && !empty($_POST['email']) ? trim($_POST['email']) : '';
  $admin = $db->select()->from("admin")->where("username = '$username'")->find();

  $salt = $Strings->randomStr();
  $password =md5($password.$salt);
  //当书籍存在的时候
  if($admin)
  {
    show("该管理员已经存在了，请重新添加","adminadd.php");
    exit;
  }

  $data = array(
    "username"=>$username,
    'password'=>$password,
    'register_time'=>strtotime($_POST['register_time']),   //2019-09-12
    'email'=>trim($_POST['email']),
    'salt'=>$salt
  );

  //判断是否有文件上传
  if($uploads->isFile())
  {
    //判断文件是否上传成功
    if($uploads->upload())
    {
      //获取上传的文件名
      $data['avatar'] = $uploads->savefile();
    }else{
      //显示错误信息
      show($uploads->getMessage());
      exit;
    }
  }

  //插入数据库
  if($db->add("admin",$data))
  {
    show('添加管理员成功','adminlist.php');
    exit;
  }else{
    show('添加管理员失败');
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once('meta.php');?>
  </head>

  <body> 

    
    <?php include_once('header.php');?>

    <?php include_once('menu.php');?>

    <div class="content">
        <div class="header">
            <h1 class="page-username">添加书籍</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">首页</a> <span class="divider">/</span></li>
            <li class="active">添加</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='adminlist.php'"><i class="icon-list"></i> 返回书籍列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post" enctype="multipart/form-data">
                           
                            <label>管理员名称</label>
                            <input type="text" value="" class="input-xxlarge" name="username" required placeholder="请输入书籍标题" />
                            <label>管理员头像</label>
                            <input type="file" value="" class="input-xxlarge" name="avatar" />
                            <label>管理员邮箱</label>
                            <input type="text" value="" class="input-xxlarge" name="email" required />
                            <label>密码</label>
                            <input type="text" value="" class="input-xxlarge" name="password" required />
                            <label>注册时间</label>
                            <input type="date" value="" class="input-xxlarge" name="register_time" required />
                            
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
    
    
  </body>
</html>
<?php include_once('footer.php');?>

