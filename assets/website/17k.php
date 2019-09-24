<?php

    $chapterList = array();
  //获取章节列表 
  $str = file_get_contents($url);
  //  file_put_contents("17k1.txt",$str,FILE_APPEND);

  // $str = file_get_contents("17k1.html");
     $listReg = "/<dl class=\"Volume\">\s*<dt>.*<\/dt>(.*)<\/dl>/imsU";
  preg_match($listReg,$str,$res);
  // var_dump($res);die;
  $lilist = $res[1];                           //章节ul列表
//拿出列表中的链接和标题名称
   $liReg = "/<a\starget=\"_blank\"\s*href=\"(.*)\".*>\s*<span.*>(.*)<\/span>\s*<\/a>/misU";
  preg_match_all($liReg,$lilist,$result);
  // var_dump($result);die;
  $urllist = $result[1];                       //每一个章节的链接
  $titlelist = $result[2];                    //章节标题
  foreach($urllist as $key=>$value){
      $urllist[$key] = 'https://www.17k.com' . $value;
  }       
// var_dump($urllist);die;
//根据链接循环获取章节内容                                                  
//   $chapterList = array();
  foreach($urllist as $key => $item){
   $str = file_get_contents($item);
  //  file_put_contents("17content.txt",$str,FILE_APPEND);die;
  //  $str = file_get_contents('17content.html');      //章节页面
     $contentReg = "/<div\s*class=\"p\".*>\s*(.*)<\/div>/imsU";
     preg_match($contentReg,$str,$text);
     $content = strip_tags($text[1]);          //章节文本内容
      $title = $titlelist[$key];                //小说内容对应的章节
                                             // $message = "$title\r\n\r\n $content\r\n\r\n";
                                               // file_put_contents("book1.txt",$message,FILE_APPEND);
//将章节标题与对应内容拼在一个数组     
       $arr = array("title"=>$titlelist[$key],"content"=>strip_tags($content));
       $json = json_encode($arr);
//创建目录       
       $time = date("Ymd",time());-
     $path = APP_PATH."/assets/book/$time";
     if(!is_dir($path)){
       mkdir($path,0777,true);
     }
//创建文件名
     global $Strings;
     $filename = $Strings->randomStr(20,false).".json";
//将数据写入文件，创建成功后将文件数据写入数组
      $length = @file_put_contents($path."/".$filename,$json);
      if($length > 0){
       $chapterList[] = array(
         "register_time"=>time(),
         "title"=>$title,
         "content"=>"/book/$time/$filename",
         "bookid"=>$bookid
        );
      }
    
  }

       //将文件数据传到后台处理  
       if(is_array($chapterList) && count($chapterList)>0){
        $affectRow = $db->addAll("chapter",$chapterList);
        show("该书籍新增了{$affectRow}章内容","chapterget.php");
        exit;
      }else{
        show("当前采集节点无数据","chapterget.php");
        exit;
      }



  