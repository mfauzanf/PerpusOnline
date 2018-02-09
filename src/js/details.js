$(document).ready(function() {
    $('#reviewButton').click(function() {
    	var d = new Date();
    	var month = d.getMonth();
    	var day = d.getDate();
    	var year = d.getFullYear();
    	var date = year + "/" + month + "/" + day;
    	var isiReview = $('#review').val();
    	var book_id = $('#book_id').val();
       	$.ajax({
    		url: "addReview.php",
    		type: "POST",
    		data:{
    			"addReview": true,
    			"date": date,
    			"review" : isiReview,
    			"book_id" : book_id
    		},
    		success: function(data) {
    			displayReview();
    			$("#review").val('');
    		}
    	});
    });
});
function displayReview() {
	var book_id = $('#book_id').val();
	$.ajax({
		url: "addReview.php",
		type: "POST",
		data:{
			"display":true,
			"book_id" : book_id
		},
		success: function(data) {
			$('#allReview').html(data);
		}
	});
}