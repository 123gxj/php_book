<?php
include_once("../includes/init.php");
include_once("common.php");

if($_POST)
{
  $title = isset($_POST['title']) ? trim($_POST['title']) : '';
  
  $book = $db->select()->from("book")->where("title = '$title'")->find();

  //当书籍存在的时候
  if($book)
  {
    show("该书籍已经存在了，请重新添加","bookadd.php");
    exit;
  }

  $data = array(
    "title"=>$title,
    'author'=>trim($_POST['author']),
    'register_time'=>strtotime($_POST['register_time']),   //2019-09-12
    'content'=>trim($_POST['content']),
    'cateid'=>trim($_POST['cateid']),
    'flagid'=>trim($_POST['flagid']),
    'recycle'=>0,
  );

  //判断是否有文件上传
  if($uploads->isFile())
  {
    //判断文件是否上传成功
    if($uploads->upload())
    {
      //获取上传的文件名
      $data['thumb'] = $uploads->savefile();
    }else{
      //显示错误信息
      show($uploads->getMessage());
      exit;
    }
  }

  //插入数据库
  if($db->add("book",$data))
  {
    show('添加书籍成功','booklist.php');
    exit;
  }else{
    show('添加书籍失败');
    exit;
  }
}


//查询书籍分类
$catelist = $db->select()->from("cate")->all();
$flaglist = $db->select()->from("flag")->all();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once('meta.php');?>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH?>/plugin/kindeditor/themes/default/default.css" />
    <script src="<?php echo ASSETS_PATH?>/plugin/kindeditor/kindeditor-min.js"></script>
    <script src="<?php echo ASSETS_PATH?>/plugin/kindeditor/lang/zh_CN.js"></script>
    <script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					allowFileManager : true
				});
			});
		</script>
  </head>

  <body> 

    
    <?php include_once('header.php');?>

    <?php include_once('menu.php');?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">添加书籍</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">首页</a> <span class="divider">/</span></li>
            <li class="active">添加</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='booklist.php'"><i class="icon-list"></i> 返回书籍列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post" enctype="multipart/form-data">
                            <label>书籍分类</label>
                            <select required name="cateid" class="input-xlarge">
                              <option value="">请选择</option>
                              <?php foreach($catelist as $item){?>
                              <option value="<?php echo $item['id'];?>"><?php echo $item['name'];?></option>
                              <?php }?>
                              </select>
                              <label>书籍标签</label>
                            <select required name="flagid" class="input-xlarge">
                              <option value="">请选择</option>
                              <?php foreach($flaglist as $item){?>
                              <option value="<?php echo $item['id'];?>"><?php echo $item['title'];?></option>
                              <?php }?>
                            </select>
                            <label>书籍标题</label>
                            <input type="text" value="" class="input-xxlarge" name="title" required placeholder="请输入书籍标题" />
                            <label>书籍作者</label>
                            <input type="text" value="" class="input-xxlarge" name="author" required />
                            <label>添加时间</label>
                            <input type="date" value="" class="input-xxlarge" name="register_time" required />
                            <label>书籍封面</label>
                            <input type="file" value="" class="input-xxlarge" name="thumb" />
                            <label>书籍内容</label>
                            <textarea value="Smith" rows="3" class="input-xxlarge" name="content"></textarea>
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

