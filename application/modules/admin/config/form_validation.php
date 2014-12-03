<?php
$config = array(    
    'adminlogin'=>array(
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|valid_email|callback_adminLogin'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            )
        )    
);