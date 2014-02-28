<?php
if (!defined('SMF')) {
  die('You are not allowed to access this file directly');
}

function template_gimmie_rewards_config() {

  global $txt, $context, $scripturl, $modSettings, $settings, $actionArray;
  
  $countries = json_decode(file_get_contents('https://raw.github.com/mledoze/countries/master/dist/countries.json'));
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
                if ($countries) {
                  foreach($countries as &$country) {
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
          </dl>

          <hr class="hrcolor clear">
          
          <dl class="settings">
            <dd>
              <dt><span><label for="gimmiePopup"><?php echo $txt['gimmie_admin_popup_views']; ?></label></span></dt>
            </dd>
            <dd>
              <input id="gimmieViewCatalog" type="checkbox" name="gm_settings[gm_views][catalog]" value="1" checked disabled="" />
              <label for="gimmieViewCatalog"><?php echo $txt['gimmie_admin_popup_catalog']; ?></label>
              
              <input id="gimmieViewProfile" type="checkbox" name="gm_settings[gm_views][profile]" value="1" />
              <label for="gimmieViewProfile"><?php echo $txt['gimmie_admin_popup_profile']; ?></label>
              
              <input id="gimmieViewLeaderboard" type="checkbox" name="gm_settings[gm_views][leaderboard]" value="1" />
              <label for="gimmieViewLeaderboard"><?php echo $txt['gimmie_admin_popup_leaderboard']; ?></label>
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
