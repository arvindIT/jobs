/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
   config.language = 'en';
   config.pasteFromWordRemoveStyles = false;
   config.pasteFromWordRemoveFontStyles = false;
   config.allowedContent = true;
   config.removeButtons = 'NewPage,Save,Preview,Print,Templates';
   config.removePlugins  = 'uploadcare,xdsoft_translater';
   config.filebrowserUploadUrl = CSF_VARIABLE.base_url+'ckupload/';
   config.basicEntities = false;
   config.extraPlugins = 'timestamp';
};
