<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap kacw-settings">

  <div class="kacw-header">
    <h1>Kaddora AI Settings</h1>
    <p>Configure your AI providers and API keys securely.</p>
  </div>

  <div class="kacw-card">
    <div class="kacw-card-inner">

      <form method="post" action="options.php">
        <?php settings_fields('kacw_settings_group'); ?>

        <div class="kacw-settings-group">

          <!-- Provider -->
          <div class="kacw-field">
            <label>AI Provider</label>
            <select name="kacw_ai_provider">
              <option value="openai" <?php selected(get_option('kacw_ai_provider'), 'openai'); ?>>OpenAI</option>
              <option value="gemini" <?php selected(get_option('kacw_ai_provider'), 'gemini'); ?>>Gemini</option>
              <option value="anthropic" <?php selected(get_option('kacw_ai_provider'), 'anthropic'); ?>>Anthropic</option>
            </select>
          </div>

          <!-- OpenAI -->
          <div class="kacw-field">
            <label>OpenAI API Key</label>
            <input type="text" name="kacw_openai_key"
              value="<?php echo esc_attr(get_option('kacw_openai_key')); ?>">
          </div>

          <!-- Gemini -->
          <div class="kacw-field">
            <label>Gemini API Key</label>
            <input type="text" name="kacw_gemini_key"
              value="<?php echo esc_attr(get_option('kacw_gemini_key')); ?>">
          </div>

          <!-- Anthropic -->
          <div class="kacw-field">
            <label>Anthropic API Key</label>
            <input type="text" name="kacw_anthropic_key"
              value="<?php echo esc_attr(get_option('kacw_anthropic_key')); ?>">
          </div>

          <!-- SAVE -->
          <div class="kacw-actions">
            <?php submit_button('Save Settings'); ?>
          </div>

        </div>

      </form>

    </div>
  </div>

</div>