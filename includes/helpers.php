<?php
function checkLogin($location=false,$url=''){
   global $db;
   $adminid = isset($_SESSION['adminid']) ? $_SESSION['adminid'] :0;
   $username = isset($_SESSION['username']) ? $_SESSION['username']:'';

   if(!$adminid || empty($username)){
    session_unset();
    show('登录过期，用户名无效，请重新登录:','login.php');
   }else{
     $where =array(
      "id"=>$adminid,
      "username"=>$username
  );

  $admin = $db->select()->from("admin")->where($where)->find();
  // var_dump($admin);die;
  if(!$admin)
    {
      session_unset();
      show('不存在该用户,请重新登录','login');
    }
    if($location)
    {
      //location 等于true 说明要跳转
      if($url)
      {
        //给了地址就跳转指定地址
        header("Location:$url");
        exit;
      }else{
        //没有地址就跳转到默认首页
        header("Location:index.php");
        exit;
      }

    }
   }
}
function show($msg="",$url=""){
  @header("Content-Type:text/html;charset=utf-8");
  if(empty($url)){
    echo "<script>alert('$msg');history.go(-1);</script>";
    exit;
  }else{
    echo "<script>alert('$msg');location.href='$url';</script>";
    exit;
  }
}



//得到当前网址
function get_url(){
	$str = $_SERVER['PHP_SELF'].'?';
	if($_GET){
		foreach ($_GET as $k=>$v){  //$_GET['page']
			if($k!='page'){
				$str .= $k.'='.$v.'&';
			}
		}
	}
	return $str;
}
//分页函数
/**
 *@pargam $current	当前页
 *@pargam $count	记录总数
 *@pargam $limit	每页显示多少条
 *@pargam $size		中间显示多少条
 *@pargam $class	样式
*/
function page($current,$count,$limit,$size,$class='sabrosus'){
  // echo $current,',',$count,',',$limit,',',$size;
  $str='';
  if($count>$limit){
    $pages =ceil($count/$limit);
    $url = get_url();
    $str .='<div class="'.$class.'">';

    if($current==1){
      $str.='<span class="disabled">首&nbsp;&nbsp;页</span>';
			$str.='<span class="disabled">  &lt;上一页 </span>';
    }else{
      $str.='<a href="'.$url.'page=1">首&nbsp;&nbsp;页 </a>';
			$str.='<a href="'.$url.'page='.($current-1).'">  &lt;上一页 </a>';
    }

    if($current<=floor($size/2)){
      $star=1;//2   6/3
      $end=$pages >$size ? $size : $pages;//
    }else if($current>=$pages - floor($size/2)){//4  6-(6/2)
      $star=$pages-$size+1<=0?1:$pages-$size+1; //避免出现负数
			$end=$pages;
    }else{
      $d=floor($size/2);
			$star=$current-$d;
			$end=$current+$d;
    }

    for($i=$star;$i<=$end;$i++){
      if($i==$current){
				$str.='<span class="current">'.$i.'</span>';	
      }else{
				$str.='<a href="'.$url.'page='.$i.'">'.$i.'</a>';
      }
    }
    if($pages==$current){
      $str .='<span class="disabled">  下一页&gt; </span>';
			$str.='<span class="disabled">尾&nbsp;&nbsp;页  </span>';
    }else{
      $str.='<a href="'.$url.'page='.($current+1).'">下一页&gt; </a>';
			$str.='<a href="'.$url.'page='.$pages.'">尾&nbsp;&nbsp;页 </a>';
    }
    $str.='</div>';
  }
  return $str;
}
