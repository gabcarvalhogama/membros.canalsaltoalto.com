<?php
	class DB{
		public static function open(){
	        try{
	            return new PDO("mysql:host=localhost;dbname=gabcarvalhogama_csa;charset=utf8mb4", "gabcarvalhogama_csa", "ddYVR(D%.M.?", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'set lc_time_names="pt_BR"'));
	        }catch(PDOException $e){
	            error_log("Failed to connect to database: ".$e);
	        }
	    }
	}