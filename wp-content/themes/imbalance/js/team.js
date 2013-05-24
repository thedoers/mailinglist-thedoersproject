(function($) {
	$(document).ready(function(){
   	
   	$(".team_member").hover(function() {
	   	console.log($(this).children(".member-over"));
	   	$(this).children(".member-over").stop().animate({"opacity": "1"}, "slow");
	   	},
	   	function(){
	   	$(this).children(".member-over").stop().animate({"opacity": "0"}, "slow");
   	});

   	$("#meet_team").click(function(){
   		$("#about").delay(2000).slideto({highlight: false});
   	});
   	
   	$(".about").click(function(){
   		$("#about").slideto({highlight: false});
   	});
   	$("#gotop").click(function(){
   		$("#top").slideto({highlight: false});
   	});
   	$(".add_comment").click(function(){
   		$("#respond").slideto({highlight: false});
   	}); 
});
})(jQuery);