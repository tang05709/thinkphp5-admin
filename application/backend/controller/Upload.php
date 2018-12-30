<?php

namespace app\backend\controller;

use think\Controller;
use think\Request;
use uploader\Uploads;

class Upload extends Controller
{
  public function upload(Request $request) {
    $files = $request->file("file");
    $updir = $request->post('updir');
    $res = Uploads::upmedias($files, $updir);
    return json_encode($res);
  }

  public function del_upload(Request $request) {
    $res = ['errno' => 1, 'errmsg' => '删除失败'];
    $filename = $request->post('filename');
    if(!empty($filename)) {
      @unlink($_SERVER['DOCUMENT_ROOT'] . $filename);
      $res = ['errno' => 0, 'errmsg' => $filename];
    }
    return json_encode($res);
  }

  public function detail_upload(Request $request) {
    $action = $request->get('action');
    $config = [
      "imageActionName" => "uploadimage", 
      "imageFieldName" => "upfile",
      "imageMaxSize" => 2048000,
      "imageAllowFiles" => [".png", ".jpg", ".jpeg", ".gif"], 
      "imageUrlPrefix" => "",
      "imagePathFormat" => "details/images",
      
      "snapscreenActionName" => "uploadimage", 
      "snapscreenPathFormat" => "details/images", 
      "snapscreenUrlPrefix" => "", 
      "snapscreenInsertAlign" => "none", 

      "videoActionName" => "uploadvideo", 
      "videoFieldName" => "upfile",
      "videoPathFormat" => "details/videos", 
      "videoUrlPrefix" => "",
      "videoMaxSize" => 102400000, 
      "videoAllowFiles" => [".mp4", ".webm", ".avi", ".3gp"], 

      "fileActionName" => "uploadfile", 
      "fileFieldName" => "upfile", 
      "filePathFormat" => "details/files", 
      "fileUrlPrefix" => "", 
      "fileMaxSize" => 51200000, 
      "fileAllowFiles" => [".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf"],
    ];
    switch ($action) {
      case 'config':
        $res = $config;
        break;
      case 'uploadimage':
        $files = $request->file("upfile");
        $updir = $config['imagePathFormat'];
        $res = Uploads::updetails($files, $updir);
        break;
      case 'uploadvideo':
        $files = $request->file("upfile");
        $updir = $config['videoPathFormat'];
        $res = Uploads::updetails($files, $updir);
        break;
      case 'uploadfile':
        $files = $request->file("upfile");
        $updir = $config['filePathFormat'];
        $res = Uploads::updetails($files, $updir);
        break;
      default:
        break;
    }
    return json_encode($res);
  }

}

?>