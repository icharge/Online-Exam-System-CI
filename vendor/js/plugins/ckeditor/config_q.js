/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// CUSTOM CONFIGUARATION for Question
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	config.toolbar = 'Question';

	config.toolbar_Question = [
		[ 'Undo','Redo','-','Cut','Copy','Paste','-','PasteText','PasteFromWord','-','Maximize' ],'/',
		[ 'Find','Replace' ],
		[ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','TextColor','BGColor','-',
			'NumberedList','BulletedList','Outdent','Indent','Blockquote','-','Image','Table','Smiley','-','Link','Unlink' ],'/',
		[ 'Font','FontSize','-','RemoveFormat','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-', ],

	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	//config.removeButtons = '';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';

	// Skin
	config.skin = 'office2013';

	// Lang
	config.language = 'th';

	config.heigth = '128px';

	config.font_names = 'Arial/Arial, Helvetica, sans-serif;' +
	'Angsana New/Angsana New, Angsana UPC;' +
	'Comic Sans MS/Comic Sans MS, cursive;' +
	'Courier New/Courier New, Courier, monospace;' +
	'Georgia/Georgia, serif;' +
	'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
	'Tahoma/Tahoma, Geneva, sans-serif;' +
	'Times New Roman/Times New Roman, Times, serif;' +
	'TH Sarabun New/TH Sarabun New, TH Sarabun PSK;' +
	'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
	'Verdana/Verdana, Geneva, sans-serif';
};
