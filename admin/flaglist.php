<?php
include_once("../includes/init.php");
include_once("common.php");


if($_POST)
{
 
  $flagid = isset($_POST['flagid']) ? $_POST['flagid'] : 0;
  $flagid = implode(",",$flagid);

   $affect = $db->delete("flag","id IN($flagid)");
  if($affect)
  {
   
    show("删除标签{$affect}条","flaglist.php");
    exit;
  }else{
    show("删除标签失败","flaglist.php");
    exit;
  }

}

//当前页码数
$page = isset($_GET['page']) ? $_GET['page'] : 1;

//总条数
$count = $db->select("COUNT(id) AS c")->from("flag")->find();

//每页显示多少条
$limit = 5;

//中间的页码数
$size = 6;

//调用分页函数，生成分页字符串
$pageStr = page($page,$count['c'],$limit,$size,'yellow');

//偏移量
$start = ($page-1)*$limit;

//查询数据
$flaglist = $db->select("flag.*,flag.name")->from("flag")->orderby("flag.id","desc")->limit($start,$limit)->all();

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
            <h1 class="page-title">标签列表</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">后台首页</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='flagadd.php'"><i class="icon-plus"></i>添加标签</button>
                </div>
                <div class="well">
                    <form method="post">
                      <table class="table">
                        <thead>
                          <tr>
                            <th><input type="checkbox" name="delete" id="delete" /></th>
                           
                            <th>标签名称</th>
                            <th>标签标题</th>
                             <th style="width: 50px;">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($flaglist as $item){?>
                          <tr>
                            <td><input type="checkbox" class="items" name="flagid[]" value="<?php echo $item['id'];?>" /></td>
                           
                            <td><?php echo $item['name']?></td>
                            <td><?php echo $item['title']?></td>
                            <td>
                                <a href="flagedit.php?flagid=<?php echo $item['id'];?>"><i class="icon-pencil"></i></a>
                                <a href="#myModal" onclick="del(<?php echo $item['id'];?>)" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                            </td>
                          </tr>
                          <?php }?>
                          <tr>
                            <td colspan="20" style="text-align:left;">
                              <button type="submit">批量删除</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </form>
                </div>
                <div class="pagination">
                    <?php echo $pageStr;?>
                </div>
                
                <form method="post">
                <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">删除确认</h3>
                    </div>
                    <div class="modal-body">
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>确认删除标签?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="flagid" name="flagid[]" value="0" />
                        <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        <button type="submit" class="btn btn-danger">确认</button>
                    </div>
                </div>
                </form>

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
<script>
  function del(flagid)
  {
    $("#flagid").val(flagid);
  }
</script>