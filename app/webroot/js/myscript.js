$(document).ready(function(){
	$('#text').change(function(){
		var term = $(this).val();
		
		$.ajax({
		  type: "POST",
		  url: Project.basePath+"/FormalWords/index",
		  data: { term: term}
		}).done(function( msg ) {
		  $('.box').empty().html(msg);
		});
	});
	
	
});