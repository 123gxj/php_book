<?php
 header("Content-type:text/html; charset=utf-8"); 
 date_default_timezone_set("PRC");
include_once("../includes/init.php");
include_once("common.php");

$booklist = $db->select()->from("book")->where("recycle=0")->all();
$nodelist = $db->select()->from("website")->all();


if($_POST){
  $url = isset($_POST['url']) ? trim($_POST['url']) : false;
  $bookid = isset($_POST['bookid']) ? trim($_POST['bookid']) :0;
  $node = isset($_POST['node']) ? trim($_POST['node']) :0;
 
  // var_dump($_POST);die;
 if(!$node){
  show('请选择采集节点','chapterget.php');
  exit;
 }
  if(!$url)
  {
    show('请输入采集地址','chapterget.php');
    exit;
  }
  // $urlStr = $url;
  // $urlStr = strstr($urlStr,'\/',true);
  // echo $urlStr;die;

  
  include_once("../assets/website/{$node}");
    
   
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
            <h1 class="page-title">发布文章</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Index</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='list.html'"><i class="icon-list"></i> 返回书籍列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post">
                            <label>书籍名称</label>
                            <select name="bookid" class="input-xlarge" required>
                              <option value="">请选择</option>
                              <?php foreach($booklist as $item){?>
                                <option value="<?php echo $item['id'];?>"><?php echo $item['title'];?></option>
                              <?php }?>
                            </select>
                             <label>选择采集节点</label>
                            <select name="node" class="input-xlarge" required>
                              <option value="">请选择</option>
                              <?php foreach($nodelist as $item){?>
                                <option value="<?php echo $item['node'];?>"><?php echo $item['name'];?></option>
                              <?php }?>
                            </select>
                            <label>采集地址(复制带有章节列表的页面链接)</label>
                            <input type="text" name="url" required value="" class="input-xxlarge" placeholder="请输入采集地址" />
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


