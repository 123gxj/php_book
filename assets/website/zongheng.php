<?php

    $chapterList = array();
  //获取章节列表 
   $str = file_get_contents($url);
    // echo $str;die;
  $listReg = "/<ul class=\"chapter-list clearfix\">\s*<li.*>(.*)<\/li>\s*<\/ul>/imsU";
  preg_match($listReg,$str,$res);
  $lilist = $res[1]; 
  // echo $lilist;die;                          //章节ul列表
//拿出列表中的链接和标题名称
   $liReg = "/<a.*href=\"(.*)\".*>(.*)<\/a>/misU";
  preg_match_all($liReg,$lilist,$result);
  $urllist = $result[1];                       //每一个章节的链接
  $titlelist = $result[2];                    //章节标题
  //  var_dump($result);die;                                           //  file_put_contents('urllist.txt', $urllist,FILE_APPEND);
//根据链接循环获取章节内容                                                  
//   $chapterList = array();
  foreach($urllist as $key => $item){
   $str = file_get_contents($item);
  //  $str = file_get_contents('text.html');      //章节页面
     $contentReg = "/<div\s*class=\"content\"\s*.*>(.*)<\/div>/imsU";
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
        show("该书籍新增了{$affectRow}章内容","booklist.php");
        exit;
      }else{
        show("当前采集节点无数据","booklist.php");
        exit;
      }



  