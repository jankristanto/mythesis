$(document).ready(function(){
	$('.senti').change(function(){
		var sentiment= $(this).val();
		var id = $(this).attr('rel')
		$.ajax({
		  type: "POST",
		  url: "http://localhost/twitter/CleanTweets/updatesentiment",
		  data: { sentiment: sentiment, id: id }
		}).done(function( msg ) {
		  alert( "Data Saved: " + msg );
		});
	});
});