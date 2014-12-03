<?php
    // NOTE: all cache times are in minutes.
    $host = $_SERVER['HTTP_HOST'];	
    switch($host)
    {
        case 'local.hmvc.com':
            define('ENV_NAME','local');
            define('ERROR_LEVEL',E_ALL);
            define('SITENAME','hmvc.in');
            define('SITEURL','http://local.hmvc.com/');
            define('BASEURL','http://local.hmvc.com/');	
            define('HTDOCS_PATH','D:/projects/hmvc');	
            define('INCLUDE_PATH',HTDOCS_PATH.';D:\\projects\\hmvc\\system;D:\\projects\\hmvc\\includes;');
            define('SYSTEM_FOLDER', 'D:\\projects\\hmvc\\system');
            define('APPLICATION_PATH','D:\\projects\\hmvc\\application');			            
            //define('MAILPATH','C:\\wamp\\sendmail\\sendmail');            				
            define('PROFILER',FALSE);
            break;	               
    }	 
    ini_set('include_path',INCLUDE_PATH);
    include("db_settings.php");
?>