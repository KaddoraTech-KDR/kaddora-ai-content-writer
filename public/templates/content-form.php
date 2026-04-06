<?php if (!defined('ABSPATH')) exit; ?>

<div class="kacw-container">

  <h2 class="kacw-title">AI Content Generator</h2>

  <!-- Input -->
  <textarea
    id="kacw-prompt"
    class="kacw-textarea"
    placeholder="Enter your topic..."></textarea>

  <!-- Template -->
  <select id="kacw-prebuilt" class="kacw-select">
    <option value="">Select Template</option>
    <option value="Write a blog post about">Blog Post</option>
    <option value="Write a product description for">Product</option>
    <option value="Write an advertisement for">Ad</option>
    <option value="Write SEO optimized article about">SEO Article</option>
  </select>

  <!-- Controls -->
  <div class="kacw-row">
    <select id="kacw-tone" class="kacw-select">
      <option value="formal">Formal</option>
      <option value="casual">Casual</option>
    </select>

    <select id="kacw-length" class="kacw-select">
      <option value="short">Short</option>
      <option value="medium" selected>Medium</option>
    </select>

    <select id="kacw-type" class="kacw-select">
      <option value="blog">Blog</option>
      <option value="product">Product</option>
    </select>
  </div>

  <!-- Generate -->
  <button id="kacw-generate" class="kacw-btn-primary">
    Generate Content
  </button>

  <!-- Actions -->
  <div class="kacw-actions">
    <button class="kacw-btn">Copy</button>
    <button class="kacw-btn">Download</button>
    <button class="kacw-btn">Copy HTML</button>
  </div>

  <!-- Result -->
  <div id="kacw-result" class="kacw-result"></div>

</div>