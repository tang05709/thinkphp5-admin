<?php
namespace app\backend\taglib;

use think\template\TagLib;

class Tytag extends TagLib {
 
  protected $tags   =  [
    // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
    'textfield'     => ['attr' => 'label,name,value,help,require', 'close' => 0], //闭合标签，默认为不闭合
    'textareafield'     => ['attr' => 'label,name,value,help', 'close' => 0],
    'filefield'     => ['attr' => 'label,name,value,updir,ftype,help', 'close' => 0],
    'mulfilefield'     => ['attr' => 'label,name,value,updir,help', 'close' => 0],
    'submitfield'     => ['close' => 0],
  ];

  /**
   * text 表单
   * label: 表单标题
   * name： 表单name
   * value： 表单值
   * help： 表单说明
   */
  public function tagTextfield($tag) {
    $html = "<div class='form-group'>";
    if(!empty($tag['require'])) {
      $html .= "<div class='form-label'><em>*</em> ".$tag['label']."</div> <div class='form-input'>";
    } else {
      $html .= "<div class='form-label'>".$tag['label']."</div> <div class='form-input'>";
    }
    if (empty($tag['value'])) {
      $html .= "<input type='text' id='".$tag['name']."' name='".$tag['name']."' placeholder='".$tag['label']."' value='' />";
    } else {
      $html .= "<input type='text' id='".$tag['name']."' name='".$tag['name']."' placeholder='".$tag['label']."' value='";
      $html .= "<?php echo ".$tag['value']."?>";
      $html .= "' />";
    }
    if(!empty($tag['help'])) {
      $html .= "<div class='help-block'><img src='/backend/ui_tip.png' /><p>".$tag['help']."</p></div>";
    }
    $html .= "</div></div>";
   
    return $html;
  } 

  /**
   * textarea 表单
   * label: 表单标题
   * name： 表单name
   * value： 表单值
   * help： 表单说明
   */
  public function tagTextareafield($tag) {
    $html = "<div class='form-group'>";
    $html .= "<div class='form-label'>".$tag['label']."</div> <div class='form-input'>";
    if (empty($tag['value'])) {
      $html .= "<textarea id='".$tag['name']."' name='".$tag['name']."' placeholder='".$tag['label']."'></textarea>";
    } else {
      $html .= "<textarea id='".$tag['name']."' name='".$tag['name']."' placeholder='".$tag['label']."'>";
      $html .= "<?php echo ".$tag['value']."?>";
      $html .= "</textarea>";
    }
    if(!empty($tag['help'])) {
      $html .= "<div class='help-block'><img src='/backend/ui_tip.png' /><p>".$tag['help']."</p></div>";
    }
    $html .= "</div></div>";
   
    return $html;
  } 

  /**
   * 单图片，
   * label: 表单标题
   * name： 表单name
   * updir： 上传路径
   * value： 表单值
   * ftype： 上传类型： image， video
   * help： 表单说明
   */
  public function tagFilefield($tag) {
    $html = "<div class='form-group'>";
    $html .= "<div class='form-label'>".$tag['label']."</div> <div class='form-input media-picker'>";
    $html .= "<a href='javascript:void(0)' class='button media-picker-button' data-id='".$tag['name']."' id='".$tag['name']."_uploader'>";
    $html .= "<span>+</span>";
    if (empty($tag['value'])) {
      $html .= "<input type='hidden' name='".$tag['name']."' upload-path='".$tag['updir']."' value='' />";
    } else {
      $html .= "<input type='hidden' name='".$tag['name']."' upload-path='".$tag['updir']."' value='";
      $html .= "<?php echo ".$tag['value']."?>";
      $html .= "' />";
    }
    $html .="</a>";
    if(!empty($tag['help'])) {
      $html .= "<div class='help-block'><img src='/backend/ui_tip.png' /><p>".$tag['help']."</p></div>";
    }
    $html .= "<ul class='clearfix image-list'>";
    if(!empty($tag['value'])) {
      // 这里不能简单的用if (empty($tag['value'])) 判断，因为$tag['value']实际上是字符串 比如$model['logo']，所以要使用模板标签解析后判断
      $html .= '{if '.$tag['value'].' != ""}';
      if($tag['ftype'] == 'video') {
        $html .= "<li><video controls src='<?php echo ".$tag['value']."?>'></video><span class='delete-image'>✖</span><p><?php echo ".$tag['value']."?></p></li>";
      } else {
        $html .= "<li><img src='<?php echo ".$tag['value']."?>' /><span class='delete-image'>✖</span><p><?php echo ".$tag['value']."?></p></li>";
      }
      $html .= '{/if}';
    }
    $html .= "</ul></div></div>";
   
    return $html;
  } 

  /**
   * 多图片，多图片不考虑视频
   * label: 表单标题
   * name： 表单name
   * updir： 上传路径
   * value： 表单值
   * help： 表单说明
   */
  public function tagMulfilefield($tag) {
    $html = "<div class='form-group'>";
    $html .= "<div class='form-label'>".$tag['label']."</div> <div class='form-input media-picker'>";
    $html .= "<a href='javascript:void(0)' class='button media-picker-button' data-id='".$tag['name']."' id='".$tag['name']."_uploader' data-multiple='multiple'>";
    $html .= "<span>+</span>";
    if (empty($tag['value'])) {
      $html .= "<input type='hidden' name='".$tag['name']."' upload-path='".$tag['updir']."' value='' />";
    } else {
      $html .= "<input type='hidden' name='".$tag['name']."' upload-path='".$tag['updir']."' value='";
      $html .= "<?php echo ".$tag['value']."?>";
      $html .= "' />";
    }
    $html .="</a>";
    if(!empty($tag['help'])) {
      $html .= "<div class='help-block'><img src='/backend/ui_tip.png' /><p>".$tag['help']."</p></div>";
    }
    $html .= "<ul class='clearfix image-list'>";
    if(!empty($tag['value'])) {
      // 这里不能简单的用if (empty($tag['value'])) 判断，因为$tag['value']实际上是字符串 比如$model['logo']，所以要使用模板标签解析后判断
      $html .= '{if '.$tag['value'].' != ""}';
      $html .= "<li><img src='<?php echo ".$tag['value']."?>' /><span class='delete-image'>✖</span><p><?php echo ".$tag['value']."?></p></li>";
      $html .= '{/if}';
    }
    $html .= "</ul></div></div>";
   
    return $html;
  } 

  public function tagSubmitfield() {
    $html = "<div class='form-group'>";
    $html .= "<div class='form-label'>&nbsp;</div> <div class='form-input'>";
    $html .= "<input type='submit' class='btn-submit' value='提 交' /></div></div>";
    return $html;
  }
  
  
}
?>