<?php
/*!
| @ Default configuration file
|------------------------------------------------------------------
| ! This file must be located in the root directory of your website
*/
	//! Show all errors
	// error_reporting(-1);

	//! Load the AbsTemplate class
	require 'includes/abstemplate.php';

	//! Set the path to the root directory
	$root = realpath(dirname(__FILE__)).'/';

	//! [Required] Set the path to the templates directory
	$tplDir = $root.'templates/';

	//! Set the path to the cache directory.
	//! Only required if you want to cache your templates,
	//! otherwise you can omit this field
	$cacheDir = $root.'cache/';

	//! [Optional] Set the left delimiter.
	$leftDelimiter = '{';

	//! [Optional] Set the right delimiter.
	$rightDelimiter = '}';

	//! [Optional] Set the default expire time. In hours.
	$defaultCacheLifetime = 1;

	//! Instantiate the Caching Template class
	$tpl = new AbsTemplate($tplDir, $cacheDir, $leftDelimiter, $rightDelimiter, $defaultCacheLifetime);
