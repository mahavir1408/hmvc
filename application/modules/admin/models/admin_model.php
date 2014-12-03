<?php
class Admin_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function login_check($email,$pass){
        $q = $this
        ->db
        ->where('email ', $email)
        ->where('passwd ', md5($pass))
        ->where('is_active ', '1')
        ->get('ab_admin');
        if ( $q->num_rows == 1 ) {
            return true;
        } else {
            return false;
        }
    }
	
	
	 public function getAdminDetails($email,$pass){		
		$this->db->select('a.id AS adminId, a.name AS adminName, a.email AS adminEmail,a.last_access AS adminLastAccess',false);
        $this->db->where('a.email ',$email);
		$this->db->where('a.passwd ',md5($pass));
		$this->db->where('is_active ', '1');
        $adminDetails = $this->db->get('ab_admin as a')->result_array();		
        if(isset($adminDetails) && !empty($adminDetails)){
            return current($adminDetails);
        }else{
            return false;
        }
	}
}   