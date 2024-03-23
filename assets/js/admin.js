jQuery(document).ready(function ($) {
  // Handle form submission for saving JSON data
  $("#json-form").on("submit", function (event) {
    console.log(event);
    event.preventDefault();

    // Serialize form data
    var formData = $(this).serialize();
    console.log("formData: ", formData);
    // Send AJAX request to save JSON data
    $.ajax({
      url: ajaxurl, // WordPress AJAX URL
      type: "POST",
      data: {
        action: "save_json_data", // Custom AJAX action
        json_data: formData, // Serialized form data containing JSON
      },
      success: function (response) {
        // Handle success response
        console.log("JSON data saved successfully:", response);
      },
      error: function (xhr, status, error) {
        // Handle error response
        console.error("Error saving JSON data:", error);
      },
    });
  });
  console.log(1);
  document
    .getElementById("add-json-block")
    .addEventListener("click", function () {
      var jsonBlocks = document.getElementById("json-blocks");
      var newJsonBlock = document.createElement("div");
      newJsonBlock.classList.add("json-block");
      newJsonBlock.innerHTML = `
        <input type="text" name="json_names[]" placeholder="Enter JSON Name">
        <textarea name="json_data[]" rows="10" cols="50" placeholder="Enter JSON Data"></textarea>
        <button type="button" class="remove-json-block">Remove</button>
    `;
      jsonBlocks.appendChild(newJsonBlock);
    });

  // Remove JSON block
  document.addEventListener("click", function (event) {
    if (event.target && event.target.classList.contains("remove-json-block")) {
      event.target.closest(".json-block").remove();
    }
  });
});
