$('document').ready(function(){
//
function cleanInput(input){
  input = input + ''; //force string conversion
  return encodeURI(input.trim());
};

function getSearchResults(){
   	//get input
   	var q = cleanInput($(this).val());

   	if(q=='' || q ==null || q== undefined){
   		//do not accept invalid search params
   		return;
   	}

    //fire ajax  

    $.ajax({
    	url: "search.php?q="+q,
    	method: "GET",
    	dataType: "html",
    	success: function(results) {
    		$('#search-results').html(results);
    	}
    });
};


$('#search-input').on('keyup', $.debounce( 250, getSearchResults));

});