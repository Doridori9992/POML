$(document).ready(function() {
  const eye = $("#eye");
  const password = $("#password");
  const ceye = $("#ceye");
  const cassword = $("#confirmpassword");

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


ceye.click(function(e) {
  e.preventDefault();
  ceye.toggleClass("fa-eye-slash fa-eye");
  const currentType = cassword.attr("type");
  if (currentType === "password") {
    cassword.attr("type", "text");
  } else {
    cassword.attr("type", "password");
  }
});
});

if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

