<?php
include_once("includes/init.php");
include_once("common.php");

$action = isset($_GET['action']) ? $_GET['action'] : "pages";
$downAction = isset($_GET['downAction']) ? $_GET['downAction'] : "";


if($action == "pages"){
  $chaid = isset($_GET['chaid']) ? $_GET['chaid'] : 0;
  $bookinfo = $db->select()->from("chapter")->where("id = $chaid")->find();
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
$json = json_decode($content,true);
//上一篇 和 下一篇
$prev = $db->select("id")->from('chapter')->where("id < $chaid")->orderby("id","desc")->find();

$next = $db->select("id")->from('chapter')->where("id > $chaid")->orderby("id","asc")->find();
}
// ------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------

if($action == "down"){
  // var_dump($_GET);
 
  $idStr = isset($_GET['idStr']) ? $_GET['idStr'] : '';
  if(isset($_GET['chaid'])) {
    $idStr = $_GET['chaid'];
    $chaid = $_GET['chaid'];
  }
  $friID = substr($idStr,0,1);
  $lastID = substr($idStr,strlen($idStr)-1);
 $bookid = $db->select('bookid')->from("chapter")->where("id = $friID")->find();
 $bookid = $bookid['bookid'];
//  var_dump($bookid);die;
//上拉重新加载
  if($downAction == 'reset'){
  // echo $friID.'&&&'.$idStr;die;
    $prev = $db->select("id")->from('chapter')->where("id < $friID")->orderby("id","desc")->find();
    $prevID = $prev['id'];
 
    $bookinfo = $db->select()->from("chapter")->where("id = $prevID")->find();
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
  $content =json_decode($content,true);
  // $artTitle = $content['title'];
  
  $count = $db->select("COUNT(id) AS c")->from("chapter")->where("bookid = $bookid")->find();
  
  $idStr = $prevID;
  // echo $idStr;die;

  $result = array("content"=>$content,"count"=>$count,"idStr"=>$idStr);
  // $json = json_decode($content,true);
  echo json_encode($result);
  exit;

  }
  //上拉刷新
  if($downAction == 'page'){
  // echo $friID.'&&&'.$idStr;die;
  
    $next = $db->select("id")->from('chapter')->where("id > $lastID")->orderby("id","asc")->find();  
    $nextID = $next['id'];
    $bookinfo = $db->select()->from("chapter")->where("id = $nextID")->find();
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
  $content =json_decode($content,true);
  // $artTitle = $content['title'];
   $count = $db->select("COUNT(id) AS c")->from("chapter")->where("bookid = $bookid")->find();
   $idStr = $idStr.$next['id'];
    $result = array("content"=>$content,"count"=>$count,"idStr"=>$idStr);
    // echo $chaid;die;
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
  数据获取及模板渲染
  -------------------------------- -->
<?php if($action == "down"){ ?>
<script id="tpl" type="text/html">
    <h1 class="hd"> <%:=article.title%></h1>
    <div class="article-con">
    <%:=article.content%>
    </div>
</script>
<script>
//  console.log(<?php echo $chaid  ?>)
var chaid = <?php echo $chaid= isset($chaid) && !empty($chaid)? $chaid : 'null';  ?>;
  keepData = new Object;
 console.log('chaid')
var mescroll = new MeScroll("mescroll",{
    //设置下拉刷新回调
    down:{
      callback: downCallback,
     
    },

    //设置上拉加载
    up:{
      callback: upCallback,
      // page: {
      //   num: 0, //当前页 默认0,回调之前会加1; 即callback(page)会从1开始
      //   size: 10 //每页数据条数,默认10
      // },
      auto:false,
    }
  });

  //下拉刷新的回调函数 (数据清空)
  function downCallback()
  {
    console.log('down')
    if(chaid != 'null'){
      keepData.idStr = chaid
    }
    console.log('请求前idstr', keepData.idStr)
    // idStr =  chaid + idStr;
    $.ajax({
				url: `bookinfo.php?action=down&downAction=reset&idStr=${ keepData.idStr}`,//
        dataType:"json",
				success: function(data) {
          chaid = 'null'
          var content = data.content
        var totalSize = data.count.c; // 接口返回的总数据量
        keepData.idStr = data.idStr;
       console.log('请求后idstr', keepData.idStr)
       var tpl = document.getElementById('tpl').innerHTML;
          var str = template(tpl, {article:content});
          // $("#articlelist").html("");
          $("#articlelist").append(str);
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
    if(!chaid){
      keepData.idStr = chaid
    }
    console.log('请求前idstr', keepData.idStr)
    // idStr = idStr + chaid
    $.ajax({
      url: `bookinfo.php?action=down&downAction=page&idStr=${ keepData.idStr}`,//
      dataType:"json",
      success: function(data) {
        // var title = data.content.title; 
          var content = data.content;
        var totalSize = data.count.c; // 接口返回的总数据量
        keepData.idStr = data.idStr;
        console.log('请求后idstr', keepData.idStr)
      
          var tpl = document.getElementById('tpl').innerHTML;
          var str = template(tpl, {article:content});
          // $("#articlelist").html("");
          $("#articlelist").append(str);
        mescroll.endSuccess(); //无参. 注意结束下拉刷新是无参的

        //方法二(推荐): 后台接口有返回列表的总数据量 totalSize
        //必传参数(当前页的数据个数, 总数据量)
        // mescroll.endBySize(1, totalSize);
        
      },
      error: function(e) {
        //联网失败的回调,隐藏下拉刷新和上拉加载的状态
        mescroll.endErr();
      }
    });
  }
</script>
<?php } ?>