/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

// Register a templates definition set named "default".
CKEDITOR.addTemplates( 'default', {
	// The name of sub folder which hold the shortcut preview images of the
	// templates.
	imagesPath: CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'templates' ) + 'templates/images/' ),

	// The templates definitions.
	templates: [ {
		title: 'Image and Titlezzz',
		image: 'template1.gif',
		description: 'One main image with a title and text that surround the image.',
		html: '<div class="row">' +
				'<div class="col-md-3 arb">' + 'content' +
				'</div>' +
				'<div class="col-md-3 arb">' + 'content' +
				'</div>' +
				'<div class="col-md-3 arb">' + 'content' +
				'</div>' +
				'<div class="col-md-3 arb">' + 'content' +
				'</div>' +
			 '</div>'
	}
	
	]
} );
