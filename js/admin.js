$(document).ready(function() {
	$("a.mobile").click(function() {
		$(".sidebar").slideToggle('fast');
		
		if ($(".menu-icons").attr('src') == 'img/menu.svg') {
			$(".menu-icons").attr('src',"img/menu2.svg");
		} else {
			$(".menu-icons").attr('src',"img/menu.svg");
		}
	})

	$(window).resize(function() {
		if ($(window).width() > 500) {
			$(".sidebar").show();
		}
	})

});