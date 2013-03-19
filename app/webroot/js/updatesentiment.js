$(document).ready(function(){
	$('.senti').change(function(){
		var sentiment= $(this).val();
		var id = $(this).attr('rel');
		$.ajax({
		  type: "POST",
		  url: Project.basePath+"CleanTweets/updatesentiment",
		  data: { sentiment: sentiment, id: id }
		}).done(function( msg ) {
		  alert( "Data Saved: " + msg );
		});
	});
	
	$('.manual').change(function(){
		var sentiment= $(this).val();
		var id = $(this).attr('rel'); 
		
		if(sentiment == 'netral' || sentiment == 'positif' || sentiment == 'negatif'){
			$.ajax({
			  type: "POST",
			  url: Project.basePath+"Pages/updatesentiment",
			  data: { sentiment: sentiment, id: id }
			}).done(function( msg ) {
			  alert( "Data Saved: " + msg );
			});
		}else{
			alert("Masukan : netral, positif,atau negatif");
		}
	});
});