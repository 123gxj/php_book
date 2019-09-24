<?php
include_once("includes/init.php");
include_once("common.php");

$action = isset($_GET['action']) ? $_GET['action'] : "pages";
$downAction = isset($_GET['downAction']) ? $_GET['downAction'] : "";
$chaid = isset($_GET['chaid']) ? $_GET['chaid'] : 0;

$bookinfo = $db->select()->from("chapter")->where("id = $chaid")->find();
$bookid = $bookinfo['bookid'];

if(!$bookinfo)
{
show("无章节数据",'bookilist.php');
exit;
}

$content = is_file(HOME_ASSETS.$bookinfo['content']) ? file_get_contents(HOME_ASSETS.$bookinfo['content']) : "";

if(empty($content))
{
show("该章节无内容","booklist.php");
exit;
}
$content= json_decode($content,true);

$prev = $db->select("id")->from('chapter')->where("id < $chaid and bookid = $bookid")->orderby("id","desc")->find();
$next = $db->select("id")->from('chapter')->where("id > $chaid and bookid = $bookid")->orderby("id","asc")->find();

//分页阅读
if($action == "pages"){
 $json = json_decode($content,true);
}

//下拉阅读
if($action == "down"){
 
  $prev=$prev['id'];
  $next = $next['id'];
 //下拉
  if($downAction == 'reset'){
    $result = array("content"=>$content,"prev"=>$prev,"next"=>$next);
    echo json_encode($result);
     exit;
    }
  //上拉
  if($downAction == 'page'){
   
   if($next == NULL){
     $next =' NULL';
   }
   $result = array("content"=>$content,"prev"=>$prev,"next"=>$next);
      echo json_encode($result);
    exit;
    }
  
}

?>
<!DOCTYPE html>
<html>

<head>
  <?php include_once('meta.php');?>
  <?php if($action == "down"){ ?>
    <link rel="stylesheet" href="<?php echo HOME_ASSETS;?>/plugin/mescroll/mescroll.min.css" />
  <script src="<?php echo HOME_ASSETS;?>/plugin/mescroll/mescroll.min.js"></script>


  <!-- 模板引擎插件 -->
  <script src="<?php echo HOME_ASSETS;?>/plugin/templatejs/template.js"></script>
  <style>
    .mescroll{
			position: fixed;
			top: 144px;
			bottom: 0;
			height: auto; /*如设置bottom:50px,则需height:auto才能生效*/
		}
  </style>
    <?php }?>
</head>
<body>
<div id="nav-over"></div>
<div id="warmp" class="warmp">
	<?php include_once('header.php');?>
	
	<div class="dh">
    <a href="index.php">首页</a> > 
    <?php if($action == "pages"){?>
      <font color=#999999><strong><?php echo $json['title'];?></strong></font>
      <a style="float:right;" href="bookinfo.php?chaid=<?php echo $chaid;?>&action=down">下拉阅读</a>
    <?php }?>
    <?php if($action == "down"){ ?>
      <font color=#999999><strong><?php ?></strong></font>
      <a style="float:right;" href="bookinfo.php?chaid=<?php echo $chaid;?>&action=pages">分页阅读</a>
    <?php }?>
  </div>
  <!-- -----------------------------
  分页页面
  -------------------------------- -->
  <?php if($action == "pages"){ ?>
	<article class="article">
		<h1 class="hd"><?php echo $json['title'];?></h1>
		<div class="article-con">
			<?php echo $json['content'];?>
		</div>
	</article>
	<div class="pagelist">
    <?php if($prev){?>
      <li><a href="bookinfo.php?chaid=<?php echo $prev['id'];?>">上一页</a></li>
    <?php }else{?>
      <li><a href="javascript:void(0)">无上一页</a></li>
    <?php }?>
    <?php if($next){?>
      <li><a href="bookinfo.php?chaid=<?php echo $next['id'];?>">下一页</a></li>
    <?php }else{?>
      <li><a href="javascript:void(0)">无下一页</a></li>
    <?php }?>
  </div>
  <?php include_once("footer.php");?>
  <?php }?>
  <!-- -----------------------------
 下拉页面
  -------------------------------- -->
  <?php if($action == "down"){ ?>
    <div id="mescroll" class="mescroll list-index">
        <ul id="articlelist" class="article"> </ul>
       
      </div>
    <?php }?>
 
</div>

<?php include_once("menu.php");?>

</body>
</html>
<script src="<?php echo HOME_PATH;?>/js/index.js"></script>
<!-- -----------------------------
 导入文章id的数组 
  -------------------------------- -->
<script>
// var chaidArray = new Array();
</script>
<!-- -----------------------------
  数据获取及模板渲染
  -------------------------------- -->
<?php if($action == "down"){ ?>
<script id="tpl" type="text/html">
<div id="articlecontent">
<h1 class="hd"> <%:=article.title%></h1>
    <div class="article-con">
    <%:=article.content%>
    </div>
</div>
   
</script>
<script>
var chaid = "<?php echo $chaid;?>";
var prev = 0;
var next =0;

var mescroll = new MeScroll("mescroll",{
    //设置下拉刷新回调
    down:{
      callback: downCallback,
     
    },

    //设置上拉加载
    up:{
      callback: upCallback,
     
      auto:false,
    },
    toTop: {
          //回到顶部按钮
          src: "<?php echo HOME_PATH; ?>/images/top.png", //图片路径,默认null,支持网络图
          offset: 10 //列表滚动1000px才显示回到顶部按钮  
        }
  });

  //下拉刷新的回调函数 (数据清空)
  function downCallback()
  {
    console.log('down')
    if(prev){
      chaid = prev;
      if(prev == 'NULL'){
        console.log(53)
        var str = template(tpl, {article:'已是最新章节，以下无内容'});
          $("#articlelist").empty();
          $("#articlelist").append(str);
          return false;
      }
    }
    console.log('本页id',chaid)
    $.ajax({
				url: `bookinfo.php?action=down&downAction=reset&chaid=${chaid}`,//
        dataType:"json",
				success: function(data) {
          console.log(data);
          var content = data.content
           prev = data.prev
          next = data.next
          var tpl = document.getElementById('tpl').innerHTML;
          var str = template(tpl, {article:content});
          $("#articlelist").empty();
          $("#articlelist").append(str);
          // $("#articlecontent").scrollTop = $("#articlelist").scrollHeight;
          // mescroll.resetUpScroll();
					mescroll.endSuccess(); //无参. 注意结束下拉刷新是无参的
				},
				error: function(data) {
					//联网失败的回调,隐藏下拉刷新的状态
					mescroll.endErr();
				}
       
			});
    }
    
   //上拉加载 (增加数据)
   function upCallback(page)
  {
    console.log('up')
   if(next){
     chaid = next;
   }
   console.log('本页id',chaid)
    $.ajax({
      url: `bookinfo.php?action=down&downAction=page&chaid=${chaid}`,//
      dataType:"json",
      success: function(data) {
        //  console.log(data);
           var content = data.content;
          prev = data.prev
          next = data.next
          var tpl = document.getElementById('tpl').innerHTML;
          var str = template(tpl, {article:content});
          // $("#articlelist").html("");
          $("#articlelist").empty();
          $("#articlelist").append(str);
          // $("#articlecontent").scrollTop = $("#articlelist").scrollHeight;
          mescroll.endSuccess(); //无参. 注意结束下拉刷新是无参的

      },
      error: function(e) {
        //联网失败的回调,隐藏下拉刷新和上拉加载的状态
        mescroll.endErr();
      }
    });
  }
</script>
<?php } ?>