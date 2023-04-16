$(document).ready(function() {
    $(".close").click(function() {
       $('#neutralMessage').fadeOut("slow"); 
       $('#errMessage').fadeOut("slow"); 
       $('#posMessage').fadeOut("slow"); 
    });
  });