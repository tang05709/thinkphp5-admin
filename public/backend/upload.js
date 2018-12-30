var image_files = new Array(); // 多图片上传临时保存
$(document).ready(function() {
  $('.media-picker').each(function() {
    var el = $(this);
    var elbtn = el.find('.media-picker-button');
    var multi_selection = false;
    var inputField = el.find('input[type=hidden]');
    // 是否多文件上传
    if(elbtn.attr('data-multiple') == 'multiple') {
      multi_selection = true;
    }
    // 上传目录
    var upload_path = inputField.attr('upload-path');
    var uploader = new plupload.Uploader({
      runtimes : 'html5,flash,silverlight,html4',
      browse_button : elbtn.attr('data-id') + '_uploader', 
      multi_selection: multi_selection,
      auto_start: true,
      flash_swf_url : '../plugins/plupload/js/Moxie.swf',
      silverlight_xap_url : '../plugins/plupload/js/Moxie.xap',
      url : '/backend/upload',
      
      filters: {
        mime_types : [ //只允许上传图片和zip,rar文件
        { title : "Image files", extensions : "jpg,jpeg,gif,png,bmp" }, 
        { title : "Video files", extensions : "mp4,3gp" }
        ],
        max_file_size : '10mb', //最大只能上传10mb的文件
        prevent_duplicates : false //不允许选取重复文件
      },

      init: { 
        PostInit: function() {},

        BeforeUpload: function(up, file) {
          up.setOption('multipart_params', {'updir': upload_path})
        },

        FilesAdded: function(up) {
          up.start(); //选择完后直接上传
        },

        FileUploaded: function(up, file, info) {
          if (info.status == 200)
          {
            var file_type = file.type;
            var is_image = file_type.indexOf('image');
            var is_video = file_type.indexOf('video');
            // 解析返回的数据
            var result = JSON.parse(info.response);
            var img_list = "";
            if(result.errno == 0) {
              // 返回的图片上传结果
              var file_name = result.data; 
              if(multi_selection) {
                //  多图片上传不考虑视频
                if (is_image > -1) {
                  // 存入临时数组
                  image_files.push(file_name);
                  inputField.val(JSON.stringify(image_files));
                  for (var i = 0; i < image_files.length; i++) {
                    img_list += "<li><img src='"+image_files[i]+"' /><span class='delete-image'>✖</span><p>"+image_files[i]+"</p></li>";
                  }
                }
              } else {
                inputField.val(file_name);
                if (is_image > -1) {
                  img_list = "<li><img src='"+result.data+"' /><span class='delete-image'>✖</span><p>"+result.data+"</p></li>";
                }
                if (is_video > -1) { 
                  img_list = "<li><video controls src='"+result.data+"'></video><span class='delete-image'>✖</span><p>"+result.data+"<p></li>";
                }
              }
              el.find('.image-list').html(img_list);
            } else {
              alert(result.errmsg);
            }
          }
          else
          {
            alter(info.response);
          } 
        },

        Error: function(up, err) {
          alert(err.response);
        }
      }
    })
    uploader.init();


    // 删除
    if (multi_selection) {
      el.on('click', '.delete-image', function() {
        var file_name = inputField.val();
        var elDel = $(this);
        // 得到filename
        var current_file_name = elDel.next('p').html();
        // 删除当前的父级li
        elDel.parent().remove();
        // 重新赋值数组
        var new_image_files = new Array();
        if (image_files != '') {
          new_image_files = image_files;
        } else {
          new_image_files = $.parseJSON(file_name);
        }
        // 去掉数组中的当前值
        new_image_files.pop(current_file_name);
        $.ajax({
            type: "POST",
            url: "/backend/del_upload",
            data: "filename=" + current_file_name,
            success: function(msg) {
                console.log(msg)
            }
        });
        inputField.val(JSON.stringify(new_image_files));
      });
    } else {
      el.on('click', '.delete-image', function(){
        // 显示值为空
        var file_name = inputField.val();
        el.find('.image-list').html('');
        inputField.val('');
        $.ajax({
          type: "POST",
          url: "/backend/del_upload",
          data: "filename=" + file_name,
          success: function(msg) {
              console.log(msg)
          }
        });
      });
    }
  })
})