<?php
include_once("../includes/init.php");
include_once("common.php");

if($_POST)
{ 
  $deletebookid = isset($_POST['deletebookid']) ? $_POST['deletebookid'] : 0;
  $chapterid = isset($_POST['chapterid']) ? $_POST['chapterid'] : 0;
  $chapterid = implode(",",$chapterid);
  $chapterdelete = $db->select("content")->from("chapter")->where("id IN($chapterid)")->all();

  $affect = $db->delete("chapter","id IN($chapterid)");
  if($affect)
  {
    if($chapterdelete)
    {
      foreach($chapterdelete as $item)
      {
        // echo ASSETS_PATH.$item['content'];
        @is_file(ASSETS_PATH.$item['content']) && @unlink(ASSETS_PATH.$item['content']);
      }
    }
    // die;
    show("删除章节{$affect}条","chapterlist.php?bookid={$deletebookid}");
    exit;
  }else{
    show("删除章节失败","chapterlist.php?bookid={$deletebookid}");
    exit;
  }
 
}

if($_GET){
  $bookid = isset($_GET['bookid']) ? $_GET['bookid'] : 0;
  if($bookid){
//当前页码数
$page = isset($_GET['page']) ? $_GET['page'] : 1;

//总条数
$count = $db->select("COUNT(id) AS c")->from("chapter")->find();

//每页显示多少条
$limit = 10;

//中间的页码数
$size = 6;

//调用分页函数，生成分页字符串
$pageStr = page($page,$count['c'],$limit,$size,'yellow');

//偏移量
$start = ($page-1)*$limit;
$bookname = $db->select("title")->from("book")->where("id =$bookid")->find();
// var_dump($bookname) ;die;
//查询数据
$chapterlist = $db->select()->from("chapter")->where("bookid= $bookid")->orderby("id",'desc')->limit($start,$limit)->all();
  }

}

$booklist = $db->select()->from("book")->where("recycle=0")->all();

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
            <h1 class="page-title">章节列表</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">后台首页</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                
                <div class="well">
                <form action="" method="get">
                <label>请选择章节</label>
                            <select required name="bookid" class="input-xlarge">
                              <option value=""><?php echo isset($chapterlist)? $bookname["title"] : '请选择'; ?></option>
                              <?php foreach($booklist as $item){?>
                              <option value="<?php echo $item['id'];?>"><?php echo $item['title'];?></option>
                              <?php }?>
                            </select>
                            <button type="submit">确定</button>
                </form>
                    <form method="post">
                   
                     <table class="table">
                        <thead>
                          <tr>
                            <th><input type="checkbox" name="delete" id="delete" /></th>
                            <th>上传时间</th>
                            <th>章节标题</th>
                            <th style="width: 50px;">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          if(isset($chapterlist)){
                          foreach($chapterlist as $item){?>
                          <tr>
                            <td><input type="checkbox" class="items" name="chapterid[]" value="<?php echo $item['id'];?>" />
                            <input type="hidden" name="deletebookid" value="<?php if(isset($chapterlist)) echo $chapterlist[0]['bookid'];?>" />
                            </td>
                            <td><?php 
                            $time = date("Y/m/d",$item['register_time']);
                            echo $time?></td>
                            <td><?php echo $item['title']?></td>
                            
                            <td>
                                
                                <a href="#myModal" onclick="del(<?php echo $item['id'];?>)" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                            </td>
                          </tr>
                          <?php }}?>
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
                    <?php 
                    if(isset($pageStr)){
                       echo $pageStr;
                    } ?>
                 
                </div>
                
                <form method="post">
                <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Delete Confirmation</h3>
                    </div>
                    <div class="modal-body">
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>确定删除该章节?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="chapterid" name="chapterid[]" value="0" />
                        <input type="hidden" name="deletebookid" value="<?php if(isset($chapterlist)) echo $chapterlist[0]['bookid'];?>" />                    
                    
                        <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                        <button type="submit" class="btn btn-danger">删除</button>
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
  function del(chapterid)
  {
    $("#chapterid").val(chapterid);
  }
</script>