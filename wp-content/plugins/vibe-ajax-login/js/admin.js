jQuery( function() {

	jQuery( '#enable-captcha' ).change(function() {
	
		var captchaOptions	= jQuery( '#captcha-options' );
		
		if( jQuery( '#enable-captcha' ).is( ':checked' ) )
			captchaOptions.show();
		else
			captchaOptions.hide();
		
	});
	
});