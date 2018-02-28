<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('BASE_URL', 'http://localhost/reellyou_latest');
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/reellyou_latest');
define('HTTP_HOST', BASE_URL);


define('TFIELD_INT', -1);
define('TFIELD_BOOL', -2);
define('TFIELD_DATE', -3);
define('TFIELD_STR', -4);
define('TFIELD_FLOAT', -5);
define('TFIELD_DEFAULT', TFIELD_STR);


define('TABLE_USERS', 'users');
define('TABLE_PM', 'privmsgs');
define('TABLE_PMTO', 'privmsgs_to');

define('TF_ADD_ID', 'address_id');
define('TF_ADD_USERID', 'address_user');
define('TF_ADD_MODIFIED', 'address_modified');
define('TF_ADD_DELETED', 'address_deleted');
define('TF_ADD_VALIDATED', 'address_validated');
define('TF_ADD_PRIMARY', 'address_primary');
define('TF_ADD_FNAME', 'address_fname');
define('TF_ADD_LNAME', 'address_lname');
define('TF_ADD_COUNTRYID', 'address_country');
define('TF_ADD_STATE', 'address_state');
define('TF_ADD_CITY', 'address_city');
define('TF_ADD_POSTALCODE', 'address_postalcode');
define('TF_ADD_ADDRESS1', 'address_address1');
define('TF_ADD_ADDRESS2', 'address_address2');
// Address link table fields
define('TF_ADTO_ID', 'adto_id');
define('TF_ADTO_USERID', 'adto_user');
define('TF_ADTO_ADDRESSID', 'adto_address');
// Private messaging table fields
define('TF_PM_ID', 'privmsg_id');
define('TF_PM_AUTHOR', 'privmsg_author');
define('TF_PM_DATE', 'privmsg_date');
define('TF_PM_SUBJECT', 'privmsg_subject');
define('TF_PM_BODY', 'privmsg_body');
define('TF_PM_NOTIFY', 'privmsg_notify');
define('TF_PM_DELETED', 'privmsg_deleted');
define('TF_PM_DDATE', 'privmsg_ddate');
define('PM_RECIPIENTS', 'recipients'); // NOT AN ACTUAL DB FIELD, but used for controller & view
// Private messaging link table fields
define('TF_PMTO_ID', 'pmto_id');
define('TF_PMTO_MESSAGE', 'pmto_message');
define('TF_PMTO_RECIPIENT', 'pmto_recipient');
define('TF_PMTO_READ', 'pmto_read');
define('TF_PMTO_RDATE', 'pmto_rdate');
define('TF_PMTO_DELETED', 'pmto_deleted');
define('TF_PMTO_DDATE', 'pmto_ddate');
define('TF_PMTO_ALLOWNOTIFY', 'pmto_allownotify');
// User table fields
define('TF_USER_ID', 'user_id');
define('TF_USER_NAME', 'first_name');
define('TF_USER_EMAIL', 'user_email');


define('MSG_NONDELETED',0);
define('MSG_DELETED', 	1);
define('MSG_SENT', 		2);
define('MSG_UNREAD',	3);




/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/

defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
