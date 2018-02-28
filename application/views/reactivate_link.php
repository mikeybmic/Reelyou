<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!--Header-->
<div class="header landing-header">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="logo">
                    <a href="<?php echo base_url()?>"><img class="img-responsive" src="<?php echo base_url(); ?>assets/images/logo-img.png" alt="" title=""></a>
                </div>
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="logIn-form pull-right">
                    <?php
                    $attributes = array('method' => 'post');
                    echo form_open(base_url('Login/process_login'), $attributes);

                    $email = array('name' => 'email', 'type' => 'email', 'id' => 'email', 'value' => '', 'placeholder' => 'Email', 'required' => 'required');
                    echo form_input($email);

                    $data = array('name' => 'password', 'id' => 'password', 'value' => '', 'placeholder' => 'Password', 'required' => 'required');
                    echo form_password($data);

                    echo form_submit('submit', 'Log in');
                    echo form_close();
                    ?>

                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<!--Banner-->
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="landing-title">
                    <img class="title1 img-responsive" src="<?php echo base_url(); ?>assets/images/title-img.png" alt="" title="">
                    <img class="title2 img-responsive" src="<?php echo base_url(); ?>assets/images/title2-img.png" alt="" title="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="landing-form">
                    <h2>Reactivate Account</h2>
                    <div class="form-wrap">
                    
                    	<?php if(validation_errors()!='')
						{?>
							<p><?php echo validation_errors();?></p>
							
							
						<?php }?>
                    
                        <?php
                       
                        $attributes = array('method' => 'post', 'class' => 'registration-form','novalidate'=>'novalidate');
                        echo form_open(base_url('Login/reactivate_link'), $attributes);

                     

                      

                        echo '<div class="field">';
                        $data = array('name' => 'user_email', 'type' => 'email', 'id' => 'users_email', 'value' => set_value('user_email', $user_email), 'placeholder' => 'Enter Your Email', 'class' => 'text');
                        echo form_input($data);
                        echo '</div>';

                       

                        echo '<div class="field">';
                        $data = array('value'=>'Submit', 'id' => 'registration-submit', 'class' => 'registration-submit');
                        echo form_submit($data);
                        echo '</div>';

                        echo form_close();
                        ?>
                        
                    </div>
                    
                    
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>	
<!--Content-->

