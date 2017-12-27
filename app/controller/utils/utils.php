<?php
namespace Controller\Utils;

use Controller\User\Profile;
use Controller\Employer\Detail;
use Controller\Volunteer\VolunteerController;

class Utils {
  public static function time_elapsed_string($date, $granularity=1, $full = false)
  {
    $retval = '';
    $date = strtotime($date);
    $difference = time() - $date;
    $periods = array('decade' => 315360000,
        'year' => 31536000,
        'month' => 2628000,
        'week' => 604800,
        'day' => 86400,
        'hr' => 3600,
        'min' => 60,
        'sec' => 1);

    if($difference == 0){
      return 'justnow';
    }else{
      foreach ($periods as $key => $value) {
          if ($difference >= $value) {
              $time = floor($difference/$value);
              $difference %= $value;
              $retval .= ($retval ? ' ' : '').$time.' ';
              $retval .= (($time > 1) ? $key.'s' : $key);
              $granularity--;
          }
          if ($granularity == '0') { break; }
      }
      return $retval . ' ago';
    }
  }

  public static function removeProPic($id){
    $target_dir = "uploads/profile_image/";
    $currentPic = Profile::getProPic($id);
    if($currentPic == "default.png"){
      return false;
    }else{
      $target_file = $target_dir . $currentPic;
      if(unlink($target_file)){
        Profile::changeProfilePic($id, "default.png");
        $result = array(
            'status' => true,
            'url' => '/'.$target_dir."default.png",
            'id' => $id
        );
        echo json_encode($result);
      }else{
        $result = array(
          'status' => false
        );
        echo json_encode($result);
      }
    }
  }

  public static function removeLogo($id){
    $target_dir = "uploads/logo_images/";
    $currentPic = Detail::getLogo($id);
    if($currentPic == "default.png"){
      return false;
    }else{
      $target_file = $target_dir . $currentPic;
      if(unlink($target_file)){
        Detail::changeLogo($id, "default.png");
      }
    }
  }

  public static function uploadPic($file, $uploader, $user = true, $filename = NULL){
    if($user){
      $group = Profile::getUserGroup($uploader);

      if($group == 2){
        $target_dir = "uploads/logo_images/";
        Utils::removeLogo($uploader);
      }else{
        $target_dir = "uploads/profile_image/";
      }

    }else{
      $target_dir = "uploads/volunteer_image/";
    }

    if($filename != NULL){
      $basename = $filename;
    }else{
      $basename = basename($file["name"]);
    }

    $target_file = $target_dir . $basename;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $newname = md5(uniqid(rand(), true));
    $newfilename = $target_dir . $newname . "." .$imageFileType;

    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
        $error = 1;
    } else {
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $uploadOk = 0;
        $error = 2;
    }

    if ($uploadOk == 0) {
      $result = array(
        'status' => false, 'error' => $error
      );
      echo json_encode($result);
    } else {
        if (move_uploaded_file($file["tmp_name"], $newfilename)) {
          if($user){
            if($group == 2){
              Detail::changeLogo($uploader, $newname.".".$imageFileType);
            }else{
              Profile::changeProfilePic($uploader, $newname.".".$imageFileType);
            }
          }else{
            VolunteerController::changeProfilePic($uploader, $newname.".".$imageFileType);
          }

          $result = array(
              'status' => true,
              'group' => $group,
              'url' => '/'.$newfilename,
              'uploader' => $uploader
          );
          echo json_encode($result);
        } else {
          $error = 3;
          $result = array(
            'status' => false, 'error' => $error
          );
          echo json_encode($result);
        }
    }
  }

  public static function passhash($pass){
    $salt = sha1(md5($pass));
    $newpass = md5($pass.$salt);
    return $newpass;
  }

  public static function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
  }
}
