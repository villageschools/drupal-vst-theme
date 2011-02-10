<?php

    require_once dirname(__file__) . "/config.php";
    
   /** dbg()
	* Description: Saves the message to the debugging log if the site is in debug mode.
	* Example:
	*	dbg("Something broke.");
	*
	* @param string $msg: The debug message to output.
	* @return: dbg() doesn't return a value.
	*/
	function dbg($instr)
	{
		if (is_string($instr))
			$str = $instr;
		else
			$str = print_r($instr, true);
		
		if (defined("DEBUG") && DEBUG && defined("DIR_FS_LOGS"))
			write_to_log($str, DIR_FS_LOGS . "/debug.log");
	}

   /** write_to_log()
	* Description: Writes an entry to the specified log file and time-stamps it.
	* Example:
	*	write_to_log("An ID-10-T error occurred at layer 8 of the OSI model.", "/var/log/myapp.log");
	*
	* @param string $str: The entry to log.
	* @param string $logfile: The file to log it to.
	* @return: write_to_log() doesn't return a value.
	*/
	function write_to_log($str, $logfile)
	{
		$success = false;
		
		if (!file_exists($logfile))
			@touch($logfile);
	
		if (is_writable($logfile))
		{
			if ($fp = @fopen($logfile, "a+"))
			{
				fwrite($fp, date('m/d/Y H:i:s') . " " . $str . "\n");
				fclose($fp);
				$success = true;
			}
		}
	
		return $success;
	}

   /** handle_error()
	* Description: Our custom error handler - logs the error to the debug log
	*
	* @return: handle_error() returns false, to allow for PHP to continue processing the error.
	*/
    function handle_error($errno, $errstr, $errfile, $errline) 
    {
        dbg ("Error " . $errno . " in " . $errfile . " on line " . $errline . ": " . $errstr);
		return false;
	}
?>