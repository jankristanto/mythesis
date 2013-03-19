$(document).ready(function(){
    $( "#pgbar" ).hide();
    $(document).ajaxStart(function() {
        $( "#formhunt" ).hide();
        $( "#pgbar" ).show();
    }); 
    $(document).ajaxComplete(function(){
        $( "#pgbar" ).hide();
    });
	
    $('#HuntIndexForm').submit(function(){
        var keyword = $('#HuntKeyword').val();
        
        $.ajax({
          type: "POST",
          url: Project.basePath+"Hunts/index",
          data: { keyword: keyword},
          dataType : 'json'
        }).done(function( msg ) {
          //alert( "Data Saved: " + msg.data.status );
          $( "#formhunt" ).html(
            '<h2>Ditemukan '+msg.data.jumlah+' Tweets</h2> <br/>'+
            '<a class="button" href="'+Project.basePath+'Tweets/preprocessing/'+msg.data.hunt+'">Lakukan Preprocessing</a>'
            ).show();
        }); 
		
		return false; 
    });
});