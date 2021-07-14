$(document).ready(function(){
	$('.verse-content').click(function(){
		$action= $(this).next();
		$notaction = $(this).parent('li').siblings('li').children('.verse-actions');
		$action.slideToggle();
		$notaction.slideUp(); 
	})
});