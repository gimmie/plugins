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
              <textarea id="gimmieKeywords" name="gm_settings[gm_keywords]" class="gm-input input_textarea" rows="5"><?php echo (isset($modSettings['gm_keywords']) ? $modSettings['gm_keywords'] : ''); ?></textarea>
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
?>
<div class="admincenter">
  
    <form method="post" action="<?php echo $scripturl; ?>?action=gmls">
      <div class="cat_bar">
        <h3 class="catbg"><?php echo $txt['gimmie_localize_description']; ?></h3>
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
              <span><label for="gimmieHelpText"><?php echo $txt['gimmie_help_text']; ?></label></span>
            </dt>
            <dd>
              <textarea id="gimmieHelpText" name="gm_settings[gm_help_text]" class="gm-input input_textarea" rows="15"><?php echo isset($modSettings['gm_help_text']) ? $modSettings['gm_help_text'] : ''; ?></textarea>
            </dd>
            
            <dt>
              <span><label for="gimmieHelpURL"><?php echo $txt['gimmie_help_url']; ?></label></span>
            </dt>
            <dd>
              <input id="gimmieHelpURL" type="url" name="gm_settings[gm_help_url]" value="<?php echo (isset($modSettings['gm_help_url']) ? $modSettings['gm_help_url'] : ''); ?>" />
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
