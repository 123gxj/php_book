<?php
include_once("../includes/init.php");
include_once("common.php");

$websiteid = isset($_GET['websiteid']) ? $_GET['websiteid'] : 0;

$website = $db->select()->from("website")->where(array('id'=>$websiteid))->find();

if(!$website)
{
  show('该网站节点不存在，请重新选择','websitelist.php');
  exit;
}

if($_POST)
{
  $name = isset($_POST['name']) ? trim($_POST['name']) : '';
  $node = isset($_POST['node']) ? trim($_POST['node']) : '';
  // var_dump($_POST);die;
  $websitecheck = $db->select()->from("website")->where("name = '$name' AND id != $websiteid")->find();

  //当网站节点存在的时候
  if($websitecheck)
  {
    show("该网站节点已经存在了，请重新修改","websiteedit.php?websiteid=$websiteid");
    exit;
  }

  $data =array(
     "name"=>$name,
     "node"=>$node
    );


  //插入数据库
  if($db->update("website",$data,"id = $websiteid"))
  {
    show('编辑节点成功','websitelist.php');
    exit;
  }else{
    show('编辑节点失败');
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
            <h1 class="page-title">添加网站节点</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">首页</a> <span class="divider">/</span></li>
            <li class="active">添加</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='websitelist.php'"><i class="icon-list"></i> 返回网站节点列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post" enctype="multipart/form-data">
                          <label>网站名称</label>
                            <input type="text" class="input-xxlarge" name="name" required placeholder="请输入网站名称" value="<?php echo $website['name'];?>" />
                            <label>节点文件名称</label>
                            <input type="text" class="input-xxlarge" name="node" required placeholder="请输入节点文件名" value="<?php echo $website['node'];?>" />
                           
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

