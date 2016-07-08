<?php

DEFINE('LH_CSS', 'static/css');
DEFINE('LH_JS', 'static/js');
DEFINE('LH_UI', 'static/ui');
DEFINE('LH_ICOMOON', 'static/icomoon');
DEFINE('LH_DIST', 'static/dist');
DEFINE('LH_IMAGES', 'static/img');

function getCssFile($filename) {
	return internalGetFile($filename, LH_CSS);
}

function getJsFile($filename) {
	return internalGetFile($filename, LH_JS);
}

function getUiFile($filename) {
	return internalGetFile($filename, LH_UI);
}

function getIcoMoonFile($filename) {
	return internalGetFile($filename, LH_ICOMOON);
}

function getDistFile($filename) {
	return internalGetFile($filename, LH_DIST);
}

function getImageFile($filename) {
	return internalGetFile($filename, LH_IMAGES);
}

function internalGetFile($filename, $basePath) {
	if (WP_DEBUG) {
		$localFilepath = sprintf('%s/%s/%s', TEMPLATEPATH, $basePath, $filename);
		if (file_exists($localFilepath) == false) throw new Exception('Cannot find file: ' . $localFilepath);
	}
	$filepath = sprintf('%s/%s/%s', get_template_directory_uri(), $basePath, $filename);
	return $filepath;
}