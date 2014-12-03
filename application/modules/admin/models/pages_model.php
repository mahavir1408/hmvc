<?php
class pages_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getPageList(){
        $this->db->where('is_active','1');
		$pages=$this->db->get('ab_page')->result_array();
		if(isset($pages) && !empty($pages)){
			return $pages;
		}else{
			return false;
		}
    }
	
	public function getDirectoryId ($directories){	
		$res = array();
		$query = array();
		$sql = "";
		array_unshift($directories,'');
		unset($directories[0]);
		$dir_count = count($directories);
		$i = $dir_count+1;
		$j = 1;
		$k = 1;
			
		if($dir_count > 0 ){	
			$this->db->select("d$i.id AS id,d$dir_count.id AS parent");
			$this->db->from("ab_directory as d$j");
			while($i>0 && $j<$dir_count+1) {						
				//echo "| i:$i | j:$j | k:$k |<br/>";
				$j++;
				$this->db->join("ab_directory AS d$j", "d$j.parent_id = d$k.id", "left");	
				$this->db->where("d$k.slug", $directories[$k]);
				$i--;
				$k++;				
			}			
		} else {
			$this->db->select("d$i.id AS id,d$i.parent_id AS parent");
			$this->db->from("ab_directory as d$j");
			$this->db->where("d$i.parent_id =", 0);
		}
		$query = $this->db->get()->result_array();
		foreach($query AS $key => $value){
			
			$res[$value['parent']][] = $value['id'];
		}
		//echo "<pre>";print_r($res); echo "</pre>";//
		//print_r($this->db->last_query());	//exit;
		return $res;
	}
	
	public function getPages($directoryId,$pageNumber,$recordsPerPage){
		$res = array();
		//echo "<pre>";print_r($directoryId); echo "</pre>";exit;
		$id = $directoryId;						
		$sql = "SELECT p.id AS pageid, p.meta_title AS meta_title, p.head AS head, p.page_name AS page_name,p.uri AS uri,0 AS current_id, p.directory_id AS directory_id,p.userid AS uid,p.created_at AS created_at,a.name AS uname, p.page_type AS page_type FROM `ab_page` AS p JOIN ab_admin AS a ON p.userid=a.id WHERE p.parent_directory_id=$id ORDER BY p.page_type DESC LIMIT $pageNumber,$recordsPerPage";				
		$res = $this->db->query($sql)->result_array();				
		return $res;
	}
	
	public function getTotalPages($directoryId){		
		$res = 0;
		$id = $directoryId;
		$sql = "SELECT count(p.id) AS total_rows FROM `ab_page` AS p JOIN ab_admin AS a ON p.userid=a.id WHERE p.parent_directory_id=$id";		
		$res = current($this->db->query($sql)->result_array());
		//echo $sql."<br />";echo "<pre>";print_r($res); echo "</pre>";exit;
		return $res;
	}
	
	public function createPage($formData){
		$return_result=$this->db->insert('ab_page', $formData);
		if($return_result){
    		return true;
		}else{
			return false;
		}
	}
	
	public function createDirectory($formData){
		$this->db->trans_start();
		$this->db->insert('ab_directory',$formData);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
	 
}   