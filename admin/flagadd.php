<?php
include_once("../includes/init.php");
include_once("common.php");

if($_POST)
{
  $name = isset($_POST['name']) ? trim($_POST['name']) : '';
  $title = isset($_POST['title']) ? trim($_POST['title']) : '';
  
  $flag = $db->select()->from("flag")->where("name = '$name'")->find();

  //当书籍存在的时候
  if($flag)
  {
    show("该标签已经存在了，请重新添加","flagadd.php");
    exit;
  }

  $data = array( 
    "name"=>$name,
    "title"=>$title
  );

  //插入数据库
  if($db->add("flag",$data))
  {
    show('添加标签成功','flaglist.php');
    exit;
  }else{
    show('添加标签失败');
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
            <h1 class="page-title">添加标签</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">首页</a> <span class="divider">/</span></li>
            <li class="active">添加</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='flaglist.php'"><i class="icon-list"></i> 返回标签列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post" enctype="multipart/form-data">
                            
                            <label>标签名称</label>
                            <input type="text" value="" class="input-xxlarge" name="name" required placeholder="请输入标签名称" />
                            <label>标签标题</label>
                            <input type="text" value="" class="input-xxlarge" name="title" required placeholder="请输入标签名称" />
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

