function callAjaxGetUsers() {
  console.log("calling ajax...");
  return new Promise((resolve, reject) => {
    jQuery.ajax({
      url: my_ajax_obj.ajax_url,
      type: "POST",
      data: {
        action: "get_bantal_users_by_ajax",
      },
      success: function (response) {
        resolve(response.data);
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
