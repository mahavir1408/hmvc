<?php    
        switch(ENV_NAME)
        {
                case 'local':
                        define('HOST', 'localhost');
                        define('USER', 'root');
                        define('PASS', '');
                        define('DB'  , 'addedbits');
                        define('DEBUG',TRUE);
                break;                
        }
?>