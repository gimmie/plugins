<?php
if (!defined('SMF')) {
  die('You are not allowed to access this file directly');
}

function template_gimmie_rewards_config() {

  global $txt, $context, $scripturl, $modSettings;
?>

  <div class="admincenter">
  
    <form method="post" action="<?php echo $scripturl; ?>?action=gmss">
      <div class="cat_bar">
        <h3 class="catbg"><?php echo $txt['gimmie_admin_title']; ?></h3>
      </div>

      <div class="windowbg2">
        <span class="topslice"></span>
        <div class="content gimmie">
          <dl class="settings">
            <dt>
              <span><label for="gimmieEnable"><?php echo $txt['gimmie_admin_enable_label']; ?></label></span>
            </dt>
            <dd>
              <input type="checkbox" name="gm_settings[gm_enable]" id="gimmieEnable" value="1" class="input_check" <?php echo (isset ($modSettings['gm_enable']) && $modSettings['gm_enable'] == 1 ? 'checked' : ''); ?>>
            </dd>
          </dl>
          <hr class="hrcolor clear">

          <dl class="settings">
            <dt>
              <span><label for="gimmieKey"><?php echo $txt['gimmie_admin_key_label']; ?></label></span>
            </dt>
            <dd>
              <input type="text" name="gm_settings[gm_key]" id="gimmieKey" size="50" class="input_text gm-input" value="<?php echo (isset ($modSettings['gm_key']) ? htmlspecialchars($modSettings['gm_key']) : 'e52853bfdcf1d49a0368181245b7'); ?>">
            </dd>
            <dt>
              <span><label for="gimmieSecret"><?php echo $txt['gimmie_admin_secret_label']; ?></label></span>
            </dt>
            <dd>
              <input type="text" name="gm_settings[gm_secret]" id="gimmieSecret" size="50" class="input_text gm-input" value="<?php echo (isset($modSettings['gm_secret']) ? htmlspecialchars($modSettings['gm_secret']) : '3a95b4f7da128421ca7a15d67d3b'); ?>">
              <p class="help"><?php echo $txt['gimmie_admin_key_help']; ?></p>
            </dd>
            
            <dt>
              <span><label for="gimmieCountry"><?php echo $txt['gimmie_admin_country_label']; ?></label></span>
            </dt>
            <dd>
              <select id="gimmieCountry" name="gm_settings[gm_country]" class="gimmie-config-select gm-select">
                <option value="auto" <?php echo ((!isset($modSettings['gm_country']) || $modSettings['gm_country'] == 'auto') ? 'selected' : ''); ?>>Auto Select</option>
                <?php
                if ($context['gimmie_countries']) {
                  foreach($context['gimmie_countries'] as &$country) {
                ?>
                    <option value="<?php echo $country->{'cca2'}; ?>" <?php echo ((isset($modSettings['gm_country']) && $modSettings['gm_country'] == $country->{'cca2'}) ? 'selected' : ''); ?>>
                      <?php echo $country->{'name'}; ?>
                    </option>
                <?php
                  }
                }
                ?>
              </select>
            </dd>
            
            <dt><span><label for="gimmiePopup"><?php echo $txt['gimmie_admin_popup_views']; ?></label></span></dt>
            <dd>
              <input id="gimmieViewProfile" type="checkbox" name="gm_settings[gm_views_profile]" value="1" <?php echo (!isset($modSettings['gm_views_profile']) || (isset ($modSettings['gm_views_profile']) && $modSettings['gm_views_profile']) == 1 ? 'checked' : ''); ?> />
              <label for="gimmieViewProfile"><?php echo $txt['gimmie_admin_popup_profile']; ?></label>
              
              <input id="gimmieViewLeaderboard" type="checkbox" name="gm_settings[gm_views_leaderboard]" value="1" <?php echo (!isset($modSettings['gm_views_leaderboard']) || (isset ($modSettings['gm_views_leaderboard']) && $modSettings['gm_views_leaderboard']) == 1 ? 'checked' : ''); ?> />
              <label for="gimmieViewLeaderboard"><?php echo $txt['gimmie_admin_popup_leaderboard']; ?></label>
            </dd>
            
            <dt><span><label for="gimmieNotificationTimeout"><?php echo $txt['gimmie_admin_notification_timeout']; ?></label></span></dt>
            <dd>
              <input id="gimmieNotificationTimeout" type="number" name="gm_settings[gm_notification_timeout]" value="<?php echo (isset ($modSettings['gm_notification_timeout']) ? intval($modSettings['gm_notification_timeout']) : '10'); ?>" />
            </dd>
          </dl>
          
          <hr class="hrcolor clear">
          
          <dl class="settings">
            <dt><span><label for="gimmieForum"><?php echo $txt['gimmie_admin_keywords_forum']; ?></label></span></dt>
            <dd>
              <select id="gimmieCountry" name="gm_settings[gm_keywords_board]" class="gimmie-config-select gm-select">
                <option value="all" <?php echo ((!isset($modSettings['gm_keywords_board']) || $modSettings['gm_keywords_board'] == 'all') ? 'selected' : ''); ?>>
                <?php echo $txt['gimmie_admin_keywords_forum_every_board']; ?>
                </option>
                <?php
                if ($context['gimmie_boards']) {
                  foreach($context['gimmie_boards'] as &$board) {
                ?>
                <option value="<?php echo $board['id']; ?>" <?php echo ((isset($modSettings['gm_keywords_board']) && $modSettings['gm_keywords_board'] == $board['id']) ? 'selected' : ''); ?>>
                  <?php echo $board['name']; ?>
                </option>
                <?php
                  }
                }
                ?>
              </select>
            </dd>
          
            <dt><span><label for="gimmieKeywords"><?php echo $txt['gimmie_admin_keywords']; ?></label></span></dt>
            <dd>
              <textarea id="gimmieKeywords" name="gm_settings[gm_keywords]" class="gm-input input_textarea" rows="5"><?php echo $modSettings['gm_keywords']; ?></textarea>
            </dd>
          </dl>
          
          <hr class="hrcolor clear">
          
          <h1><?php echo $txt['gimmie_admin_trigger_header']; ?></h1>
          
          <dl class="settings">
            <dt><span><label for="gimmieTriggerLogin"><?php echo $txt['gimmie_admin_trigger_login']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerLogin" name="gm_settings[gm_trigger_did_smf_user_login_time]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_did_smf_user_login_time']) && $modSettings['gm_trigger_did_smf_user_login_time'] == 1 ? 'checked' : ''); ?> />
            </dd>
            
            <dt><span><label for="gimmieTriggerNewThread"><?php echo $txt['gimmie_admin_trigger_new_thread']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerNewThread" name="gm_settings[gm_trigger_did_smf_new_thread]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_did_smf_new_thread']) && $modSettings['gm_trigger_did_smf_new_thread'] == 1 ? 'checked' : ''); ?> />
            </dd>
            
            <dt><span><label for="gimmieTriggerReplyThread"><?php echo $txt['gimmie_admin_trigger_reply']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerReplyThread" name="gm_settings[gm_trigger_did_smf_reply_thread]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_did_smf_reply_thread']) && $modSettings['gm_trigger_did_smf_reply_thread'] == 1 ? 'checked' : ''); ?> />
            </dd>
            
            <dt><span><label for="gimmieTriggerReplyOwnThread"><?php echo $txt['gimmie_admin_trigger_reply_own_thread']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerReplyOwnThread" name="gm_settings[gm_trigger_did_smf_reply_own_thread]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_did_smf_reply_own_thread']) && $modSettings['gm_trigger_did_smf_reply_own_thread'] == 1 ? 'checked' : ''); ?> />
            </dd>
            
            <dt><span><label for="gimmieTriggerCreatePoll"><?php echo $txt['gimmie_admin_trigger_create_poll']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerCreatePoll" name="gm_settings[gm_trigger_did_smf_new_poll]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_did_smf_new_poll']) && $modSettings['gm_trigger_did_smf_new_poll'] == 1 ? 'checked' : ''); ?> />
            </dd>
            
            <dt><span><label for="gimmieTriggerVotePoll"><?php echo $txt['gimmie_admin_trigger_vote_poll']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerVotePoll" name="gm_settings[gm_trigger_did_smf_vote_poll]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_did_smf_vote_poll']) && $modSettings['gm_trigger_did_smf_vote_poll'] == 1 ? 'checked' : ''); ?> />
            </dd>
          </dl>
          
          <hr class="hrcolor clear">
          
          <div class="righttext">
            <input type="submit" value="<?php echo $txt['gimmie_admin_save']; ?>" class="button_submit">
          </div>
        </div>
        <span class="botslice"></span>

        <input type="hidden" name="sc" value="<?php echo $context['session_id']; ?>" />
        <input type="hidden" name="sa" value="save" />
      </div>

    </form>
  </div>
  <br class="clear">
<?php
}

function template_gimmie_localize_config() {
  global $txt, $context, $scripturl, $modSettings;

  $default_localize = <<<LOCALIZE
"empty_reward"              : "There are no rewards in the catalog right now. Please check back again while we add more rewards.",
"loading_reward"            : "Loading Rewards",
"error"                     : "Something wrong, please close and open again later.",
"login_title_text"          : "Login/Sign up",
"login_subline"             : "to redeem rewards",
"login_headline"            : "<p>Please login or signup to</p><p>earn points and redeem rewards</p>",
"login_button"              : "Login/Signup <img data-src='{{root}}navigation-arrow.png'>",
"help_link"                 : "How do I earn points?",
"reward_tab_title"          : "Reward",
"reward_tab_profile"        : "Profile",
"reward_tab_leaderboard"    : "Leaderboard",
"points"                    : "points",
"loading"                   : "Loading",
"reached_highest_level"     : "Reached highest level",
"points_to_level"           : "points to Level",
"badges_title"              : "Badges",
"mayorships_title"          : "Mayorships",
"redemptions_title"         : "Redemptions",
"activities_title"          : "Activities",
"badge"                     : "Badge",
"mystery_badge"             : "Mystery Badge",
"expires"                   : "Expires",
"redeemed"                  : "Redeemed",
"expired"                   : "Expired",
"loading_activities"        : "Loading Activities",
"empty_activities"          : "<p>You don't have recent activities.</p><p>When you earn points, badges or rewards a log of activities is shown here.</p>",
"fully_redeemed"            : "FULLY REDEEMED",
"featured_reward"           : "FEATURED REWARD",
"sponsor_here"              : "<p>Want to list your reward here?</p><small>Click for details.</small>",
"back_to_catalog"           : "&laquo; All {{data.category_name}} Rewards",
"redeem_button"             : "Redeem with {{data.points}} pts",
"use_reward_now"            : "Use Reward Now",
"description"               : "Description",
"fineprint"                 : "Fine Print",
"user_points"               : "You have <span class=\"gimmie-user-points\">{{user.points}}</span> pts",
"see_all_redemptions"       : "See All Redemptions",
"havent_redeemed"           : "<p>You haven't redeemed any rewards.</p><p>View your redemptions here after redeeming a reward from the catalog.</p>",
"see_all_mayorships"        : "See All Mayorships",
"empty_mayorships"          : "<p>You don't have any mayorships</p><p>Mayorships are given to the most active user at specific venues in a period of 30 days</p>",
"see_all_badges"            : "See All Badges",
"loading_badges"            : "Loading Badges",
"empty_badges"              : "<p>You don't have any badges.</p><p>Badges are rewarded when you do centain actions.</p>",
"see_all_activities"        : "See All Activities",
"loading_recent_activities" : "Loading recent activities",
"all_time_points"           : "all-time points:",
"most_points"               : "Most Points",
"most_rewards"              : "Most Rewards",
"most_reward_value"         : "Most Reward Value",
"loading_leaderboard"       : "Loading Leaderboard"
LOCALIZE;
?>
<div class="admincenter">
  
    <form method="post" action="<?php echo $scripturl; ?>?action=gmls">
      <div class="cat_bar">
        <h3 class="catbg"><?php echo $txt['gimmie_localize_title']; ?></h3>
      </div>

      <div class="windowbg2">
        <span class="topslice"></span>
        <div class="content gimmie">
          
          <dl class="settings">
            <dt>
              <span><label for="gimmieStyle"><?php echo $txt['gimmie_style_text']; ?></label></span>
            </dt>
            <dd>
              <textarea id="gimmieStyle" name="gm_settings[gm_style]" class="gm-input input_textarea" rows="15"><?php echo isset($modSettings['gm_style']) ? $modSettings['gm_style'] : ''; ?></textarea>
            </dd>
          </dl>
          
          <hr class="hrcolor clear">
          
          <dl class="settings">
            <dt>
              <span><label for="gimmieLocalizeTexts"><?php echo $txt['gimmie_localize_texts']; ?></label></span>
            </dt>
            <dd>
              <textarea id="gimmieLocalizeTexts" name="gm_settings[gm_localize]" class="gm-input input_textarea" rows="15"><?php echo isset($modSettings['gm_localize']) ? $modSettings['gm_localize'] : $default_localize; ?></textarea>
            </dd>
          </dl>
          <hr class="hrcolor clear">
          
          <dl class="settings">
            <dt>
              <span><label for="gimmieHelpText"><?php echo $txt['gimmie_help_text']; ?></label></span>
            </dt>
            <dd>
              <textarea id="gimmieHelpText" name="gm_settings[gm_help_text]" class="gm-input input_textarea" rows="15"><?php echo isset($modSettings['gm_help_text']) ? $modSettings['gm_help_text'] : ''; ?></textarea>
            </dd>
            
            <dt>
              <span><label for="gimmieHelpURL"><?php echo $txt['gimmie_help_url']; ?></label></span>
            </dt>
            <dd>
              <input id="gimmieHelpURL" type="url" name="gm_settings[gm_help_url]" value="<?php echo $modSettings['gm_help_url']; ?>" />
            </dd>
          </dl>
            
          <hr class="hrcolor clear">
          
          <div class="righttext">
            <input type="submit" value="<?php echo $txt['gimmie_admin_save']; ?>" class="button_submit">
          </div>
        </div>
        <span class="botslice"></span>

        <input type="hidden" name="sc" value="<?php echo $context['session_id']; ?>" />
        <input type="hidden" name="sa" value="save" />
      </div>

    </form>
  </div>
  <br class="clear">
<?php
}
?>
