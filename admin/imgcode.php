<?php
    function get_rand_str($length = 4){
      $chars = '1234567890ABCDEFGHJKLMNPQRSTUVWXYZ';
      $str = str_shuffle($chars);
      $str = substr($str,0,$length);
      $str = strtolower($str);
      return $str;
    }
     
    $width =130;
    $height =40;
    $img = imagecreatetruecolor($width,$height);
    $backgroundcolor = imagecolorallocate($img,74,147,233);
    imagefilledrectangle($img,0,0,$width,$height,$backgroundcolor);

    $textcolor = imagecolorallocate($img,255,255,255);
    $code = get_rand_str();
    imagettftext($img,30,0,21,32,$textcolor,"../assets/admin/fonts/AquaKana.ttc",$code);
  
     for($i=0;$i<=1000;$i++){
     $color = imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
     $x = mt_rand(0,$width);
     $y = mt_rand(0,$height);
      imagesetpixel($img,$x,$y,$color);
   }

   session_start();
   $_SESSION['imgcode'] = $code;
   
    header("Content-Type:image/png");  
    imagepng($img);
    imagedestroy($img);
   
    
?>