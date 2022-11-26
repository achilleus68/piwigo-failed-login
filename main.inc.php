<?php
/*
Plugin Name: Piwigo Failed Login logger
Version: 1.0
Description: Write failed login attempts into a log file (to be used by fail2ban).
Plugin URI: https://github.com/achilleus68/piwigo-failed-login
Author: Achilleus
Has Settings: true
Credits: based on the plugin by Tomas Sobek https://piwigo.org/ext/extension_view.php?eid=801
*/
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

define('FAILED_LOGINS_ID',      basename(dirname(__FILE__)));
define('FAILED_LOGINS_PATH' ,   PHPWG_PLUGINS_PATH . FAILED_LOGINS_ID . '/');
define('FAILED_LOGINS_ADMIN',get_root_url().'admin.php?page=plugin-'.FAILED_LOGINS_ID);

/**
 * this is the core of this plugin:
 * write every failed login attempt out into a logfile
 */

add_event_handler('login_failure', 'FAILED_LOGINS_log');

function FAILED_LOGINS_log()
{
  global $conf;

  $myFile = $conf['logFailedLoginsFilename'];

  // if a logfile parameter is defined
  if ($myFile <> "") {
    $remoteIpAddress = $_SERVER['REMOTE_ADDR'];
    $userName = $_POST['username'];
    // Example: 2015/06/14 22:32:33 ip=192.168.1.100 username=Admin
    $logline = date("Y/m/d H:i:s")." ip=".$remoteIpAddress." username=".$userName."\n";

    // try opening the file and append a new logline
    $fh = fopen($myFile, 'a');
    if ($fh) {
      fwrite($fh, $logline);
      fclose($fh);
    }
  }
}

// Hook on to an event to show the administration page.
add_event_handler('get_admin_plugin_menu_links', 'FAILED_LOGINS_admin_menu');

// Add an entry to the 'Plugins' menu.
function FAILED_LOGINS_admin_menu($menu) {
 array_push(
   $menu,
   array(
     'NAME'  => 'Piwigo Failed Logins',
     'URL'   => get_admin_plugin_menu_link(dirname(__FILE__)).'/admin.php'
   )
 );
 return $menu;
}

?>
