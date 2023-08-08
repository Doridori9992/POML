$(document).ready(function() {
    const eye = $("#eye");
    const password = $("#password");

    eye.click(function(e) {
      e.preventDefault();
      eye.toggleClass("fa-eye-slash fa-eye");
      const currentType = password.attr("type");
      if (currentType === "password") {
        password.attr("type", "text");
      } else {
        password.attr("type", "password");
      }
    });
  });

  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }






