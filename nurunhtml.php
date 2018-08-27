<?php 
require_once('nucommon.php'); 
require_once('nudata.php'); 

print "<meta charset='utf-8'>";

$table_id						= nuTT();
$s								= "SELECT deb_message AS json FROM zzzzsys_debug WHERE zzzzsys_debug_id = ? ";		//-- created by nuRunHTML()
$t								= nuRunQuery($s, array($_GET['i']));
$r								= db_fetch_object($t);
$j								= json_decode($r->json);
$_POST['nuHash'] 				=  (array) $j->hash;
$c								= $j->columns;
$form_id						= $j->form_id;
$sql							= nuReplaceHashVariables($j->sql);

nuEval($form_id . '_BB');

print "<style>\n";

for($col = 0 ; $col < count($c) ; $col++){
	
	
	$wd		= ($c[$col]->width) . 'px';
	
	if($c[$col]->align == 'l'){$align = 'left';}
	if($c[$col]->align == 'r'){$align = 'right';}
	if($c[$col]->align == 'c'){$align = 'center';}
	
	$class[$col]	= "style='width:$wd;text-align:$align'";
		
}

print "</style>\n";

print "<TABLE border=1>\n";
print "\n<TR>";

for($col = 0 ; $col < count($c) ; $col++){
	
	$st	= $class[$col];
	print "<TH $st>";
	print $c[$col]->title;
	print "</TH>\n";
	
}

$h	= "</TR>";

$t				= nuRunQuery($sql);

while($r = db_fetch_array($t)){
		
	$h	.= "\n<TR>\n";

	for($col = 0 ; $col < count($c) ; $col++){
		
		$st	= $class[$col];
		$h	.= "<TD $st>" . $r[$c[$col]->display] . "</TD>\n";
			
	}

	$h	.= "</TR>";

}


$h	.= "</TABLE>";

print $h;

//nuRunQuery("DELETE FROM zzzzsys_debug WHERE zzzzsys_debug_id = ? ", array($jsonID));

?>

