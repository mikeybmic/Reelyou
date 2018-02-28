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
                    <h2>Sign Up</h2>
                    <span>Connect with the world</span>
                    <div class="form-wrap">
                    
                    	<?php if(validation_errors()!='')
						{?>
							<p><?php echo validation_errors();?></p>
							
							
						<?php }?>
                    
                        <?php
                       
                        $attributes = array('method' => 'post', 'class' => 'registration-form','novalidate'=>'novalidate');
                        echo form_open(base_url('Login/register'), $attributes);

                        echo '<div class="field col-sm-6 register-first-name">';
                        $data = array('name' => 'first_name', 'type' => 'text', 'id' => 'first_name', 'value' => set_value('first_name', $first_name), 'placeholder' => 'First Name', 'class' => 'text col-sm-12');
                        echo form_input($data);
                        echo '</div>';

                        echo '<div class="field col-sm-6 register-last-name">';
                        $data = array('name' => 'last_name', 'type' => 'text', 'id' => 'last_name', 'value' => set_value('last_name', $last_name), 'placeholder' => 'Last Name', 'class' => 'text col-sm-12');
                        echo form_input($data);
                        echo '</div>';

                        echo '<div class="field">';
                        $data = array('name' => 'user_email', 'type' => 'email', 'id' => 'user_email', 'value' => set_value('user_email', $user_email), 'placeholder' => 'Email', 'class' => 'text');
                        echo form_input($data);
                        echo '</div>';

                        echo '<div class="field">';
                        $data = array('name' => 'password', 'id' => 'password1', 'value' => set_value('password', $password), 'placeholder' => 'Password', 'class' => 'text');
                        echo form_password($data);
                        echo '</div>';

                        echo '<div class="field">';
                        $data = array('name' => 'passconf', 'id' => 'passconf', 'value' => set_value('passconf', $passconf), 'placeholder' => 'Confirm Password', 'class' => 'text');
                        echo form_password($data);
                        echo '</div>';

                        echo '<div class="field">';
                        $data = array('value'=>'Sign Up', 'id' => 'registration-submit', 'class' => 'registration-submit');
                        echo form_submit($data);
                        echo '</div>';

                        echo form_close();
                        ?>
                        
                      <a href="<?php echo base_url('login/forget_password'); ?>"  class="forget-password">Forgot Password</a></br>  
                      <a href="<?php echo base_url('login/reactivate_link'); ?>"  class="forget-password">Resent Activation link</a>  

                    </div>
                    
                    
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>	
<!--Content-->

