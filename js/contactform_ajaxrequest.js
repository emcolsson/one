$(document).ready(function() {  
console.log( "ready!" );
    $( '#ajaxContactForm' ).submit(ajaxSubmit);
    
function ajaxSubmit(e){

e.preventDefault();
var name = $( "#name" ).val();
var mail = $( "#mail" ).val();
var message = $( "#message" ).val();
var replyText = $( "#form-response" );
var status = $( ".status" );

$( "#submitButton" ).attr("disabled", true);
status.html( 'please wait...' );
console.log(status);
function clearForm() {
	$( "#name" ).val( '' ); 
    $( "#mail" ).val( '' );
	$( "#message" ).val( '' );
}
	
    $.ajax({ //ajax request
         url: MyAjax.ajaxurl, //wp's own admin-ajax.php that will handle the request
		 type: 'POST', //what kind of request: its a post-request, we are sending data to the server
		 datatype: 'json', //what datatype received back, explicitly stated json wanted
		 data: { //actual data sending
		 	"action": 'parser', //what action to execute, in this case parser in functions.php
			name: name,
			mail: mail,
			message: message,
		 	"nonce": MyAjax.nonce //send the nonce for security
		 },
         success: function( response ) {
			 status.html( response );
			 replyText.html ( '<h2>Thanks for contacting me '+ name +'! I will get back to you as soon as possible.</h2>' );
			 clearForm();
			 $( "#submitButton" ).attr("disabled", false);
		 },
		 error: function( error ) {
			 status.html( response );
             $( "#submitButton" ).attr("disabled", false);
		 },
		 beforeSubmit : function(arr, $form, options){
            arr.push( { "name" : "nonce", "value" : MyAjax } );
		 }
	});
	return false;
}
});