<?php
include_once("../includes/init.php");
include_once("common.php");

$config = $db->select()->from("config")->all();
// var_dump($config);die;
if($_POST)
{
  // echo '<pre>';
  // print_r($_FILES);exit;
  // var_dump($_POST);die;
  $webname = isset($_POST['webname']) ? trim($_POST['webname']) : '';
  $logo = isset($_POST['logo']) ? trim($_POST['logo']) : '';
  $keywords = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
  $description = isset($_POST['description']) ? trim($_POST['description']) : '';
  $copyright = isset($_POST['copyright']) ? trim($_POST['copyright']) : '';
  $data =array(
   "webname"=>$webname,
   "logo"=>$logo,
   "keywords"=>$keywords,
   "description"=>$description,
   "copyright"=>$copyright,
);
// echo count($data);die;
  // var_dump($uploads->isFile());exit;
  //判断是否有文件上传
  if($uploads->isFile())
  {
    //判断文件是否上传成功
    if($uploads->upload())
    {
      @is_file(ASSETS_PATH.$oldlogo) && @unlink(ASSETS_PATH.$oldlogo);
      //获取上传的文件名
      $data['logo'] = $uploads->savefile();
    }else{
      //显示错误信息
      show($uploads->getMessage());
      exit;
    }
  }

  // var_dump($data);exit;
  //插入数据库
  $time = 0;
  foreach($data as $key => $value){
    // echo $key,$value;
    $record = array(
     'value' => $value
    );
    $res = $db->update("config",$record,"name = '$key'");
    // echo $res;
    // echo "<br>";
    if(!$res){
      show('网站配置失败');
      exit;
    }else{
      $time =$time+1;
    }
 
  }
  // echo count($data),$time;die;
  if($time == count($data)){
    show('网站配置成功');
      exit;
  }

}


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
            <h1 class="page-title">网站配置</h1>
        </div>


        <div class="container-fluid">


                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post" enctype="multipart/form-data">
                        <?php foreach($config as $index =>$item){ ?>
                          <!-- 网站logo -->
                          <?php if($item['name'] == 'logo'){ 
                            $oldlogo =$item['value']; ?>
                            <label><?php echo $item['name'];?></label>
                            <input type="file" class="input-xxlarge" name="<?php echo $item['name']; ?>" />
                            <?php if(!empty($item['value'])){?>
                              <div class="book_thumb">
                                <img class="img-responsive" src="<?php echo ASSETS_PATH.$item['value'];?>" />
                              </div>
                            <?php }else{?>
                              <div class="book_thumb">
                                <img class="img-responsive" src="<?php echo ADMIN_PATH.'/images/cover.png';?>" />
                              </div>
                            <?php }?>
                          <?php continue; } ?>
                          <!-- 网站描述 -->
                          <?php  if($item['name'] == 'description'){ ?>
                            <label><?php echo $item['title'] ?></label>
                            <textarea value="<?php echo $item['value'] ?>" rows="3" class="input-xxlarge" name="<?php echo $item['name'] ?>"><?php echo $item['value'];?></textarea>
                            <?php continue;} ?> 
                          <!-- 其余普通input type=text字段 -->
                          <label><?php echo $item['title'] ?></label>
                            <input type="text" class="input-xxlarge" name="<?php echo $item['name'] ?>" required placeholder="请输入网站<?php echo $item['title'] ?>" value="<?php echo $item['value'] ?>" />
 
                          <?php } ?>   

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

