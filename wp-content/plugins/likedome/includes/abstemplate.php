<?php
/*
*	ChangeLog:
*		:: Date: Feb 25, 2011
*		===========================================
*			:: This project has been revised && it is now hosted on http://coderevision.com
*			   instead of june-js.com, domain that I no loner own.
*			:: This class has been made chainable, that is you can call its methods one after another
*
*		:: Date: Apr 28, 2009
*		===========================================
*			:: The new property ($defaultCacheExpireTime) has been added && represent the default expiry time to set
*				when caching templates.
*			:: A new parameter ($defaultExpiryTime) has been added to the constructor
*			:: A new public method (SetDefaultExpireTime) has been added to this class && will set the default expiry time
*/
/**
* class AbsTemplate
*
* The Template Engine's base class.
*
* Features:
*     - set your own custom delimiters for variables to use inside template files,
*     - use any type of templates you want, that is, the template files can have any extension you want(be it .php, .inc, .tpl, etc...),
*     - display multiple templates per page,
*     - cache templates,
*     - assign the content of a template to a variable and, when appropriate, just display its content.
* 
* @package    AbsTemplate
* @category   Template, Cache
* @author     Costin Trifan <office@coderevision.com>
* @copyright  2009 Costin Trifan
* @licence    MIT License http://en.wikipedia.org/wiki/MIT_License
* @version    1.1
* 
* Copyright (c) 2009 Costin Trifan <http://coderevision.com/>
* 
* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software && associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, && to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:
* 
* The above copyright notice && this permission notice shall be
* included in all copies or substantial portions of the Software.
* 
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.
*/
class AbsTemplate 
{
	private function __clone(){}

# PROTECTED PROPERTIES
#======================

	protected 
		$tpl_dir = 'templates',	# The name of the folder where the template files are supposed to be stored.
		$cache_dir = '',		# The name of the folder where the cached template files are supposed to be stored.
		$left_delimiter = '{',	# The left delimiter to use in the templates files to mark a template variable.
		$right_delimiter = '}',	# The right delimiter to use in the templates files to mark a template variable.
		$vars = array(),		# The class's variables array.
		$defaultCacheExpireTime = 0; # Set the default templates' cache expiry time to 1 hour


# PUBLIC METHODS
#======================

	/**
	* Constructor. Setup class's variables.
	*
	* @param string $tplDir  The path to the templates directory. Must end with /
	* @param string $cacheDir  The path to the folder that stores the cached files. If omitted, caching will not be available. Must end with /
	* @param string $lDelim  The left delimiter to use in the templates files to mark a template variable. Defaults to: {
	* @param string $rDelim  The right delimiter to use in the templates files to mark a template variable. Defaults to: }
	* @param int $defaultExpireTime  The default templates' cache expiry time. Defaults to: 0
	* @return void
	*/
	public function __construct( $tplDir, $cacheDir = '', $lDelim = '{', $rDelim = '}', $defaultExpiryTime = 0 )
	{
		$this->SetTemplatesDirectory($tplDir);
		$this->SetCacheDirectory($cacheDir);
		$this->SetLeftDelimiter($lDelim);
		$this->SetRightDelimiter($rDelim);
		$this->SetDefaultExpireTime($defaultExpiryTime);
	}

	/*!
	* @ Set the default expire time for cached files.
	* @return $this
	*/
	public function SetDefaultExpireTime( $defaultCacheExpireTime = 0 )
	{
		$defaultCacheExpireTime = intval($defaultCacheExpireTime);

		if ( ! empty($defaultCacheExpireTime) )
		{
			$this->defaultCacheExpireTime = $defaultCacheExpireTime;
		}
		return $this;
	}

	/**
	* Set the path to the templates directory.
	*
	* @param string $tplDir  The path to the templates folder.
	* @return $this
	*/
	public function SetTemplatesDirectory( $tplDir )
	{
		if (empty($tplDir))
		{
			exit('The templates directory was not found!');
		}
		else
		{
			if ( ! is_dir($tplDir)) {
				exit('The templates directory was not found!');
			}
			if ( ! is_readable($tplDir)) {
				exit('The templates directory cannot be read! Check for permissions!');
			}
		}

		$this->tpl_dir = $tplDir;

		return $this;
	}

	/**
	* Set the path to the cache directory.
	*
	* @param string $cacheDir  The path to the cache directory.
	* @return $this
	*/
	public function SetCacheDirectory( $cacheDir )
	{
		if ( ! empty($cacheDir))
		{
			if ( ! is_dir($cacheDir)) {
				exit('The cache directory was not found!');
			}
			if ( ! is_readable($cacheDir) || ! is_writable($cacheDir)) {
				exit('The cache directory is not accessible! Check for permissions!');
			}

			$this->cache_dir = $cacheDir;
		}
		return $this;
	}

	/**
	* Set the left delimiter to use in the templates files to mark a template variable.
	*
	* @param string $delim  The left delimiter to use in the templates files to mark a template variable.
	* @return $this
	*/
	public function SetLeftDelimiter( $delim )
	{
		if ( ! empty($delim)) {
			$this->left_delimiter = $delim;
		}
		return $this;
	}

	/**
	* Set the right delimiter to use in the templates files to mark a template variable.
	*
	* @param string $delim  The right delimiter to use in the templates files to mark a template variable.
	* @return $this
	*/
	public function SetRightDelimiter( $delim )
	{
		if ( ! empty($delim)) {
			$this->right_delimiter = $delim;
		}
		return $this;
	}

	/**
	* Add a variable to the vars array. This variable will be replaced in a template.
	*
	* @param string $name  The name of the variable to store in the vars array.
	* @param mixed $value  The value of the variable.
	* @return $this
	*/
	public function SetVar( $name, $value )
	{
		$this->vars[$name] = $value;
		return $this;
	}

	/**
	* Get a variable from the vars array.
	*
	* @param string $name  The name of the variable to retrieve from the vars array.
	* @return mixed
	*/
	public function GetVar( $name )
	{
		if (isset($this->vars[$name]) && !empty($this->vars[$name])) {
			return $this->vars[$name];
		}
		return '';
	}

	/**
	* Delete all variables from the vars array.
	*
	* @return $this
	*/
	public function ClearVars()
	{
		$this->vars = array();
		return $this;
	}

	/**
	* Get all variables from the vars array.
	*
	* @return array
	*/
	public function GetAllVars()
	{
		return $this->vars;
	}

	/**
	* Retrieve the content of a template.
	*
	* @param string $tplFileName  The name of the template file to load.
	* @param int $expires  The length of time, in hours, a file should be cached.
	*	Set to 0(zero) when you don't want to cache a template, or when you want to use the
	*   default expire time.
	* @return string  The template's html content.
	*/
	public function GetTemplate( $tplFileName, $expires = 0 )
	{
		// if $expires == 0 the template's content will not be cached
		if (empty($expires))
		{
			return $this->Parse($tplFileName);
		}

		// if $expires > 0 , it will override the default expire time
		else
		{
			if ($expires > 0) {
				// overide the default expiry time
				$expires = ($expires *60*60) + time();
			}

			if ($this->IsCached($tplFileName))
			{
				if ($this->HasCacheExpired($tplFileName))
				{
					// cache the template again
					$content = $this->Parse($tplFileName);
					$this->CacheTemplate($tplFileName,$content,$expires);
					return $content;
				}
				// get cached template
				else return $this->GetCachedFile($tplFileName);
			}
			else {
				// cache template
				$content = $this->Parse($tplFileName);
				$this->CacheTemplate($tplFileName,$content,$expires);
				return $content;
			}
		}
	}

	/**
	* Outputs the template's html content.
	*
	* @param string $tplFileName  The name of the template file to load.
	* @return string  The template file's content.
	*/
	public function Display( $tplFileName )
	{
		echo $this->GetTemplate($tplFileName,'nocache');
	}



# CACHING METHODS
#======================

	/**
	* Delete all templates from the cache directory.
	*
	* @return $this
	*/
	public function EmptyCacheDirectory()
	{
		$files = $this->GetCachedFiles();
		if ( ! empty($files)) {
			foreach ($files as $file) {
				@unlink($this->cache_dir.$file);
			}
		}
		return $this;
	}

	/**
	* Delete a cached template.
	*
	* @param string $fileNames  The name(s) of the file(s) to delete.
	* @return $this
	*/
	public function DeleteCached(/*$fileName, $fileName,...*/)
	{
		$files = func_get_args();
		if (count($files) > 1) {
			foreach ($files as $file) {
				$_file = $this->cache_dir.$this->SetCacheFileName($file);
				if (file_exists($_file)) {
					@unlink($_file);
				}
			}
		}
	}

	/**
	* Check to see if the specified file exists in the cache directory.
	*
	* @param string $fileName  The name of the file to check for existance.
	* @return boolean
	*/
	public function IsCached( $fileName )
	{
		if (empty($fileName)) return false;
		
		$file = $this->cache_dir.$this->SetCacheFileName($fileName);
		return (file_exists($file) ? true : false);
	}

	/**
	* Get the specified cached file's expire time.
	* <code>
	*	echo date("l F,Y h:i:s", $tpl->GetCacheExpireTime('header.php'));
	* </code>
	* @param string $fileName  The name of the file.
	* @return string
	*/
	public function GetCacheExpireTime( $fileName )
	{
		$content = '';
		$lines = file($this->cache_dir.$this->SetCacheFileName($fileName));
		$expire_date = trim($lines[0]);
		$expire_date = substr($expire_date,1,-1);
		return $expire_date;
	}



# PROTECTED METHODS
#======================

	/**
	* Replaces the variables from the specified template file.
	*
	* @access protected
	* @param string $template  The name of the template file to load.
	* @return string  The template file's content.
	*/
	protected function Parse( $template )
	{
		ob_start();
			@include( $this->tpl_dir.$template );
			$content = ob_get_contents();
		ob_end_clean();

		if (count($this->vars) > 0)
		{
			foreach($this->vars as $name=>$value)
			{
				if (is_string($value))
				{
					$var = $this->left_delimiter.$name.$this->right_delimiter;
					$content = str_ireplace($var, $value, $content);
				}
			}
		}
		return $content;
	}

	/**
	* Cache a template.
	*
	* @access protected
	* @param string $fileName  The name of the template to cache.
	* @param string $fileContent  The html/text content of the template file.
	* @param integer $expires In hours, the length of time the cached template should be kept in the cache folder.
	* @return boolean true if the file is created, otherwise false
	*/
	protected function CacheTemplate( $fileName, $fileContent, $expires )
	{
		if ( ! is_dir($this->cache_dir)) { return false; }

		// Create a new cache
		$fileName = $this->SetCacheFileName($fileName);
		$expires = '['.$expires.']'."\n";
		$fileContent = $expires . htmlentities($fileContent, ENT_QUOTES, 'UTF-8');

		return ((file_put_contents($this->cache_dir.$fileName, $fileContent, LOCK_EX) > 0) ? true : false);
	}

	/**
	* Check to see whether or not a specified cached file has expired.
	*
	* @access protected
	* @param string $fileName  The name of the file.
	* @return boolean
	*/
	protected function HasCacheExpired( $fileName )
	{
		$file_expire_date = (int) $this->GetCacheExpireTime($fileName);
		return ($file_expire_date >= time()) ? false : true;
	}

	/**
	* Set the name for the file to be cached.
	*
	* @access protected
	* @param string $file  The name of the template.
	* @return string
	*/
	protected function SetCacheFileName( $file )
	{
		return md5($file);
	}

	/**
	* Get all files from the cache directory.
	* @access protected
	* @return array
	*/
	protected function GetCachedFiles()
	{
		$fileList = array();

		if ( ! is_dir($this->cache_dir) || ! is_readable($this->cache_dir)) { return $fileList; }

		if ($dir = opendir($this->cache_dir))
		{
			return glob($this->cache_dir."*");
		}
		return $fileList;
	}

	/**
	* Get the content of a cached file
	*
	* @access protected
	* @param string $file  The name of the template.
	* @return string
	*/
	protected function GetCachedFile( $file )
	{
		$content = '';
		$lines = file($this->cache_dir.$this->SetCacheFileName($file));
		$all_lines = count($lines);
		/*! except the first line that holds the file's expire time !*/
		for ($i=1; $i < $all_lines; $i++)
		{
			$content .= html_entity_decode($lines[$i],ENT_QUOTES,'UTF-8');
		}
		return $content;
	}
}
/*! End file AbsTemplate.php !*/