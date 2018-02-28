<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$CI = get_instance();
$curUser = currentuser_session();
$feeling = $curUser['feeling'];
?>

<ul class="conversation-menu">
    <li><span>How are you feeling?</span></li>
    <?php if ($feeling == '1') { ?>
        <li><a href="javascript:void(0)"><img class="feeling-1" src="<?php echo base_url(); ?>assets/images/like-img.png" alt="" title=""></a></li>
    <?php } else if ($feeling == '0') { ?>
        <li><a href="javascript:void(0)"><img class="feeling-0" src="<?php echo base_url(); ?>assets/images/dislike-img.png" alt="" title=""></a></li>
    <?php } else { ?>
        <li><a href="javascript:void(0)"><img class="feelings" id="feeling-good" src="<?php echo base_url(); ?>assets/images/like-img.png" alt="" title=""></a></li>
        <li><a href="javascript:void(0)"><img class="feelings" id="feeling-bad" src="<?php echo base_url(); ?>assets/images/dislike-img.png" alt="" title=""></a></li>
    <?php } ?>

    <div class="clear"></div>
</ul>

<script>
//FEELING
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
</script>
