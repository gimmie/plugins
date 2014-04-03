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
if (!defined('SMF')) {
  die('You are not allowed to access this file directly');
}

/**
 * Gimmie Hook
 */
function gimmie_menu_buttons_hook(&$menu_buttons) {
  global $txt, $modSettings;
  
  if (!is_gimmie_enabled()) {
    return;
  }
  
  loadLanguage('GimmieRewards');
  $menu_buttons = array_merge(
    array_slice($menu_buttons, 0, 1, true),
    array(
      'gimmie' => array(
        'title' => (isset($txt['gimmie_button']) ? $txt['gimmie_button'] : 'Gimmie'),
        'href' => 'javascript:GimmieWidget._showPopup(\'catalog\')',
        'show' => true,
        'sub_buttons' => array()
      )
    ),
    array_slice($menu_buttons, 1)
  );
}

function gimmie_admin_area_hook(&$admin_area) {
  global $txt, $scopeurl;
  
  loadLanguage('GimmieRewards');
  $admin_area = array_merge(
    $admin_area,
    array(
      'gmss' => array(
        'title' => $txt['gimmie_admin_title'],
        'permission' => array('admin_forum'),
        'areas' => array(
          'gmss' => array(
            'label'       => $txt['gimmie_admin_description'],
            'file'        => 'Subs-GimmieRewards.php',
            'function'    => 'gimmie_reward_config',
            'custom_url'  => $scopeurl.'?action=admin;area=gmss;sa=settings'
          ),
          'gmls' => array(
            'label'       => $txt['gimmie_localize_description'],
            'file'        => 'Subs-GimmieRewards.php',
            'function'    => 'gimmie_localize_config',
            'custom_url'  => $scopeurl.'?action=admin;area=gmls;sa=settings'
          )
        )
      )
    )
  );
}

function gimmie_actions_hook(&$actions) {
  $actions = array_merge(
    $actions,
    array(
      'gmpx' => array('Subs-GimmieRewards.php', 'gimmie_proxy'), # Proxy
      'gmss' => array('Subs-GimmieRewards.php', 'gimmie_reward_config'), # Configuration Action
      'gmls' => array('Subs-GimmieRewards.php', 'gimmie_localize_config') # Localization Action
    )
  );
}

function gimmie_load_theme_hook() {
  global $context, $settings, $modSettings, $scripturl, $user_info;
    
  $themeurl = $settings['theme_url'];
  $user = $context['user'];
  
  
  $headers = $context['html_headers'];
  $headers = $headers.<<<EOH
  
  <link href="$themeurl/css/GimmieRewards.css" rel="stylesheet" />
  
EOH;

  if (!empty($modSettings['gm_enable']) && $modSettings['gm_enable']) {
    $endpoint = $scripturl."?action=gmpx;sa=";
    $key = $modSettings['gm_key'];
    $notification_timeout = isset($modSettings['gm_notification_timeout']) ? $modSettings['gm_notification_timeout'] : 10;
  
    $hide_profile_page = (isset($modSettings['gm_views_profile']) && ($modSettings['gm_views_profile'] == 0)) ? 'true' : 'false';
    $hide_leaderboard_page = (isset($modSettings['gm_views_leaderboard']) && ($modSettings['gm_views_leaderboard'] == 0)) ? 'true' : 'false';
    
    $country = '';
    
    if (!isset($modSettings['gm_country']) || $modSettings['gm_country'] == 'auto') {
      $ip = isset($user_info['ip2']) ? $user_info['ip2'] : $user_info['ip'];
      $country = trim(file_get_contents('http://api.wipmania.com/'.$ip));
    }
    else {
      $country = $modSettings['gm_country'];
    }    
  
    $localize_text = isset($modSettings['gm_localize']) ? $modSettings['gm_localize'] : 'us';
    $help_text = isset($modSettings['gm_help_text']) ? $modSettings['gm_help_text'] : '';
    $help_url = isset($modSettings['gm_help_url']) ? $modSettings['gm_help_url'] : '';
  
    $headers = $headers.<<<EOS
  <script type="text/javascript">
    _gimmie = {
      "endpoint"                    : "$endpoint",
      "key"                         : "$key",
      "country"                     : "$country",  
EOS;
    
    if (!$user['is_guest']) {
      $email = $user['email'];
      $username = $user['username'];
      $name = $user['name'];
      
      $headers = $headers.<<<EOU
      
      "user"                        : {
          "external_uid"              : "$email",
          // Display name
          "name"                      : "$username",
          // Gateway name
          "realname"                  : "$name",
          "email"                     : "$email",
          "avatar"                    : ""
      },
EOU;
    }
    
    $headers = $headers.<<<EOS

      "options"                     : {
        "animate"                   : true,
        "auto_show_notification"    : true,
        "notification_timeout"      : $notification_timeout,
        "responsive"                : true,
        "show_anonymous_rewards"    : true,
        "shuffle_reward"            : true,
        "pages"                       : {
          "profile"                   : {
            "hide"                    : $hide_profile_page
          },
          "leaderboard"               : {
            "hide"                    : $hide_leaderboard_page
          }
        }       
      },
      "text"                        : {
        "help"                      : "$help_text",
        "help_url"                  : "$help_url"
      },  
      "templates"                   : {}
    };
    
    window.onload = function () {
      var root = document.createElement('div');
      root.id = "gimmie-root";
      document.body.appendChild(root);
      
      (function(d){
        var js, id = "gimmie-widget", ref = d.getElementsByTagName("script")[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement("script"); js.id = id; js.async = true;
        js.src = "https://api.gimmieworld.com/assets/gimmie-widget2.all.js";
        ref.parentNode.insertBefore(js, ref);
      }(document));
    }
  </script>
EOS;

  }
  
  if (isset($modSettings['gm_style'])) {
    $stylesheet = $modSettings['gm_style'];
    $headers = $headers.<<<EOS
    
  <style>
$stylesheet
  </style>
EOS;
  }
  
  $context['html_headers'] = $headers;
}

/**
 * Action Hooks
 */
function gimmie_redirect(&$setLocation, &$refresh) {
  global $context, $user_info, $smcFunc, $topic, $modSettings;
  $email = $user_info['email'];

  $request = $smcFunc['db_query']('', '
    SELECT
      t.id_board, t.id_member_started, t.id_poll, t.num_replies, t.id_last_msg, ml.body,
      CASE WHEN ml.poster_time > ml.modified_time THEN ml.poster_time ELSE ml.modified_time END AS last_post_time
    FROM {db_prefix}topics AS t
      LEFT JOIN {db_prefix}log_notify AS ln ON (ln.id_topic = t.id_topic AND ln.id_member = {int:current_member})
      LEFT JOIN {db_prefix}messages AS ml ON (ml.id_msg = t.id_last_msg)
    WHERE t.id_topic = {int:current_topic}
    LIMIT 1',
    array(
      'current_member' => $user_info['id'],
      'current_topic' => $topic,
    )
  );
  list ($board, $owner, $poll_id, $total_replies, $last_message_id, $last_message) = $smcFunc['db_fetch_row']($request);
  $smcFunc['db_free_result']($request);
  
  switch ($context['current_action']) {
    case 'vote':
      $event = 'did_smf_vote_poll';
      if (is_board_enabled($board) && is_event_enabled("gm_trigger_$event")) {
        trigger_event_for_user($event, $email);
      }
      break;
    case 'post2':
      $user_action = '';
      $user_id = $user_info['id'];
      if ($total_replies > 0) {
        $user_action = 'did_smf_reply_thread';
        if ($user_id == $owner) {
          $user_action = 'did_smf_reply_own_thread';
        }
      }
      else if ($poll_id) {
        $user_action = 'did_smf_new_poll';
      }
      else {
        $user_action = 'did_smf_new_thread';
      }
      
      if (is_board_enabled($board) && is_event_enabled("gm_trigger_$user_action")) {
        switch ($user_action) {
          case 'did_smf_new_poll':
            trigger_event_for_user($user_action, $email);
            break;
          case 'did_smf_reply_thread':
          case 'did_smf_reply_own_thread':
          case 'did_smf_new_thread':
            $keywords = $modSettings['gm_keywords'];
            $keywords = explode(',', $keywords);
            $keywords = array_map('trim', $keywords);
            
            # (not whitespace)<keyword>(not whitespace) or (not whitespace)<another keyword>(not whitespace) or ...
            $pattern1 = '\W'.implode('\W|\W', $keywords).'\W'; 
            # (start with)<keyword>(not whitespace) or (start with)<another keyword>(not whitespace) or ...
            $pattern2 = '^'.implode('\W|^', $keywords).'\W';
            # (not whitespace)<keyword>(ending) or (not whitespace)<another keyword>(ending) or ...
            $pattern3 = '\W'.implode('$|\W', $keywords).'$';
            $pattern = "/($pattern1|$pattern2|$pattern3)/i";
            
            if (preg_match($pattern, $last_message)) {
              gimmie_log($user_action);
              trigger_event_for_user($user_action, $email);
            }  
            
            break;
        }
        
      }

      break;
  }  

  
}
  
function gimmie_login_hook($username) {
  global $sourcedir, $context, $modSettings, $user_profile;
  require_once($sourcedir.'/Gimmie.sdk.php');
  
  $event = 'did_smf_user_login_time';
  if (is_event_enabled("gm_trigger_$event")) {
    $members = loadMemberData(array($username), true);
    $user = $user_profile[array_pop($members)];
    
    $email = $user['email_address'];
    trigger_event_for_user($event, $email);
  }
  
  // SMF Requires this hook returns something.
  return "";
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

function gimmie_localize_config() {
  $sa = !empty($_REQUEST['sa']) ? $_REQUEST['sa'] : '';
  switch ($sa) {
    case 'save':
      gimmie_localize_config_save();
      break;
    default:
      gimmie_localize_config_show();
      break;
  }
}

function gimmie_reward_config_show() {
  global $txt, $context, $modSettings, $settings, $boards, $sourcedir;

  isAllowedTo('admin_forum');
  loadLanguage('GimmieRewards');
  loadtemplate('GimmieRewards.admin', array('GimmieRewards.admin'));
  
  require_once($sourcedir.'/Subs-Boards.php');
  getBoardTree();
  
  $context['gimmie_countries'] = json_decode(file_get_contents('https://raw.github.com/mledoze/countries/master/dist/countries.json'));
  $context['gimmie_boards'] = $boards;

  $context['sub_template'] = 'gimmie_rewards_config';
  $context['page_title'] = $txt['gimmie_admin_title'];
}

function gimmie_reward_config_save() {
  global $context;

  isAllowedTo('admin_forum');
  checkSession('post');
  
  $gm_settings = $_REQUEST['gm_settings'];
  $gm_settings['gm_enable'] = (!empty($gm_settings['gm_enable']) ? true : false);
  
  $gm_settings['gm_key'] = (!empty($gm_settings['gm_key']) ? trim($gm_settings['gm_key']) : "e52853bfdcf1d49a0368181245b7");
  $gm_settings['gm_secret'] = (!empty($gm_settings['gm_secret']) ? trim($gm_settings['gm_secret']) : "3a95b4f7da128421ca7a15d67d3b");
  $gm_settings['gm_country'] = (!empty($gm_settings['gm_country']) ? trim($gm_settings['gm_country']) : 'auto');
  
  $gm_settings['gm_notification_timeout'] = (!empty($gm_settings['gm_notification_timeout']) ? intval(trim($gm_settings['gm_notification_timeout'])) : 10);
  
  if (!isset($gm_settings['gm_views_profile'])) {
    $gm_settings['gm_views_profile'] = 0;
  }
  
  if (!isset($gm_settings['gm_views_leaderboard'])) {
    $gm_settings['gm_views_leaderboard'] = 0;
  }

  $gm_settings['gm_keywords_forum'] = (!empty($gm_settings['gm_keywords_forum']) ? trim($gm_settings['gm_keywords_forum']) : 'all');
  $gm_settings['gm_keywords'] = (!empty($gm_settings['gm_keywords']) ? trim($gm_settings['gm_keywords']) : "");
  
  gimmie_log($gm_settings);
  
  // Clear context
  $context['gimmie_countries'] = '';
  $context['gimmie_boards'] = '';

  updateSettings($gm_settings);
  redirectexit('action=admin;area=gmss;sa=settings;gmss_action=saved');

}

function gimmie_localize_config_show() {
  global $txt, $context, $modSettings, $settings, $boards, $sourcedir;

  isAllowedTo('admin_forum');
  loadLanguage('GimmieRewards');
  loadtemplate('GimmieRewards.admin', array('GimmieRewards.admin'));
  
  $context['sub_template'] = 'gimmie_localize_config';
  $context['page_title'] = $txt['gimmie_admin_title'];
}

function gimmie_localize_config_save() {
  global $context;

  isAllowedTo('admin_forum');
  checkSession('post');
  
  $gm_settings = $_REQUEST['gm_settings'];
  
  $gm_settings['gm_localize'] = (!empty($gm_settings['gm_localize']) ? trim($gm_settings['gm_localize']) : "");
  $gm_settings['gm_localize'] = (json_decode('{'.$gm_settings['gm_localize'].'}') ? $gm_settings['gm_localize'] : '');
  
  $gm_settings['gm_help_text'] = (!empty($gm_settings['gm_help_text']) ? trim($gm_settings['gm_help_text']) : "");
  $gm_settings['gm_help_url'] = (!empty($gm_settings['gm_help_url']) ? trim($gm_settings['gm_help_url']) : "");  
  gimmie_log($gm_settings);
  
  updateSettings($gm_settings);
  redirectexit('action=admin;area=gmls;sa=settings;gmls_action=saved');
}

/**
 * Utilities functions
 */
function gimmie_log($mixed) {
  if (0) {
    error_log(print_r($mixed, 1)."\n", 3, '/var/log/debug.php.log');
  }
}

function is_gimmie_enabled() {
  global $modSettings;
  return !!(isset($modSettings['gm_enable']) && $modSettings['gm_enable']);
}

function is_event_enabled($name) {
  global $modSettings;
  return !!(isset($modSettings['gm_enable']) && $modSettings['gm_enable'] && $modSettings[$name]);
}

function is_board_enabled($board) {
  global $modSettings;
  return !!(!isset($modSettings['gm_keywords_board']) || 
            (isset($modSettings['gm_keywords_board']) && 
            ($modSettings['gm_keywords_board'] == $board || $modSettings['gm_keywords_board'] == 'all')));
}

function trigger_event_for_user($event, $user) {
  global $modSettings, $sourcedir;
  require_once($sourcedir.'/Gimmie.sdk.php');

  $gimmie = Gimmie::getInstance($modSettings['gm_key'], $modSettings['gm_secret']);
  $gimmie->set_user($user);
  $gimmie->trigger($event);
}
