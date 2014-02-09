<?PHP
/*
Taken from http://davidwalsh.fileName/php-cache-function
*/
class Cache{
	var $CACHE_DIR = "cache/";
	var $EXPIRE_TIME = 60;
	var $currentTime;

	function Cache(){
		$this->currentTime = time();
	}

	//ACTUALLY CHECK IF FILE EXISTS
	function exists($fileName){
		return file_exists($this->CACHE_DIR . $fileName) && ($this->currentTime - $this->EXPIRE_TIME < filemtime($this->CACHE_DIR . $fileName));
	}


	function get($fileName){
		$file_time = filemtime($this->CACHE_DIR . $fileName);

		if($this->exists($fileName)) {
			return file_get_contents($this->CACHE_DIR . $fileName);
		}
		if(exists("json_" . $fileName)) {
			return json_decode(file_get_contents($this->CACHE_DIR . $fileName));
		}
	}

	/**
	 * Files are cached in the cache directory, with a prefix of json_ if they need to be decoded.
	 **/
	function setCache($fileName,$content,$isString = true){
		file_put_contents($this->CACHE_DIR . ($isString ? "" : "json_") . $fileName,($isString ? $content : json_encode($content)));
	}
}