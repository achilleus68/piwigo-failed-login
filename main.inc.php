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

  $myFile = $conf['failed_logins_logfile'];

  // if a logfile parameter is defined
  if ($myFile <> "") {
    $remoteIpAddress = getIpAddress();

    $userName = $_POST['username'];
    // Example: 2022/11/01 09:43:44 ip=192.168.254.1 username=Admin
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

function getIpAddress()
{
    $ipAddress = '';
    if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
        // to get shared ISP IP address
        $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check for IPs passing through proxy servers
        // check if multiple IP addresses are set and take the first one
        $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($ipAddressList as $ip) {
            if (! empty($ip)) {
                // if you prefer, you can check for valid IP address here
                $ipAddress = $ip;
                break;
            }
        }
    } else if (! empty($_SERVER['HTTP_X_FORWARDED'])) {
        $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (! empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    } else if (! empty($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (! empty($_SERVER['HTTP_FORWARDED'])) {
        $ipAddress = $_SERVER['HTTP_FORWARDED'];
    } else if (! empty($_SERVER['REMOTE_ADDR'])) {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
    }
    return $ipAddress;
}
?>
