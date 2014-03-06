<?php
if (file_exists(dirname(__FILE__).'/SSI.php') && !defined('SMF')) {
  require_once(dirname(__FILE__.'/SSI.php'));
}
else if (!defined('SMF')) {
  die ('<strong>Unable to install:</strong> Please make sure that you have copied this file in the same location as the index.php of your SMF.');
}

error_log('Uninstall Gimmie Plugins');

remove_integration_function ('integrate_pre_include', '$sourcedir/Subs-GimmieRewards.php');
remove_integration_function ('integrate_menu_buttons', 'gimmie_menu_buttons_hook');
remove_integration_function ('integrate_admin_areas', 'gimmie_admin_area_hook');
remove_integration_function ('integrate_actions', 'gimmie_actions_hook');
remove_integration_function ('integrate_load_theme', 'gimmie_load_theme_hook');

remove_integration_function ('integrate_redirect', 'gimmie_redirect');
remove_integration_function ('integrate_login', 'gimmie_login_hook');
