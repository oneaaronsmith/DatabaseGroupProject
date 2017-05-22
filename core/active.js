$(document).ready(function() {
  var current = '"' + $(location).attr("pathname") + '"'; // Find current page (escape characters appended)
  
  $("li.active").removeClass("active"); // Remove active class
  $("a[href=" + current + "]").parent("li").addClass("active"); // Add active class to current page
});
