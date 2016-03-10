<?php
class Benchmark
{
    var $time_start;
	var $time_end;
	
	var $memory_start;
	var $memory_end;
	var $memory_peak;
    
    public function __construct()
    {
		$this->start();
    }
    
    public function __destruct()
    {
    }
    
    public function start()
    {
		if(BENCHMARK == 1)
		{
			$this->time_start = microtime(true);
			$this->memory_start = memory_get_usage();
		}
    }
	
	public function stop()
    {
		if(BENCHMARK == 1)
		{
			
			$this->time_end = microtime(true);
			$this->memory_end = memory_get_usage();
			$this->memory_peak = memory_get_peak_usage();
			
			$time = round(($this->time_end - $this->time_start), 2);
			echo "<pre class=\"benchmark\">";
			echo "time: $time seconds<br />";
			echo "memory_get_usage: " . round((($this->memory_end - $this->memory_start) / 1024 / 1024),2) . " Mbytes \n";
			echo "memory_get_peak_usage: " . round(($this->memory_peak / 1024 / 1024),2) . " Mbytes \n";
			echo "</pre>";
		}
    }
	
}
?>
