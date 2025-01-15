function callAjaxGetUsers(targetUserRole, userLat, userLong) {
  console.log("calling ajax...");
  return new Promise((resolve, reject) => {
    jQuery.ajax({
      url: my_ajax_obj.ajax_url,
      type: "POST",
      data: {
        action: "get_bantal_users_by_ajax",
        userRole: targetUserRole,
        userLat: userLat,
        userLong: userLong,
      },
      success: function (response) {
        console.log("ajax call succeeded");
        console.log(targetUserRole, userLat, userLong);
        console.log(response);
        resolve(response.data);
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}
