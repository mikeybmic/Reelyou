<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'mail.spijko.com',
    'smtp_port' => 26,
    'smtp_user' => 'test@spijko.com', // change it to yours
    'smtp_pass' => 'Test!@#4', // change it to yours
    'mailtype' => 'html',
    'charset' => 'utf-8',
    'wordwrap' => TRUE
);

$config['feedback_email'] = 'tes@spijko.com';

//USER INFO
$config['email_from'] = 'support@reellyou.com';
$config['mailer_name'] = 'Reellyou Support';

//email types
$config['registration'] = "Registration";
$config['change_password'] = "Change Password";
$config['account_activation'] = 'Account Activation';
$config['forget_password'] = "Forget Password";
