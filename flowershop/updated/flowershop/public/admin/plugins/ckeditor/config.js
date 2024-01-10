/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

// CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
// };

CKEDITOR.editorConfig = function( config ) {
	config.removeDialogTabs = 'image:advanced;image:Link;image:info';
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode' ] },
		{ name: 'clipboard', groups: [ 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles' ] },
		{ name: 'styles', groups: [ 'styles', 'HorizontalRule', 'colors' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] },
		{ name: 'about', groups: [ 'insert' ] }
	];
	config.removePlugins = 'cloudservices';
	config.removeButtons = 'PasteFromWord,Paste,Copy,Cut,PasteText,Clipboard,SpellChecker,Templates,Save,NewPage,Print,Replace,Find,SelectAll,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,RemoveFormat,CreateDiv,Language,Anchor,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Styles,Format,Font,BGColor,About,ShowBlocks';
};