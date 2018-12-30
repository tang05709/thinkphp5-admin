$(document).ready(function() {
  $('.delete-operate').each(function() {
    $(this).click(function() {
      var url = $(this).attr('data-url');
      if(confirm("是否要删除")) {
        $.post(
            url, 
            { 
                "_method":  'DELETE'
            },
            function(data) {
              alert(JSON.parse(data));
              window.location.reload();
            }
        );
      }
    })
  })

  /**
   * 栏目页面点击展开
   */
  $(".taxons-list li").each(function() {
    var id = $(this).attr('data-id');
    var next_node = $('.parent_'+id);
    $(this).find('.taxon-name>img').click(function() {
      if (next_node.hasClass('taxon-hide')) {
        $(this).attr('src', 'no_children.gif');
        next_node.removeClass('taxon-hide');
      } else {
        if (next_node.length != 0) {
          $(this).attr('src', 'has_children.gif');
        } 
        //  如果还有第三级
        if (next_node.length > 0) {
          for(i = 0; i<next_node.length; i++) {
            var text = next_node[i]; // 这里获取到的是html字符串，需要把它转为dom对象，否则获取不到data-id
            var next_id = $(text).attr('data-id'); // 转为dom对象 $(text)
            var next_next_node = $('.parent_'+next_id);
            if (next_next_node.length > 0) {
              next_node.find('.taxon-name img').attr('src', 'has_children.gif');
              next_next_node.addClass('taxon-hide');
            }
          }
        }
        next_node.addClass('taxon-hide');
      }
    })
  }) 

  /**
   * 顶部菜单图标点击显示或隐藏左侧菜单
   */
  $('.show-aside').click(function() {
    if ($('.main-aside').hasClass('main-aside-hide')) {
      $('.main-aside').removeClass('main-aside-hide');
      $('.main-header').removeClass('main-header-screen');
      $('.main-body').removeClass('main-body-screen');
    } else {
      $('.main-aside').addClass('main-aside-hide');
      $('.main-header').addClass('main-header-screen');
      $('.main-body').addClass('main-body-screen');
    }
  })

  /**
   * 列表页面如果有三级菜单显示多级选择
   */
  $('.breadcrumb-add').hover(function() {
    $(this).find('.more-add').toggle();
  })

  /**
   * 导航选中
   */
  var current_url = window.location.href;
  $('.main-aside .main-menu ul li').each(function() {
    var the_url = $(this).find('a').attr('href');
    if (current_url.indexOf(the_url) > -1) {
      var parent_dom = $(this).parent();
      if (parent_dom.attr('class') == 'aside-root') {
        $(this).addClass('active');
      } else {
        var data_parent = $(this).attr('data-topparent');
        $('.main-aside .main-menu ul li.top-parent-'+data_parent).addClass('active');
      }
    }
    
  })

  /**
   * 点击全选
   */
  $('.main-list tfoot .checkall').click(function() {
    var is_check = $(this).prop('checked');
    $('.main-list tbody .list-check').attr("checked", is_check);
  })

  /**
   * 批量删除按钮
   */
  $('.main-list tfoot .delete').click(function() {
    var ids = new Array();
    var url = $(this).attr('data-url');
    $('.main-list tbody .list-check').each(function() {
      if($(this).prop('checked')) {
        ids.push($(this).val());
      }
    })
    if(ids.length > 0) {
      if(confirm("是否要删除")) {
        $.post(
            url, 
            { 
              ids: ids.join(',')
            },
            function(data) {
              alert(JSON.parse(data));
              window.location.reload();
            }
        );
      }
    }
  })

  /**
   * 批量转移按钮
   */
  $('.main-list tfoot .move').click(function() {
    var module_name = $('.taxon-alert-box .module').val();
    // 根据module获取到相同类型的栏目
    $.post(
      '/backend/get_move_module', 
      { 
        module: module_name
      },
      function(data) {
        if(data != null) {
          var module_list = JSON.parse(data);
          // 选项前面的空格
          var module_options = '<option value="">请选择</option>';
          for(i = 0; i < module_list.length; i++) {
            var options_style = '';
            if (module_list[i].level == 2) {
              options_style = "&nbsp;&nbsp;&nbsp;&nbsp;";
            } else if (module_list[i].level == 3) {
              options_style = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            }
            // 如果有子栏目则不允许选择父级栏目
            if (module_list[i].has_children) {
              module_options += "<option value=''>" + options_style + module_list[i].name +"</option>";
            } else {
              module_options += "<option value='"+ module_list[i].id +"'>" + options_style + module_list[i].name +"</option>";
            }
          }
          $('.taxon-alert-box .module-list').html(module_options);
        }
      }
    )
    $('.taxon-alert-box').show();
  })

  /**
   * 转移栏目的错误提示
   * @param  error 
   */
  function taxon_alert_error (error) {
    $('.taxon-alert-box .error').html(error);
      $('.taxon-alert-box .error').show();
      // 1秒后关闭
      setTimeout(function(){ 
        $('.taxon-alert-box .error').hide();
        $('.taxon-alert-box').hide();
    }, 1000)
  }

  /**
   * 批量转移确认按钮
   */
  $('.taxon-alert-box .sure').click(function() {
    var ids = new Array();
    $('.main-list tbody .list-check').each(function() {
      if($(this).prop('checked')) {
        ids.push($(this).val());
      }
    })
    if (ids.length > 0) {
      // 获取选项值，如果为空则提示
      var selected_value = $('.taxon-alert-box .module-list').val();
      if (selected_value == "") {
        taxon_alert_error('请选择一项或只能选择子栏目！');
      } else {
        var module_name = $('.taxon-alert-box .module').val();
        $.post(
          '/backend/' + module_name + '/change_taxon', 
          { 
            tid: selected_value,
            ids: ids.join(',')
          },
          function(data) {
            alert(JSON.parse(data));
            window.location.href = '/backend/' + module_name + '?tid=' + selected_value;
          }
      );
      }
    } else {
      taxon_alert_error('请至少选择一列！');
    }
  })

  /**
   * 关闭提示
   */
  $('.taxon-alert-box .cancel').click(function() {
    $('.taxon-alert-box').hide();
  })
})