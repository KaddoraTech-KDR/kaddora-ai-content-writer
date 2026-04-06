(function ($) {
  "use strict";

  const KACW = {
    init: function () {
      this.bindEvents();
    },

    bindEvents: function () {
      // MAIN GENERATE
      $(document).on("click", "#kacw-generate", this.generate);

      // EXTRA FEATURES
      $(document).on("click", "#kacw-copy", this.copy);
      $(document).on("click", "#kacw-download", this.download);
      $(document).on("click", "#kacw-html", this.copyHTML);

      // MODULE BUTTONS
      $(document).on("click", "#kacw-generate-title", this.generateTitle);
      $(document).on("click", "#kacw-generate-outline", this.generateOutline);
      $(document).on("click", "#kacw-generate-all", this.generateAll);

      // PREBUILT
      $(document).on("change", "#kacw-prebuilt", this.applyTemplate);

      // generate seo
      $(document).on("click", "#kacw-generate-seo", function () {
        $("#kacw-generate").click();
      });
    },

    /**
     * MAIN GENERATE
     */
    generate: function () {
      let prompt = $("#kacw-prompt").val().trim();
      let tone = $("#kacw-tone").val() || "formal";
      let length = $("#kacw-length").val() || "medium";
      let type = $("#kacw-type").val() || "blog";

      if (!prompt) {
        alert("Enter prompt");
        return;
      }

      let finalPrompt = `Write a ${length} ${type} in a ${tone} tone.\n\nTopic: ${prompt}`;

      KACW.loading(true);

      $.post(
        kacw_ajax.ajax_url,
        {
          action: "kacw_generate",
          nonce: kacw_ajax.nonce,
          prompt: finalPrompt,
        },
        function (res) {
          if (res.success) {
            KACW.render(res.data);
          } else {
            KACW.error(res.data || "Error");
          }
        },
      )
        .fail(function () {
          KACW.error("Server error");
        })
        .always(function () {
          KACW.loading(false);
        });
    },

    /**
     * RENDER OUTPUT
     */
    render: function (content) {
      let html = `
        <div class="kacw-output">
          <div style="margin-bottom:10px;">
            <button id="kacw-copy" class="button">Copy</button>
            <button id="kacw-download" class="button">Download</button>
            <button id="kacw-html" class="button">Copy HTML</button>
          </div>
          <pre id="kacw-text">${KACW.escape(content)}</pre>
        </div>
      `;

      $("#kacw-result").html(html);
    },

    /**
     * COPY TEXT (FIXED)
     */
    copy: function () {
      let text = $("#kacw-text").text();

      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
          alert("Copied");
        });
      } else {
        // fallback (important 🔥)
        let textarea = document.createElement("textarea");
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert("Copied");
      }
    },

    /**
     * DOWNLOAD
     */
    download: function () {
      let text = $("#kacw-text").text();

      let blob = new Blob([text], { type: "text/plain" });
      let url = URL.createObjectURL(blob);

      let a = document.createElement("a");
      a.href = url;
      a.download = "ai-content.txt";
      a.click();

      URL.revokeObjectURL(url);
    },

    /**
     * COPY HTML (FIXED)
     */
    copyHTML: function () {
      let html = $("#kacw-text").html();

      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(html).then(() => {
          alert("HTML copied");
        });
      } else {
        let textarea = document.createElement("textarea");
        textarea.value = html;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert("HTML copied");
      }
    },

    /**
     * MODULES
     */
    generateTitle: function () {
      let topic = $("#kacw-prompt").val();

      $("#kacw-result").html("Generating titles...");

      $.post(
        kacw_ajax.ajax_url,
        {
          action: "kacw_generate_title",
          nonce: kacw_ajax.nonce,
          topic: topic,
        },
        function (res) {
          if (res.success) {
            $("#kacw-result").html("<pre>" + res.data + "</pre>");
          }
        },
      );
    },

    generateOutline: function () {
      let topic = $("#kacw-prompt").val();

      $("#kacw-result").html("Generating outline...");

      $.post(
        kacw_ajax.ajax_url,
        {
          action: "kacw_generate_outline",
          nonce: kacw_ajax.nonce,
          topic: topic,
        },
        function (res) {
          if (res.success) {
            $("#kacw-result").html("<pre>" + res.data + "</pre>");
          }
        },
      );
    },

    generateAll: function () {
      let topic = $("#kacw-prompt").val();

      $("#kacw-result").html("Generating full content...");

      $.post(
        kacw_ajax.ajax_url,
        {
          action: "kacw_generate_all",
          nonce: kacw_ajax.nonce,
          topic: topic,
        },
        function (res) {
          if (res.success) {
            let d = res.data;

            let html = `
            <h3>Titles</h3><pre>${d.titles}</pre>
            <h3>Outline</h3><pre>${d.outline}</pre>
            <h3>Content</h3><pre>${d.content}</pre>
          `;

            $("#kacw-result").html(html);
          }
        },
      );
    },

    /**
     * PREBUILT
     */
    applyTemplate: function () {
      let val = $(this).val();
      if (val) $("#kacw-prompt").val(val + " ");
    },

    /**
     * UI HELPERS
     */
    loading: function (state) {
      if (state) {
        $("#kacw-result").html("Generating...");
        $("#kacw-generate").prop("disabled", true);
      } else {
        $("#kacw-generate").prop("disabled", false);
      }
    },

    error: function (msg) {
      $("#kacw-result").html(`<p style="color:red;">${msg}</p>`);
    },

    escape: function (text) {
      return $("<div>").text(text).html();
    },
  };

  $(document).ready(function () {
    KACW.init();
  });
})(jQuery);
