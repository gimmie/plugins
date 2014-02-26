<?php
if (!defined('SMF')) {
  die('You are not allowed to access this file directly');
}

/**
 * Administration Area
 */
function gimmie_reward_config() {
  $sa = !empty($_REQUEST['sa']) ? $_REQUEST['sa'] : '';
  switch ($sa) {
  case 'save':
    gimmie_reward_config_save();
    break;
  default:
    gimmie_reward_config_show();
    break;
  }
}

function gimmie_reward_config_show() {
  global $txt, $context, $modSettings, $settings;

  isAllowedTo('admin_forum');
  loadLanguage('GimmieRewards');
  loadtemplate('GimmieRewards.admin', array('GimmieRewards.admin'));

  $context['sub_template'] = 'gimmie_rewards_config';

  $context['page_title'] = $txt['gmss_title'];
}

function gimmie_reward_config_save() {
  isAllowedTo('admin_forum');

  checkSession('post');
  $gm_settings = $_REQUEST['gm_settings'];
  error_log($gm_settings);
  $gm_settings['gm_enable'] = (!empty($gm_settings['gm_enable']) ? trim($gm_settings['gm_enable']) : "");
  $gm_settings['gm_key'] = (!empty($gm_settings['gm_key']) ? trim($gm_settings['gm_key']) : "");
  $gm_settings['gm_secret'] = (!empty($gm_settings['gm_secret']) ? trim($gm_settings['gm_secret']) : "");

  updateSettings($gm_settings);
  redirectexit('action=admin;area=gmss;sa=settings;gmss_action=saved');

}

?>
