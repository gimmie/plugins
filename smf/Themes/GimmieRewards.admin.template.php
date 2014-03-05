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
              <input type="text" name="gm_settings[gm_key]" id="gimmieKey" size="50" class="input_text gm-input" value="<?php echo (isset ($modSettings['gm_key']) ? htmlspecialchars($modSettings['gm_key']) : ''); ?>">
            </dd>
            <dt>
              <span><label for="gimmieSecret"><?php echo $txt['gimmie_admin_secret_label']; ?></label></span>
            </dt>
            <dd>
              <input type="text" name="gm_settings[gm_secret]" id="gimmieSecret" size="50" class="input_text gm-input" value="<?php echo (isset($modSettings['gm_secret']) ? htmlspecialchars($modSettings['gm_secret']) : ''); ?>">
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
              <input id="gimmieViewCatalog" type="checkbox" name="gm_settings[gm_views_catalog]" value="1" checked disabled="" />
              <label for="gimmieViewCatalog"><?php echo $txt['gimmie_admin_popup_catalog']; ?></label>
              
              <input id="gimmieViewProfile" type="checkbox" name="gm_settings[gm_views_profile]" value="1" />
              <label for="gimmieViewProfile"><?php echo $txt['gimmie_admin_popup_profile']; ?></label>
              
              <input id="gimmieViewLeaderboard" type="checkbox" name="gm_settings[gm_views_leaderboard]" value="1" />
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
          
          <dl class="settings">
            <dt><span><label for="gimmieTriggerLogin"><?php echo $txt['gimmie_admin_trigger_login']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerLogin" name="gm_settings[gm_trigger_login]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_login']) && $modSettings['gm_trigger_login'] == 1 ? 'checked' : ''); ?> />
            </dd>
            
            <dt><span><label for="gimmieTriggerNewThread"><?php echo $txt['gimmie_admin_trigger_new_thread']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerNewThread" name="gm_settings[gm_trigger_new_thread]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_new_thread']) && $modSettings['gm_trigger_new_thread'] == 1 ? 'checked' : ''); ?> />
            </dd>
            
            <dt><span><label for="gimmieTriggerReplyThread"><?php echo $txt['gimmie_admin_trigger_reply']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerReplyThread" name="gm_settings[gm_trigger_reply_thread]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_reply_thread']) && $modSettings['gm_trigger_reply_thread'] == 1 ? 'checked' : ''); ?> />
            </dd>
            
            <dt><span><label for="gimmieTriggerReplyOwnThread"><?php echo $txt['gimmie_admin_trigger_reply_own_thread']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerReplyOwnThread" name="gm_settings[gm_trigger_reply_own_thread]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_reply_own_thread']) && $modSettings['gm_trigger_reply_own_thread'] == 1 ? 'checked' : ''); ?> />
            </dd>
            
            <dt><span><label for="gimmieTriggerCreatePoll"><?php echo $txt['gimmie_admin_trigger_create_poll']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerCreatePoll" name="gm_settings[gm_trigger_create_poll]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_create_poll']) && $modSettings['gm_trigger_create_poll'] == 1 ? 'checked' : ''); ?> />
            </dd>
            
            <dt><span><label for="gimmieTriggerVotePoll"><?php echo $txt['gimmie_admin_trigger_vote_poll']; ?></label></span></dt>
            <dd>
              <input id="gimmieTriggerVotePoll" name="gm_settings[gm_trigger_vote_poll]" type="checkbox" value="1" class="input_check" <?php echo (isset ($modSettings['gm_trigger_vote_poll']) && $modSettings['gm_trigger_vote_poll'] == 1 ? 'checked' : ''); ?> />
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
