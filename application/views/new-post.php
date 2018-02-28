<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$curUser = currentuser_session();
$feeling = $curUser['feeling'];
?>

<!--Content-->

<div class="center-content  new-post-page">
                        <div class="row post-header">
                            <div class="col-sm-6">
                                <h3 class="name"><?php echo $userData['first_name'].' '.$userData['last_name']; ?></h3>
                            </div>
                            <div class="col-sm-6 text-right">
                                <h4>How are you feeling? 
                                <?php if ($feeling == '1') { ?>
                                <a href="javascript:void(0)"><i class="fa fa-thumbs-up feeling-1" aria-hidden="true"></i></a>
                                
                                <?php }else if ($feeling == '0') { ?>
                                <a href="javascript:void(0)"><i class="fa fa-thumbs-down feeling-0" aria-hidden="true"></i></a>
                                <?php }else{?>
                                <a href="javascript:void(0)" id="feeling-good" class="feelings"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
                                <a href="javascript:void(0)" id="feeling-bad" class="feelings"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
                                <?php }?>
                                
                                </h4>
                                
                            </div>
                           
                        </div>
                         <hr/>
                         <div class="row post-body">
                             <div class="col-sm-12">
                                <h3 class="blue-bg">Upload Media</h3>
                                <div class="media-icons marginTop10">
                                    <div class="col-sm-3 col-xs-6">
                                        <a href="javascript:void(0)" id="image-post-btn"><img src="<?php echo base_url()?>assets/images/camera-img.png" alt="" title=""></a>
                                    </div>

                                    <div class="col-sm-3 col-xs-6">
                                        <a href="javascript:void(0)" id="text-post-btn"><img src="<?php echo base_url()?>assets/images/txt-img.png" alt="" title=""></a>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <hr>
                             </div>
                         </div>
                         <div class="row post-form">
                             <div class="col-sm-12">
                                 <form action="" method="POST" class="form-horizontal" role="form">
                                        <div class="form-group">
                                             <div class="col-sm-6">
                                             	<input type="text" name="title" id="title" class="form-control" placeholder="Enter Title"/>
                                             
                                             </div>
                                         </div>
                                         <div class="form-group hidden text-container">
                                             <div class="col-sm-6">
                                             <textarea class="form-control" cols="30" rows="10" id="text-content" name="text-content" placeholder="Write your text here"></textarea>
                                             
                                             </div>
                                         </div>
                                         
                                         <div class="form-group image-container">
                                             <div class="col-sm-6">
                                            <div class="container">


                                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                                            <span class="btn btn-success fileinput-button">
                                                                <i class="glyphicon glyphicon-plus"></i>
                                                                <span>Add files...</span>
                                                                <!-- The file input field used as target for the file upload widget -->
                                                                <input class="form-control" id="fileupload" type="file" name="files[]" multiple>
                                                            </span>

                                                            <br>

                                                            <!-- The container for the uploaded files -->
                                                            <div id="files" class="files"></div>
                                                            <br>
                                                            <div id="progress" class="progress col-sm-3" style="padding:0px;">
                                                                <div class="progress-bar progress-bar-success"></div>
                                                            </div>

                                                        </div>
                                             
                                             </div>
                                         </div>
                                         
                                         
                                         
                                         <div class="form-group">
                                             <div class="col-sm-6 post-btns" id="change-btn">
                                                 <button type="button" id="post-all" class="blue-btn">Post</button>
                                             </div>
                                         </div>
                                 </form>
                             </div>
                         </div>
                            
                            
                        </div>




	
<script type="text/javascript">
    $(document).ready(function () {
		
		
		$('.feelings').on('click', function () {
        var feeling = $(this).attr('id');
        $.ajax({
            url: window.base_url + 'Users/feeling',
            dataType: "json",
            method: "POST",
            data: {
                value: feeling
            },
            success: function (data) {
                console.log(data.feeling);
                if (data.feeling == 1) {
                    $('#feeling-bad').addClass('hidden');
                } else if (data.feeling == 0) {
                    $('#feeling-good').addClass('hidden');
                }
            }
        });
    });
		
		
//        tag a friend
        $('#title').on('keyup', function (e) {
            var input = $(this).val();
//            console.log(input.substr(input.indexOf("@") + 1));
            if ($('#title').val().indexOf('@') > -1) {
                $("#title").autocomplete({
                    source: function (request, response) {

                        $.ajax({
                            url: window.base_url + 'Users/search_user',
                            dataType: "json",
                            data: {
                                value: input.substr(input.indexOf("@") + 1)
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        var inputVal = input.substr(0, input.indexOf('@'));
                        var temp = '<input type="hidden" value="' + ui.item.id + '" name="tag-user[]"/>';
                        $(temp).appendTo($('#title'));
//                        console.log(inputVal);
                        $('#title').val(inputVal.concat(ui.item.name));
                    }
                });
            }
        });




        $(document).on('click', '#post_text', function(){
			
            var content = $('#text-content').val();
            var title = $('#title').val();

            var values = [];
            $('input[name="tag-user[]"]').each(function () {
                values.push($(this).val());
            });
            if (title.length == 0 || content.length == 0) {
                return false;
            }
            var data = 'content=' + content + '&title=' + title + '&tagUser=' + values;

            $.ajax({
                url: window.base_url + 'Profile/post_text',
                data: data,
                type: 'POST',
                success: function (postBack) {
                    var result = $.parseJSON(postBack);
//                    console.log(result);return;
                    if (result.msg == 1) {
                        window.location.href = window.base_url + 'Profile/timeline';
                    } else {
                        var error = '<span class="error">Error: please try again.</span>';
                        $(error).appendTo('#text-content');
                    }
                }
            });
        });

        $('#text-post-btn').click(function () {
            $('.text-container').removeClass('hidden');
            $('.image-container').addClass('hidden');
			$('#change-btn').html('<button type="button" id="post_text"  class="blue-btn">Post</button>');
        });

        $('#image-post-btn').click(function () {
            $('.image-container').removeClass('hidden');
            $('.text-container').addClass('hidden');
			$('#change-btn').html('<button type="button" id="post-all" class="blue-btn">Post</button>');
        });
    }
    );

    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url(); ?>assets/jQuery-File-Upload/server/php/',
                allData = [],
                uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function () {
                    var $this = $(this),
                            data = $this.data();

                    $this.off('click')
                            .text('Abort')
                            .on('click', function () {
                                $this.remove();
                                data.abort();
                            });
                    data.submit().always(function () {
                        $this.remove();
                    });
                });
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 999000,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true,

        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);



            });
//            $("#post-all").off('click').on('click', function (e) {
//                e.preventDefault();
//                data.title = $('#title').val();
//                data.submit();
//            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
            if (file.preview) {
                node
                        .prepend('<br>')
                        .prepend(file.preview);
            }
            if (file.error) {
                node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button').remove();
//                        .text('Upload')
//                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function (e, data) {

            $.each(data.result.files, function (index, file) {
                allData.push(file);
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
            //                console.log(file);
            $("#post-all").off('click').on('click', function (e) {
                e.preventDefault();
                var postData = [];
                postData['images'] = $.map(allData, function (el) {
                    return el.name;
                });
                var title = $('#title').val();
                var tagUser = $('input[name=tag-user]').val();
//                console.log(tagUser);
//                return;
//                console.log(postData);
//                return;
                var data = 'images=' + postData['images'] + '&title=' + title + '&type=1';
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>Profile/upload_post',
                    data: data,
                    success: function (callBack) {
//                        var data = $.parseJSON(callBack);
                        $("#post-all").remove();
                        $(".post-btns").html('<span class="alert alert-success marginTop10">Data uploaded successfully.</span>');
                        setTimeout(function () {
                            window.location.href = window.base_url + 'Profile/timeline';
                        }, 2000);
                    }
                });
            });

        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>