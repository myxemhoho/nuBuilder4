<?php 

require_once('nuchoosesetup.php');
require_once('nucommon.php'); 
require_once('nudata.php');
require_once('nusystemupdatelibs.php'); 

$jsonID	= $_GET['i'];
$J	= nuGetJSONData($jsonID);

if($J  != 'valid'){
	
	print "Something's wrong. Try logging in again...";	
	return;
}

print '<br><span style="font-family:Helvetica;padding:10px;">Copied SYSTEM FILES to TEMP FILES <br></span>';
nuCopySystemFiles();

print '<br><span style="font-family:Helvetica;padding:10px;">Copied SYSTEM FILES to TEMP FILES <br></span>';
nuImportSystemFiles();

print '<br><span style="font-family:Helvetica;padding:10px;">Copied SYSTEM FILES to TEMP FILES for any new tables added from the import. <br></span>';
nuAddNewSystemTables();

print '<br><span style="font-family:Helvetica;padding:10px;">Updated TEMP FILE table structure\'s to SYSTEM FILES <br></span>';
nuUpdateSystemRecords();

print '<br><span style="font-family:Helvetica;padding:10px;">Removed all ids starting with nu from TEMP FILES <br></span>';
nuRemoveNuRecords();

print '<br><span style="font-family:Helvetica;padding:10px;">Removed all ids not starting with nu from SYSTEM FILES <br></span>';
nuJustNuRecords();

print '<br><span style="font-family:Helvetica;padding:10px;">Inserted TEMP FILES into SYSTEM FILES <br></span>';
nuAppendToSystemTables();

nuSetCollation();
print '<br><span style="font-family:Helvetica;font-style:italic;font-size:20px;font-weight:bold;padding:10px">You will need to log in again for the changes to take effect.</span><br>';

nuMigrateSQL();

function nuMigrateSQL() {

        $set    = "nuStartDatabaseAdmin();";
	$where  = 'nu5bad6cb37966261';;
        $values = array($set,$where);
        $sql    = "UPDATE `zzzzsys_event` SET `sev_javascript` = ? WHERE `zzzzsys_event_id` = ? ";
        nuRunQuery($sql, $values);

	$set    = "<iframe id='sqlframe' src='nuselect.php' style='height:180px;width:700px'></iframe>";
        $where  = 'nu5bad6cb359e7a1a';
        $values = array($set,$where);
        $sql    = "UPDATE `zzzzsys_object` SET `sob_html_code` = ? WHERE `zzzzsys_object_id` = ? ";
        nuRunQuery($sql, $values);

	$set    = 'window.open(\'nureportdesigner.php?tt=\' + $("#sre_zzzzsys_php_id").val() + \'&launch=\' + $("#sre_zzzzsys_form_id").val());';
        $where  = 'nu5bad6cb3797b0a7';
        $values = array($set,$where);
        $sql    = "UPDATE `zzzzsys_event` SET `sev_javascript` = ? WHERE `zzzzsys_event_id` = ?";
        nuRunQuery($sql, $values);

        $set  = '$s  = "CREATE TABLE #TABLE_ID# SELECT zzzzsys_object_id AS theid FROM zzzzsys_object WHERE ";';
        $set .= "\n";
        $set .= '$w  = "1";';
        $set .= "\n";
        $set .= 'if ( $GLOBALS[\'nuSetup\']->set_denied == 1 )  { ';
        $set .= "\n";
        $set .= '$w  = "sob_all_zzzzsys_form_id NOT LIKE \'nu%\' OR sob_all_zzzzsys_form_id = \'nuuserhome\'"; ';
        $set .= "\n";
        $set .= '}';
        $set .= "\n";
        $set .= 'nuRunQuery("$s$w");';
        $set .= "\n";
        $where  = 'nuobject_BB';
        $values = array($set,$where);
        $sql    = "UPDATE `zzzzsys_php` SET `sph_php` = ? WHERE `zzzzsys_php_id` = ?";
        nuRunQuery($sql, $values);

        $set  = '$s  = "CREATE TABLE #TABLE_ID# SELECT zzzzsys_form_id AS theid FROM zzzzsys_form WHERE ";';
        $set .= "\n";
        $set .= '$w  = "1";';
        $set .= "\n";
        $set .= 'if ( $GLOBALS[\'nuSetup\']->set_denied == 1 )  { ';
        $set .= "\n";
        $set .= '$w  = "zzzzsys_form_id NOT LIKE \'nu%\' OR zzzzsys_form_id = \'nuuserhome\'"; ';
        $set .= "\n";
        $set .= '}';
        $set .= "\n";
        $set .= 'nuRunQuery("$s$w");';
        $set .= "\n";
        $where  = 'nuform_BB';
        $values = array($set,$where);
        $sql    = "UPDATE `zzzzsys_php` SET `sph_php` = ? WHERE `zzzzsys_php_id` = ?";
        nuRunQuery($sql, $values);

        $set  = '$s  = "CREATE TABLE #TABLE_ID# SELECT zzzzsys_form_id AS theid FROM zzzzsys_form WHERE ";';
        $set .= "\n";
        $set .= '$w  = "1";';
        $set .= "\n";
        $set .= 'if ( $GLOBALS[\'nuSetup\']->set_denied == 1 )  { ';
        $set .= "\n";
        $set .= '$w  = "zzzzsys_form_id NOT LIKE \'nu%\' OR zzzzsys_form_id = \'nuuserhome\'"; ';
        $set .= "\n";
        $set .= '}';
        $set .= "\n";
        $set .= 'nuRunQuery("$s$w");';
        $set .= "\n";
        $where  = 'nutablookup_BB';
        $values = array($set,$where);
        $sql    = "UPDATE `zzzzsys_php` SET `sph_php` = ? WHERE `zzzzsys_php_id` = ?";
        nuRunQuery($sql, $values);
}

?>
