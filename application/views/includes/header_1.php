<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$CI = & get_instance();
$curUser = currentuser_session();
$loggedIn = $curUser['loggedIn'];
$success = $CI->session->flashdata('success');
$error = $CI->session->flashdata('error');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Reellyou</title>
        <!---Fonts--->
        <link href="https://fonts.googleapis.com/css?family=Asap|Rubik:300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/js/jcrop/css/jquery.Jcrop.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/css/jquery-ui-1.10.3.custom.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jQuery-File-Upload/css/jquery.fileupload.css">
        <!--<link rel="stylesheet" href="<?php // echo base_url();  ?>assets/fancybox/dist/jquery.fancybox.min.css">-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo base_url(); ?>assets/jquery/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/jquery/js/jquery-ui-1.10.3.custom.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.css" />
        <script src="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.js"></script>
   




        <script type="text/javascript">
            $(document).ready(function () {

                window.base_url = "<?php echo base_url();?>";

                //hide the messages
                setTimeout(function () {
                    $(".messages").hide('blind', {}, 500)
                }, 5000);
            });
        </script>

    </head>
    <body>
        <div class="text-center">
            <div class="col-xs-8 messages-container"  style="float: none;margin: 0 auto;">
                <!--<div class="alert alert-success  messages">Operation successfully completed.</div>-->
                <?php if ($error) { ?>
                    <div class="alert alert-danger messages"><?php echo $error; ?></div>
                <?php }if ($success) { ?>
                    <div class="alert alert-success  messages"><?php echo $success; ?></div>
                <?php } ?>
            </div>
        </div>

