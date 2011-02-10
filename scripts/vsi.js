function more_tweets()
{
	$("#sidebar-right").addClass("shadowed").animate( { height:"500px"}, 500, null, function() 
																					{ 
																						$("#twitter_update_list").css("height", "380px");
																						$("#twitter_update_list > li").css("margin-bottom", "10px");
																						$("#more_tweets").html("less").attr("href", "javascript:less_tweets();"); 
																					} );
}

function less_tweets()
{
	$("#twitter_update_list > li").css("margin-bottom", "2000px");
	$("#sidebar-right").animate( { height:"259px"}, 500, null, function() 
															   { 
																	$("#more_tweets").html("more").attr("href", "javascript:more_tweets();"); 
																	$("#sidebar-right").removeClass("shadowed"); 
															   } );
}

function gotoMap(iwloc)
{
    $("#map").attr("src", "http://maps.google.com/maps/ms?ie=UTF8&hl=en&t=p&msa=0&msid=114643328193329788548.0004869a8fb7a76ea72ad&ll=-6.271618,34.519043&spn=13.076562,13.161621&z=6&output=embed&iwloc=" + iwloc);
}

