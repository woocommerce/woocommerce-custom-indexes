jQuery( document ).ready( function() {
	jQuery( '.wc-add-custom-indexes' ).click( 'click', function () {
		return window.confirm( wcCustomIndexesVars.confirmAction );
	});
} );