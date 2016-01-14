
function showReservationMessage(reservationId) {
	
	var dialog = $("#msgdialog");
	if(dialog.length == 0) {
		dialog = $("<div/>");
		dialog.attr("id", "msgdialog");
		$("#container").append(dialog);
	}
	
	$(dialog).dialog({
			modal: true,
			buttons: {
        		Ok: function() {
          			$( this ).dialog( "close" );
        		}
      		}
	});
	
    $.ajax({
        type: 'GET',
		dataType: "json",
        url: "ReservationMessages/get/"+reservationId,
        success: function(data,textStatus,xhr){
    	    var title = data.band +" "+ data.time+" "+data.date;
    		$(dialog).dialog("option", "title", title);
    		var text = data.message;
        	dialog.text(text);
        },
        error: function(xhr,textStatus,error){
        	dialog.text("An error occured. Message cant be displayed.");
        }
    });	
    
    
	
}