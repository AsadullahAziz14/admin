/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here.
  // For the complete reference:
  // http://docs.ckeditor.com/#!/api/CKEDITOR.config

  // The toolbar groups arrangement, optimized for two toolbar rows.

  config.extraPlugins = "sourcearea";

  config.extraPlugins +=
    (config.extraPlugins.length == 0 ? "" : ",") + "ckeditor_wiris";

  config.allowedContent = true;

  
};
