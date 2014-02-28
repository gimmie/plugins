<?php
if (!defined('SMF')) {
  die('You are not allowed to access this file directly');
}

/**
 * Proxy Area
 */
function gimmie_proxy() {
  global $sourcedir, $context, $modSettings;
  require_once($sourcedir.'/Gimmie.sdk.php');

  $sa = !empty($_REQUEST['sa']) ? $_REQUEST['sa'] : '';
  
  $id = $context['user']['email'];

  $key = $modSettings['gm_key'];
  $secret = $modSettings['gm_secret'];

  $endpoint = 'https://api.gimmieworld.com'.$sa;

  $access_token = $context['user']['email'];
  $access_token_secret = $secret;
  $params = array();
  $sig_method = new OAuthSignatureMethod_HMAC_SHA1();
  $consumer = new OAuthConsumer($key, $secret, NULL);
  $token = new OAuthConsumer($access_token, $access_token_secret);
  
  $json = '{"response":{"success":false}, "error":{}}';
  if (!is_null($endpoint)) {
    $acc_req = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $endpoint, $params);
    $acc_req->sign_request($sig_method, $consumer, $token);
    
    $json = file_get_contents($acc_req);
  }
  
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json');
  print($json);
  obExit(false);
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
  
  error_log (print_r($gm_settings, true));
  
  $gm_settings['gm_enable'] = (!empty($gm_settings['gm_enable']) ? true : false);
  
  $gm_settings['gm_key'] = (!empty($gm_settings['gm_key']) ? trim($gm_settings['gm_key']) : "");
  $gm_settings['gm_secret'] = (!empty($gm_settings['gm_secret']) ? trim($gm_settings['gm_secret']) : "");
  $gm_settings['gm_country'] = (!empty($gm_settings['gm_country']) ? trim($gm_settings['gm_country']) : 'auto');
  
  $gm_settings['gm_notification_timeout'] = (!empty($gm_settings['gm_notification_timeout']) ? intval(trim($gm_settings['gm_notification_timeout'])) : 10);
  
  $gm_settings['gm_views_catalog'] = (!empty($gm_settings['gm_views_catalog']) ? true : false);
  $gm_settings['gm_views_profile'] = (!empty($gm_settings['gm_views_profile']) ? true : false);
  $gm_settings['gm_views_leaderboard'] = (!empty($gm_settings['gm_views_leaderboard']) ? true : false);
  
  $gm_settings['gm_trigger_login'] = (!empty($gm_settings['gm_trigger_login']) ? true : false);
  $gm_settings['gm_trigger_new_thread'] = (!empty($gm_settings['gm_trigger_new_thread']) ? true : false);
  $gm_settings['gm_trigger_reply_thread'] = (!empty($gm_settings['gm_trigger_reply_thread']) ? true : false);
  $gm_settings['gm_trigger_reply_own_thread'] = (!empty($gm_settings['gm_trigger_reply_own_thread']) ? true : false);
  $gm_settings['gm_trigger_create_poll'] = (!empty($gm_settings['gm_trigger_create_poll']) ? true : false);
  $gm_settings['gm_trigger_vote_poll'] = (!empty($gm_settings['gm_trigger_vote_poll']) ? true : false);

  updateSettings($gm_settings);
  redirectexit('action=admin;area=gmss;sa=settings;gmss_action=saved');

}

?>
