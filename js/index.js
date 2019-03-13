$(document).ready(function(){
	$("#check-button").click(function(){
		$("#results-container").show();
	});
	
	$("#clear-button").click(function(){
	    $("#textarea").val("");
	    $("#results-container").hide();
	});
});



