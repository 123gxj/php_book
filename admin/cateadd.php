<?php
include_once("../includes/init.php");
include_once("common.php");

if($_POST)
{
  $name = isset($_POST['name']) ? trim($_POST['name']) : '';
  
  $cate = $db->select()->from("cate")->where("name = '$name'")->find();

  //当书籍存在的时候
  if($cate)
  {
    show("该分类已经存在了，请重新添加","cateadd.php");
    exit;
  }

  $data = array( "name"=>$name);

  //插入数据库
  if($db->add("cate",$data))
  {
    show('添加分类成功','catelist.php');
    exit;
  }else{
    show('添加分类失败');
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
            <h1 class="page-title">添加分类</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">首页</a> <span class="divider">/</span></li>
            <li class="active">添加</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='catelist.php'"><i class="icon-list"></i> 返回分类列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post" enctype="multipart/form-data">
                            
                            <label>分类名称</label>
                            <input type="text" value="" class="input-xxlarge" name="name" required placeholder="请输入分类名称" />
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

