/**
*	Site-specific configuration settings for Highslide JS
*/
hs.graphicsDir = '/libraries/highslide/graphics/'
hs.showCredits = false;
//hs.outlineType = 'custom';
//hs.dimmingOpacity = 0.5;
hs.registerOverlay({
	html: '<div class="closebutton" onclick="return hs.close(this)" title="Close"></div>',
	position: 'top right',
	useOnHtml: true,
	fade: 2 // fading the semi-transparent overlay looks bad in IE
});

