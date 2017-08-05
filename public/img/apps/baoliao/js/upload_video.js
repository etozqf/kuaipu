// Generated by CoffeeScript 1.6.1
(function() {
  var bindClose, confirmDialog, init, template, videoUploadDialog, videoUploader;

  template = [
    '<div id="videoDialogHead" class="video-dialog-head">',
      '<div class="item first" url="?app=baoliao&controller=index&action=video">插入视频链接</div>',
      '<div class="item" url="?app=cloud&controller=video56&sid=baoliao">上传56视频</div>',
      '<div class="item" url="?app=video&controller=vms&action=index&sid=baoliao">上传本地视频</div>',
    '</div>',
    '<div class="clear"></div>',
    '<div id="videoDialogBody" class="video-dialog-body"></div>',
    '<div id="dialog_close" class="dialog-close ie6Opacity video-dialog-close" classname="dialog-close ie6Opacity"></div>'].join('\r\n');

  videoUploadDialog = confirmDialog = null;

  cmstop.fet("" + IMG_URL + "apps/baoliao/css/video.css");

  cmstop.fet("" + IMG_URL + "js/lib/dialog/style.css");

  cmstop.fet("" + IMG_URL + "js/lib/cmstop.dialog.js", function() {
    videoUploadDialog = new window.dialog({
      width: 400,
      height: 392,
      hasOverlay: 1,
      html: template
    });
    return confirmDialog = new window.dialog({
      width: 345,
      height: 170
    });
  });

  init = function(videoDialogBody, callback) {
    var videoDialogHead;
    videoDialogHead = $('#videoDialogHead');
    if (!allowedLocalVideo) {
      videoDialogHead.children('.item').eq(2).remove();
    }
    if (!allowed56Video) {
      videoDialogHead.children('.item').eq(1).remove();
    }
    videoDialogHead.children('.item').bind('click', function(event) {
      var ifm, item, url;
      item = $(event.currentTarget);
      if (item.hasClass('cur')) {
        return;
      }
      url = item.attr('url');
      ifm = $('<iframe src="' + url + '" border="0" frameborder="0"></iframe>');
      videoDialogBody.empty().append(ifm);
      item.parent().children('.cur').removeClass('cur');
      item.addClass('cur');
      return bindClose(ifm, callback);
    }).eq(0).trigger('click');
    return $('#dialog_close').bind('click', function() {
      var ifm, input, _close;
      _close = function() {
        callback($.cookie(COOKIE_PRE + 'video'));
        return videoUploadDialog.close();
      };
      ifm = $('#videoDialogBody').children('iframe');
      if (ifm.attr('src') === '?app=baoliao&controller=index&action=video') {
        input = ifm[0].contentDocument.getElementById('video');
        if (input && input.value !== '') {
          if (confirmDialog.isOpen) {
            return {
              hasOverlay: 1
            };
          }
          confirmDialog.open({
            confirm: function() {
              return _close();
            },
            text: '你确定要关闭吗？若点击确定，则视频会添加失败。'
          });
          return;
        }
      }
      return _close();
    });
  };

  bindClose = function(iframe, callback) {
    var refreshCount;
    refreshCount = 0;
    return iframe.bind('load', function() {
      if (refreshCount++ === 7) {
        videoUploadDialog.close();
        return callback($.cookie(COOKIE_PRE + 'video'));
      }
    });
  };

  videoUploader = function(callback) {
    var refreshCount;
    if (videoUploadDialog.isOpen || videoUploadDialog === null) {
      return;
    }
    if ($('#attachment_video').length > 0) {
      return;
    }
    videoUploadDialog.open();
    setTimeout(function() {
      var videoDialogBody;
      videoDialogBody = $('#videoDialogBody');
      return init(videoDialogBody, callback);
    }, 10);
    return refreshCount = 0;
  };

  $.fn.extend({
    videoUploader: function(callback) {
      return $.each(this, function(i, k) {
        $(k).bind('click', function(event) {
          event.preventDefault();
          $.cookie("" + COOKIE_PRE + "video", null, {
            'expires': -1,
            'domain': COOKIE_DOMAIN
          });
          return videoUploader(callback);
        });
        return true;
      });
    }
  });

}).call(this);