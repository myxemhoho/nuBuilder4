<?php
        $i = 1;

        $cfg['Servers'][$i]['SignonSession']    = 'PHPSESSIDNUBUILDERFORTE4';
        $cfg['Servers'][$i]['auth_type']        = 'signon';
        $cfg['Servers'][$i]['SignonURL']        = '../index.php';

        $cfg['Servers'][$i]['host']             = $_COOKIE["DBHost"];
        $cfg['Servers'][$i]['only_db']          = $_COOKIE["DBName"];

        $cfg['Servers'][$i]['connect_type']     = 'tcp';
        $cfg['Servers'][$i]['compress']         = false;
        $cfg['Servers'][$i]['extension']        = 'mysqli';
        $cfg['Servers'][$i]['AllowNoPassword']  = false;
        $cfg['LeftDisplayLogo']                 = false;

        $cfg['UploadDir'] = '';
        $cfg['SaveDir'] = '';

if ( $_COOKIE["DBHost"] == '' ) {
        die('please log into nuBuilder to use this page');
}

?>
