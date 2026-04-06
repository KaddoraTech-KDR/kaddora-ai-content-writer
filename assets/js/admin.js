jQuery(document).ready(function ($) {
  /**
   * SAVE TEMPLATE
   */
  $("#kacw-save-template").on("click", function () {
    let title = $("#kacw-temp-title").val().trim();
    let prompt = $("#kacw-temp-prompt").val().trim();

    if (!title || !prompt) {
      alert("Fill all fields");
      return;
    }

    $.post(
      kacw_ajax.ajax_url,
      {
        action: "kacw_save_template",
        nonce: kacw_ajax.nonce,
        title: title,
        prompt: prompt,
      },
      function (res) {
        alert(res.data);
        location.reload();
      },
    );
  });

  /**
   * USE TEMPLATE
   */
  $(document).on("click", ".kacw-use-template", function () {
    let prompt = $(this).data("prompt");

    window.location.href =
      "admin.php?page=kacw-generator&prompt=" + encodeURIComponent(prompt);
  });

  /**
   * SEO ANALYZE
   */
  $("#kacw-seo-analyze").on("click", function () {
    let content = $("#kacw-seo-content").val();
    let keyword = $("#kacw-seo-keyword").val();

    if (!content) {
      alert("Add content first");
      return;
    }

    $("#kacw-seo-result").html("Analyzing...");

    $.post(
      kacw_ajax.ajax_url,
      {
        action: "kacw_seo_analyze",
        nonce: kacw_ajax.nonce,
        content: content,
        keyword: keyword,
      },
      function (res) {
        if (res.success) {
          let data = res.data;

          let html = `<h3>Score: ${data.score}/100</h3>`;

          if (data.suggestions.length) {
            html += "<ul>";
            data.suggestions.forEach((s) => {
              html += `<li>${s}</li>`;
            });
            html += "</ul>";
          }

          $("#kacw-seo-result").html(html);
        }
      },
    );
  });

  /**
   * KEYWORD SUGGEST
   */
  $("#kacw-keyword-suggest").on("click", function () {
    let topic = $("#kacw-seo-keyword").val();

    if (!topic) {
      alert("Enter topic");
      return;
    }

    $.post(
      kacw_ajax.ajax_url,
      {
        action: "kacw_keyword_suggest",
        nonce: kacw_ajax.nonce,
        topic: topic,
      },
      function (res) {
        if (res.success) {
          let html = "<ul>";
          res.data.forEach((k) => {
            html += `<li>${k}</li>`;
          });
          html += "</ul>";

          $("#kacw-seo-result").html(html);
        }
      },
    );
  });

  /**
   * SAVE AUTOMATION
   */
  $("#kacw-save-automation").on("click", function () {
    let title = $("#kacw-auto-title").val().trim();
    let prompt = $("#kacw-auto-prompt").val().trim();

    if (!title || !prompt) {
      alert("Fill all fields");
      return;
    }

    $.post(
      kacw_ajax.ajax_url,
      {
        action: "kacw_save_automation",
        nonce: kacw_ajax.nonce,
        title: title,
        prompt: prompt,
      },
      function (res) {
        alert(res.data);
        location.reload();
      },
    );
  });

  /**
   * CHART
   */
  if (typeof kacw_chart !== "undefined") {
    const ctx = document.getElementById("kacwChart");

    if (ctx) {
      new Chart(ctx, {
        type: "line",
        data: {
          labels: kacw_chart.labels,
          datasets: [
            {
              label: "Content Generated",
              data: kacw_chart.data,
            },
          ],
        },
      });
    }
  }

  /**
   * CLEAR LOGS
   */
  $("#kacw-clear-logs").on("click", function () {
    if (!confirm("Clear all logs?")) return;

    $.post(
      kacw_ajax.ajax_url,
      {
        action: "kacw_clear_logs",
        nonce: kacw_ajax.nonce,
      },
      function (res) {
        alert(res.data);
        location.reload();
      },
    );
  });

  // DELETE HISTORY
  $(document).on("click", ".kacw-delete-history", function () {
    if (!confirm("Delete this item?")) return;

    let id = $(this).data("id");
    let row = $("#kacw-row-" + id);

    $.post(
      kacw_ajax.ajax_url,
      {
        action: "kacw_delete_history",
        nonce: kacw_ajax.nonce,
        id: id,
      },
      function (res) {
        if (res.success) {
          row.fadeOut(300, function () {
            jQuery(this).remove();
          });
        } else {
          alert(res.data || "Delete failed");
        }
      },
    );
  });
});
