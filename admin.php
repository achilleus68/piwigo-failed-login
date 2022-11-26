<?php
if (!defined('FAILED_LOGINS_PATH')) die('Hacking attempt!');
global $template, $conf;

// put configured value onto the form
$template->assign(array('FAILED_LOGINS_FILENAME' => $conf['failed_logins_logfile'],));

// did user click Submit?
if (isset($_POST['submitButton'])) {
  // update configuration value
  conf_update_param('failed_logins_logfile', $_POST['log_filename']);
  $template->assign(array('FAILED_LOGINS_FILENAME' => $_POST['log_filename'],));
  // add message to notification area
  array_push($page['infos'], l10n('Configuration update'));
}

// Add our template to the global template
$template->set_filenames(array('plugin_admin_content' => dirname(__FILE__).'/admin.tpl'));

// Assign the template contents to ADMIN_CONTENT
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
?>
