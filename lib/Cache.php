<?php
class Cache
{
    var $filename;
    
    public function __construct()
    {
        //usa a constante CACHE_PATH
		$this->filename = preg_replace("/([^a-zA-Z0-9])/",'_',($_SERVER["PHP_SELF"] . $_SERVER["QUERY_STRING"]));
    }
    
    public function __destruct()
    {
    }
    
    public function start()
    {
		if(CACHE == 1)
		{
			ob_start();
		}
    }
	
	public function stop()
    {
		if(CACHE == 1)
		{
			$bufferContent = ob_get_contents();
			 ob_end_flush();
	
			 $fp = fopen ( CACHE_PATH . $this->filename , 'w' ) or die ( 'Error opening cache file' );
				//  write buffer content to cache file
			 fwrite ( $fp , $bufferContent );
			 fclose( $fp );
		}
    }
	
	public function check()
    {
		if(CACHE == 1)
		{
			if(file_exists(CACHE_PATH . $this->filename))
			{
				readfile(CACHE_PATH . $this->filename);
				return 1;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
    }
	
	public function flush()
    {
        
    }
	
}
?>
