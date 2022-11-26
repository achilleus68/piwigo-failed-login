<?php
// +-----------------------------------------------------------------------------------------------+
// | Piwigo Failed Login for Piwigo by Achilleus                                                   |
// +-----------------------------------------------------------------------------------------------+
// | v1.0, compatible with Piwigo 13 https://github.com/achilleus68/piwigo-failed-login            |
// +-----------------------------------------------------------------------------------------------+
// | Credits: based on the plugin by Tomas Sobek https://piwigo.org/ext/extension_view.php?eid=801 |
// +-----------------------------------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify                          |
// | it under the terms of the GNU General Public License as published by                          |
// | the Free Software Foundation                                                                  |
// |                                                                                               |
// | This program is distributed in the hope that it will be useful, but                           |
// | WITHOUT ANY WARRANTY; without even the implied warranty of                                    |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU                              |
// | General Public License for more details.                                                      |
// |                                                                                               |
// | You should have received a copy of the GNU General Public License                             |
// | along with this program; if not, write to the Free Software                                   |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,                         |
// | USA.                                                                                          |
// +-----------------------------------------------------------------------------------------------+

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

class LOG_FAILED_LOGINS_maintain extends PluginMaintain{
  function install($plugin_version, &$errors=array()){
    pwg_query('INSERT INTO ' . CONFIG_TABLE . ' (param,value,comment) VALUES ("LOG_FAILED_LOGINS","","Write failed login attempts into a log file (to be used by fail2ban).");');
  }

  function update($old_version, $new_version, &$errors=array())
  {
  }

  function uninstall()
  {
	conf_delete_param('LOG_FAILED_LOGINS');
  }
}
