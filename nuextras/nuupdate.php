<?php

class nuupdate extends nuextras {

	var $github_url 	= "https://github.com/nuSoftware/nuBuilder4/archive/master.zip";
	var $dir        	= '';
	var $zip_dest   	= '';
	var $path       	= '';
	var $nuconfig		= '';
	var $source		= '';
	var $dest		= '';
	var $sql		= '';
	var $t      		= array();

	function buildTableSchema() {

		$DBName 	= $this->DBName;
        	$a 		= array();
        	$sql		= "SELECT TABLE_NAME FROM TABLES WHERE TABLE_SCHEMA = :db ";
                $values         = array(":db"=>$DBName);
                $t              = $this->runQuery($sql, $values, 'information_schema');

        	while( $r = $t->fetch(PDO::FETCH_OBJ) ) {

                	$tn 	= $r->TABLE_NAME;
                	$a[$tn] = array('names' => $this->db_field_names($tn), 'types' => $this->db_field_types($tn), 'primary_key' => $this->db_primary_key($tn), 'valid' => 1);

        	}

        	return $a;
	}

	function prepareDatabase() {

		$sql            = "DROP VIEW IF EXISTS zzzzsys_report_data";
        	$this->runQuery($sql);

        	$sql            = "DROP VIEW IF EXISTS zzzzsys_run_list";
		$this->runQuery($sql);

		$t = $this->t;	
        	for ( $i = 0; $i < count($t); $i++ ) {

                	$table  = $t[$i];
                	$sql    = "DROP TABLE IF EXISTS sys_$table";
			$this->runQuery($sql);

                	$sql    = "CREATE TABLE sys_$table SELECT * FROM $table";
			$this->runQuery($sql);

                	if($table != 'zzzzsys_debug'){
                        	$sql = "DROP TABLE IF EXISTS $table";
				$this->runQuery($sql);	
                	}
    		}
	}

	function importSystem(){

        	try{

                	$file 		= $this->sql;
                	@$handle 	= fopen($file, "r");
                	$temp 		= "";

                	if($handle){

                        	 $this->runQuery("DROP TABLE IF EXISTS zzzzsys_debug");

                        	while(($line = fgets($handle)) !== false){

                                	if($line[0] != "-" AND $line[0] != "/"  AND $line[0] != "\n"){

                                        	$line                   = trim($line);
                                        	$temp                   .= $line;
                                        	if(substr($line, -1) == ";"){
                                                	$temp   = rtrim($temp,';');
                                                        $temp   = str_replace('ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER','', $temp);
                                                        $this->runQuery($temp);
                                                        $temp   = "";
                                        	}
                                	}
                        	}
                	}else{
                        	throw new Exception("error opening the file: $file");
                	}	

        	} catch (Throwable $e) {
                	echo "<pre>";
			print_r($e);
			echo "</pre>";
        	} catch (Exception $e) {
			echo "<pre>";
                        print_r($e);
                        echo "</pre>";
        	}
	}


	function mergeOldAndNew() {                                                                 

        	$ts = $this->buildTableSchema();
        	$t  = $this->t;

        	for ($i = 0; $i < count($t); $i++ ) {

                	$table          = $t[$i];
                	$new            = $ts["$table"]['names'];
                	$old            = $ts["sys_$table"]['names'];

                	for($c = 0 ; $c < count($old) ; $c++){                                          
                        	$field  = $old[$c];
                        	if(!in_array($field, $new)){
                                	$sql= "ALTER TABLE sys_$table DROP COLUMN $field";
                                	$this->runQuery($sql);
                        	}
                	}
        	}

        	$ts = $this->buildTableSchema();

		for($i = 0 ; $i < count($t) ; $i++){
                	$table          = $t[$i];
                	$lfield         = 'FIRST';
                	for($c = 0 ; $c < count($new) ; $c++){                                         
                        	$new    = $ts["$table"]['names'];
                        	$newt   = $ts["$table"]['types'];
                        	$old    = $ts["sys_$table"]['names'];
                        	$oldt   = $ts["sys_$table"]['types'];
                        	$ofield = $old[$c];
                        	$nfield = $new[$c];
                        	$otype  = $oldt[$c];
                        	$ntype  = $newt[$c];
                        	if($ofield != $nfield){
                                	$sql= "ALTER TABLE sys_$table ADD COLUMN $nfield $ntype $lfield";
                                	$this->runQuery($sql);
                                	$ts     = $this->buildTableSchema();
                                	$c      = -1;                                                                                
                        	}else if($otype != $ntype){
                                	$sql= "ALTER TABLE sys_$table MODIFY COLUMN $nfield $ntype";
                                	$this->runQuery($sql);
                        	}

                        	if($ofield == ''){
                                	$lfield = '';
                        	}else{
                                	$lfield = "AFTER $ofield";
                        	}
                	}	
        	}
	}

	function run() {
			
		$this->t[]    		= 'zzzzsys_access';
        	$this->t[]    		= 'zzzzsys_access_form';
        	$this->t[]     		= 'zzzzsys_access_php';
        	$this->t[]      	= 'zzzzsys_access_report';
        	$this->t[]		= 'zzzzsys_browse';
        	$this->t[]    		= 'zzzzsys_debug';
        	$this->t[]    		= 'zzzzsys_event';
        	$this->t[]    		= 'zzzzsys_file';
        	$this->t[]    		= 'zzzzsys_form';
        	$this->t[]    		= 'zzzzsys_format';
        	$this->t[]   		= 'zzzzsys_object';
        	$this->t[]    		= 'zzzzsys_php';
        	$this->t[]    		= 'zzzzsys_report';
        	$this->t[]    		= 'zzzzsys_select';
        	$this->t[]    		= 'zzzzsys_select_clause';
        	$this->t[]    		= 'zzzzsys_session';
        	$this->t[]   		= 'zzzzsys_setup';
        	$this->t[]  		= 'zzzzsys_tab';
        	$this->t[]     		= 'zzzzsys_table';
        	$this->t[]  		= 'zzzzsys_timezone';
        	$this->t[]    		= 'zzzzsys_translate';
        	$this->t[] 		= 'zzzzsys_user';

		$tt			= '___nuextras'.uniqid('1').'___';
		
		$this->dir 		= __DIR__ . DIRECTORY_SEPARATOR . "nutmp$tt";
		$this->zip_dest 	= __DIR__ . DIRECTORY_SEPARATOR . "nutmp$tt" . DIRECTORY_SEPARATOR;
		$this->path 		= __DIR__ . DIRECTORY_SEPARATOR . "nutmp$tt" . DIRECTORY_SEPARATOR . 'nubuilder.zip';
		$this->nuconfig 	= __DIR__ . DIRECTORY_SEPARATOR . "nutmp$tt" . DIRECTORY_SEPARATOR . 'nuBuilder4-master' . DIRECTORY_SEPARATOR . 'nuconfig.php'; 
		$this->source		= __DIR__ . DIRECTORY_SEPARATOR . "nutmp$tt" . DIRECTORY_SEPARATOR . 'nuBuilder4-master';
		$this->dest 		= dirname( dirname(__FILE__) );
		$this->sql		= dirname( dirname(__FILE__) ) .  DIRECTORY_SEPARATOR . 'nubuilder4.sql';
		
		if ( true === $this->makeTempFolder() ) {

			if ( true === $this->downloadZip() ) {

				if ( true === $this->extractZip() ) {
					
					if ( true === $this->copyFiles() ) {

						$this->updateNubuilder();
					}
				}
			}

		}
	}

	function updateNubuilder() {

		echo "begin updating nuBuilder database <br>";
		$this->prepareDatabase();
		$this->importSystem();
        	$this->mergeOldAndNew();
             	$this->removeSomeStuff();
             	$this->appendToSystemTables();
		echo "end updating nuBuilder database <br>";

	}

	function copyFiles() {

		echo "begin attempting to copy files <br>";

		unlink($this->nuconfig);

		$source = $this->source;
        	$dest   = $this->dest;

        	foreach ( $iterator = new RecursiveIteratorIterator( new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST) as $item) {

                        if ( $item->isDir() ) {

                                @mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
                        } else {

                                copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
                        }
        	}

		echo "end attempting to copy files <br>";
		
		return true;
	}

	function extractZip() {
	
		echo "begin attempting unzip <br>";

		$zip = new ZipArchive;
		$rs  = $zip->open($this->path);

		if ( $rs === true ) {

			$zip->extractTo($this->zip_dest);
			$zip->close();

			$result = true;
                        echo "download appears successfull <br>";
			
		} else {

			echo "failed unzipping <br>";
                	$result = false;
		}

		echo "end attempting unzip <br>";

                return $result;
	}

	function makeTempFolder() {
				
		echo "begin temporary folder check <br>";
		echo $this->dir;
                echo "<br>";

		if ( is_dir($this->dir) ) {

			echo "folder already exists <br>";
			$result = true;

		} else {

			if ( !mkdir($this->dir, 0700) ) {

				echo "failed making folder <br>";
				$result = false;

			} else {

				echo "folder created <br>";
				$result = true;
			}
		}

		echo "end temporary folder check <br>";

		return $result;

	}

	function downloadZip() {

		echo "begin attemping download <br>";
		
		$fp = fopen($this->path, 'w+');
		$ch = curl_init($this->github_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$result = curl_exec($ch);
		fclose($fp);

		if ( $result === false ) {
			echo "failed download <br>";
		} else { 
			$result = true;
			echo "download appears successfull <br>";
		}
		
		echo "ending download attempt <br>";
		return $result;
		
	}

	function removeSomeStuff() {

    		$s  =  "DELETE FROM sys_zzzzsys_event WHERE zzzzsys_event_id LIKE 'nu%'";
    		$this->runQuery($s);

    		$s  =  "DELETE FROM sys_zzzzsys_file WHERE zzzzsys_file_id LIKE 'nu%'";
		$this->runQuery($s);
    		
		$s  =  "DELETE FROM sys_zzzzsys_format WHERE zzzzsys_format_id LIKE 'nu%'";
		$this->runQuery($s);

    		$s  =  "DELETE FROM sys_zzzzsys_object WHERE sob_all_zzzzsys_form_id LIKE 'nu%'  AND sob_all_zzzzsys_form_id != 'nuuserhome'";
		$this->runQuery($s);

    		$s  =  "DELETE FROM sys_zzzzsys_tab WHERE syt_zzzzsys_form_id LIKE 'nu%' AND syt_zzzzsys_form_id != 'nuuserhome'";
		$this->runQuery($s);

    		$s  =  "DELETE FROM sys_zzzzsys_form WHERE zzzzsys_form_id LIKE 'nu%' ";
		$this->runQuery($s);

    		$s  =  "DELETE FROM sys_zzzzsys_php WHERE (sph_zzzzsys_form_id LIKE 'nu%' OR zzzzsys_php_id LIKE 'nu%') AND zzzzsys_php_id != 'nuuserhome_BE'";
		$this->runQuery($s);

    		$s  =  "DELETE FROM sys_zzzzsys_browse WHERE sbr_zzzzsys_form_id LIKE 'nu%'";
		$this->runQuery($s);

    		$s  =  "DELETE FROM sys_zzzzsys_translate WHERE zzzzsys_translate_id LIKE 'nu%'";
		$this->runQuery($s);

    		$s  =  "DELETE FROM sys_zzzzsys_timezone";
		$this->runQuery($s);

	 	$s  =  "DELETE FROM zzzzsys_file WHERE zzzzsys_file_id NOT LIKE 'nu%'";
		$this->runQuery($s);
    
		$s  =  "DELETE FROM zzzzsys_format WHERE zzzzsys_format_id NOT LIKE 'nu%'";
		$this->runQuery($s);
    
		$s  =  "DELETE FROM zzzzsys_php WHERE sph_zzzzsys_form_id NOT LIKE 'nu%' AND zzzzsys_php_id NOT LIKE 'nu%' ";
		$this->runQuery($s);

    		$s  =  "DELETE FROM zzzzsys_setup";
		$this->runQuery($s);

    		$s  =  "DELETE FROM zzzzsys_tab WHERE  syt_zzzzsys_form_id NOT LIKE 'nu%' OR syt_zzzzsys_form_id = 'nuuserhome'";
		$this->runQuery($s);
	}

	function appendToSystemTables() {

        	try{

                	$t              = $this->t;

                	for($i = 0 ; $i < count($t) ; $i++){

                        	$table  	= $t[$i];

                        	$s              = "INSERT INTO $table SELECT * FROM sys_$table";
				$this->runQuery($s);

                        	$s              = "DROP TABLE sys_$table";
				$this->runQuery($s);

                	}		

                	$s              = "DROP TABLE sys_zzzzsys_report_data";
			$this->runQuery($s);

                	$s              = "DROP TABLE sys_zzzzsys_run_list";
			$this->runQuery($s);

                	$s              = "UPDATE zzzzsys_setup SET set_denied = '1'";
			$this->runQuery($s);

		} catch (Throwable $e) {
                        echo "<pre>";
                        print_r($e);
                        echo "</pre>";
                } catch (Exception $e) {
                        echo "<pre>";
                        print_r($e);
                        echo "</pre>";
                }
	}

	function db_field_names($n){

		$a       = array();
    		$s       = "DESCRIBE $n";
    		$t       = $this->runQuery($s);

    		while( $r = $t->fetch(PDO::FETCH_NUM) ){
        		$a[] = $r[0];
    		}

    		return $a;
	}

	function db_field_types($n){

    		$a       = array();
    		$s       = "dESCRIBE $n";
		$t       = $this->runQuery($s);

		while( $r = $t->fetch(PDO::FETCH_NUM) ){
        		$a[] = $r[1];
    		}		

   		return $a;
	}

	function db_primary_key($n){

 		$a       = array();
		$s       = "DESCRIBE $n";
		$t       = $this->runQuery($s);

		while( $r = $t->fetch(PDO::FETCH_NUM) ){

                	if($r[3] == 'PRI'){
                        	$a[] = $r[0];
                	}

    		}		

    		return $a;
	}

}
?>
