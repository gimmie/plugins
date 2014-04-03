<?php
/* 
 * The MIT License (MIT)
 * 
 * Copyright (c) 2014 Gimmieworld pte ltd.
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
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
