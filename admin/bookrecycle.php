<?php
include_once("../includes/init.php");
include_once("common.php");


if($_POST)
{
  // var_dump($_POST);die;
  $bookid = isset($_POST['bookid']) ? $_POST['bookid'] : 0;
  $bookid = implode(",",$bookid);
  $action = isset($_POST['action']) ? trim( $_POST['action']) : 0;

  if($action){
    if($action == 'restore'){
      $data =array(
        "recycle"=>0,
     );
    
      if($db->recycle("book",$data,"id = $bookid"))
      {
        show('还原书籍成功',"bookrecycle.php");
        exit;
      }else{
        show('还原书籍失败',"bookrecycle.php");
        exit;
      }
    }
   if($action == 'delete'){
    $bookdelete = $db->select("thumb")->from("book")->where("id IN($bookid)")->all();

  $affect = $db->delete("book","id IN($bookid)");
  if($affect)
  {
    if($bookdelete)
    {
      foreach($bookdelete as $item)
      {
        @is_file(ASSETS_PATH.$item['thumb']) && @unlink(ASSETS_PATH.$item['thumb']);
      }
    }
    show("删除书籍{$affect}条","bookrecycle.php");
    exit;
  }else{
    show("删除书籍失败","bookrecycle.php");
    exit;
  }
   }
  }else{
    show("无法执行当前动作","bookrecycle.php");
  }

}

//当前页码数
$page = isset($_GET['page']) ? $_GET['page'] : 1;

//总条数
$count = $db->select("COUNT(id) AS c")->from("book")->find();

//每页显示多少条
$limit = 5;

//中间的页码数
$size = 6;

//调用分页函数，生成分页字符串
$pageStr = page($page,$count['c'],$limit,$size,'yellow');

//偏移量
$start = ($page-1)*$limit;

//查询数据
$booklist = $db->select("book.*,cate.name")->from("book")->join("cate","book.cateid = cate.id")->where("recycle=1")->orderby("book.id","desc")->limit($start,$limit)->all();

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
            <h1 class="page-title">书籍回收站</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">后台首页</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='bookadd.php'"><i class="icon-plus"></i>添加书籍</button>
                </div>
                <div class="well">
                    <form method="post" id="mainForm">
                      <table class="table">
                        <thead>
                          <tr>
                            <th><input type="checkbox" name="delete" id="delete" /></th>
                            <th>文章标题</th>
                            <th>作者</th>
                            <th>所属分类</th>
                            <th>图片</th>
                            <th>发布时间</th>
                            <th style="width: 50px;">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                    
                          <?php foreach($booklist as $item){?>
                          <tr>
                            <td><input type="checkbox" class="items" name="bookid[]" value="<?php echo $item['id'];?>" /></td>
                           
                            <td><?php echo $item['title']?></td>
                            <td><?php echo $item['author']?></td>
                            <td><?php echo $item['name']?></td>
                            <?php if(!empty($item['thumb'])){?>
                              <td>
                                <div class="book_thumb">
                                  <img class="img-responsive" src="<?php echo ASSETS_PATH.$item['thumb'];?>" />
                                </div>
                              </td>
                            <?php }else{?>
                              <td>
                                <div class="book_thumb">
                                  <img class="img-responsive" src="<?php echo ADMIN_PATH.'/images/cover.png';?>" />
                                </div>
                              </td>
                            <?php }?>
                            <td><?php echo date("Y-m-d",$item['register_time']);?></td>
                            <td>
                                <a href="#myModal2" onclick="restore(<?php echo $item['id'];?>)" role="button" data-toggle="modal"><i class="icon-pinterest"></i>还原</a>
                                <a href="#myModal" onclick="del(<?php echo $item['id'];?>)" role="button" data-toggle="modal"><i class="icon-remove"></i>删除</a>
                            </td>
                          </tr>
                          <?php }?>
                          <tr>
                          <input type="hidden" name="action" value="" id="actionBatch"/>
                            <td colspan="0" style="text-align:left;" onclick="deleteBatch()">
                             <button type="submit">批量删除</button>
                            </td>
                            <td colspan="10" style="text-align:left;" onclick="restoreBatch()">
                             <button type="submit">批量还原</button>
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
                        <h3 id="myModalLabel">Delete Confirmation</h3>
                    </div>
                    <div class="modal-body">
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>确定删除该书籍?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="bookid" name="bookid[]" value="0" />
                        <input type="hidden" class="action" name="action" value="0" />
                        <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        <button type="submit" class="btn btn-danger">删除</button>
                    </div>
                </div>
                </form>

                <form method="post">
                <div class="modal small hide fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Delete Confirmation</h3>
                    </div>
                    <div class="modal-body">
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>确定还原该书籍?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="bookid" name="bookid[]" value="0" />
                        <input type="hidden" class="action" name="action" value="0" />
                        <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        <button type="submit" class="btn btn-danger">还原</button>
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
 
  function deleteBatch()
  {
    console.log('deleteBatch');
     $("#actionBatch").val('delete')
  
  }

  
  function restoreBatch(){
    console.log('restoreBatch');
    $("#actionBatch").val('restore')
   }

  function del(bookid)
  {
    console.log('del');
    $(".bookid").val(bookid);
    $(".action").val('delete');
  }

  function restore(bookid)
  {
    console.log('restore');
    $(".bookid").val(bookid);
    $(".action").val('restore');
  }
</script>