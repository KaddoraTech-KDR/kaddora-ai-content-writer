<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap kacw-seo">

  <div class="kacw-header">
    <h1>SEO Assistant</h1>
    <p>Analyze your content and improve search engine performance.</p>
  </div>

  <!-- INPUT SECTION -->
  <div class="kacw-card">
    <div class="kacw-card-inner">

      <div class="kacw-seo-form">

        <div class="kacw-field">
          <label>Content</label>
          <textarea id="kacw-seo-content" placeholder="Paste your content..."></textarea>
        </div>

        <div class="kacw-field">
          <label>Focus Keyword</label>
          <input type="text" id="kacw-seo-keyword" placeholder="Enter keyword">
        </div>

        <div class="kacw-actions">
          <button class="button button-primary" id="kacw-seo-analyze">
            Analyze SEO
          </button>

          <button class="button" id="kacw-keyword-suggest">
            Suggest Keywords
          </button>
        </div>

      </div>

    </div>
  </div>

  <!-- RESULT -->
  <div class="kacw-card">
    <div class="kacw-card-inner">
      <h3>SEO Result</h3>
      <div id="kacw-seo-result"></div>
    </div>
  </div>

</div>