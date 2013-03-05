$(document).ready(function(){
	$('#text').change(function(){
		var term = $(this).val();
		
		$.ajax({
		  type: "POST",
		  url: "http://localhost/mythesis/FormalWords/index",
		  data: { term: term}
		}).done(function( msg ) {
		  $('.box').empty().html(msg);
		});
	});
	
	
});