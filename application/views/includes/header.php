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
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Reelyou</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
        <!-- Font awesome -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
        <!-- BootStrap -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <!-- Style -->
        
        <link href="<?php echo base_url(); ?>assets/js/jcrop/css/jquery.Jcrop.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/css/jquery-ui.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jQuery-File-Upload/css/jquery.fileupload.css">
        <!-- jQuery (necessary for JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Custom scripts -->
        <script src="<?php echo base_url(); ?>assets/jquery/js/jquery-ui-1.12.1.js"></script>


        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.css" />
        <script src="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
        
        <?php if (isset($loginPage)) { ?>
            <link href="<?php echo base_url(); ?>assets/css/style2.css" rel="stylesheet">
            <?php
        }
        else {
            ?>
            <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <?php } ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->



        <script type="text/javascript">
		function update_notification() {
		 $.ajax({
                url: window.base_url + 'main/update_notification',
                type: "POST",
                success: function (data)
                {
					
					$('#not_total').empty();
                }
            });
		
				}
		
            $(document).ready(function () {
				
				
		
				
				

                window.base_url = "<?php echo base_url(); ?>";
                //notifications
//                loadlink(); // This will run on page load
//                setInterval(function () {
//                    loadlink() // this will run after every 5 seconds
//                }, 10000);

                //hide the messages
                setTimeout(function () {
                    $(".messages").hide('blind', {}, 500)
                }, 5000);
            });
//            function loadlink() {
//
////        console.log('left menu reloaded');
//                $('.left-side-notifications').load(window.base_url + 'Main/left_menu_notifications').fadeIn("slow");
//            }
        </script>
    </head>
    <body>
        <div class="wrapper">
            <div class="<?php
            if (!isset($loginPage)) {
                echo "container";
            }
            ?>">

                <!--messages-->
                <div class="text-center">
                    <div class="col-xs-8 messages-container"  style="float: none;margin: 0 auto;">
                        <!--<div class="alert alert-success  messages">Operation successfully completed.</div>-->
                        <?php if ($error) { 
                            ?>
                            <div class="alert alert-danger messages"><?php echo $error; ?></div>
                        <?php }if ($success) { ?>
                            <div class="alert alert-success  messages"><?php echo $success; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <!--end messages-->
                <div class="blue-bg-cont">
                    <!--left menu-->
                    <?php
                    if ($loggedIn) {
                        load_view('includes/left-menu.php');
                    }
                    ?>
                    <!--end left menu-->
                    <div class="right-cont-box">
                        <?php if ($loggedIn) { ?>

                            <div class="header-cont">
                                <a class="navbar-minimalize" href="#"><i class="fa fa-bars"></i> </a>
                                <div class="right-cont">
                                    <ul class="left-side-notifications">
                                        <li>
                                            <div class="dropdown">
                                                <a href="#" type="button" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo base_url(); ?>assets/images/user-icon.png" alt="" title=""></a>

                                            </div>
                                        </li>
                                        <li onClick="update_notification();">
                                            <div class="dropdown" >
                                                <a href="#" type="button" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo base_url(); ?>assets/images/bell-icon.png" alt="" title=""></a>

                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown">
                                                <a href="#" type="button" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo base_url(); ?>assets/images/mail-icon.png" alt="" title=""></a>

                                            </div>
                                        </li>
                                        <li class="logout">
                                            <a href="<?php echo base_url() ?>logout">
                                                Log Out</a>
                                        </li>
                                    </ul>
                                </div>
                                <form method="post" action="<?php echo base_url('Users/search_users'); ?>">
                                    <input type="search" class="search-user" id="left_search" placeholder="Search..." />
                                </form>
                            </div>




                        <?php } ?>
                        <div class="inner-content">
                            <div class="center-content">




