$(document).ready(function() {
     $.material.init();
     $.material.input();

     $("#tabel").hide();

     $("#show").click(function() {
          $("#tabel").fadeIn();
     })
});
