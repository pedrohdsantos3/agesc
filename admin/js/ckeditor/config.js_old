/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
CKEDITOR.editorConfig = function(config) {
	// Define changes to default configuration here. For example:
	config.language = 'pt-br';
	// config.uiColor = '#AADC6E';
	config.extraPlugins = 'imageuploader,internpage';
	config.imageUploadUrl = '../../classes/upload.class.php';
	config.filebrowserUploadUrl = '../../site/images/posts/';
	config.internalPages = $.getJSON("js/ckeditor/plugins/internpage/pages.php?type=json");
	config.InternPagesSelectBox = $.ajax("js/ckeditor/plugins/internpage/pages.php?type=js");
};