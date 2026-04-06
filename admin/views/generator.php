<?php if (!defined('ABSPATH')) exit;

$prefill = isset($_GET['prompt']) ? esc_textarea($_GET['prompt']) : '';
?>

<div class="wrap kacw-generator">

  <div class="kacw-header">
    <h1>AI Generator (Admin)</h1>
    <p>Create high-quality AI content with advanced controls.</p>
  </div>

  <!-- Prompt -->
  <div class="kacw-card">
    <div class="kacw-card-inner">
      <label>Enter Prompt</label>
      <textarea id="kacw-prompt"><?php echo $prefill; ?></textarea>
    </div>
  </div>

  <!-- Controls -->
  <div class="kacw-card">
    <div class="kacw-card-inner">

      <div class="kacw-row">

        <div class="kacw-field">
          <label>Tone</label>
          <select id="kacw-tone">
            <option value="formal">Formal</option>
            <option value="casual">Casual</option>
            <option value="seo">SEO</option>
            <option value="persuasive">Persuasive</option>
          </select>
        </div>

        <div class="kacw-field">
          <label>Length</label>
          <select id="kacw-length">
            <option value="short">Short</option>
            <option value="medium" selected>Medium</option>
            <option value="long">Long</option>
          </select>
        </div>

        <div class="kacw-field">
          <label>Type</label>
          <select id="kacw-type">
            <option value="blog">Blog</option>
            <option value="product">Product</option>
            <option value="ad">Ad</option>
          </select>
        </div>

      </div>

      <!-- Main Actions -->
      <div class="kacw-actions">
        <button id="kacw-generate" class="button button-primary">Generate</button>
      </div>

      <!-- Secondary Actions -->
      <div class="kacw-actions-secondary">
        <button id="kacw-generate-title" class="button">Titles</button>
        <button id="kacw-generate-outline" class="button">Outline</button>
        <button id="kacw-generate-all" class="button button-primary">Full Content</button>
        <button id="kacw-generate-seo" class="button">+ SEO</button>
      </div>

    </div>
  </div>

  <!-- Result -->
  <div class="kacw-card">
    <div class="kacw-card-inner">
      <h3>Output</h3>
      <div id="kacw-result"></div>
    </div>
  </div>

</div>