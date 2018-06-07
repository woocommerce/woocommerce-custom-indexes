jQuery( document ).ready( function() {
	jQuery( '.wc-change-custom-indexes' ).click( 'click', function () {
		return window.confirm( wcCustomIndexesVars.confirmAction );
	});
} );