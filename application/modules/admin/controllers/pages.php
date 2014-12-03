<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {    
    
	public $data = array();
	
    public function __construct()
    {       
        parent::__construct(); 		
        $this->load->model('pages_model');		
        if(!$this->session->userdata('logged_in')){
            header('Location:/admin');
            exit;
        }        
        $this->config->set_item('menu', 'pages');	
		$this->data['userData'] = $this->session->all_userdata();
		$this->data['totalSegment'] = $this->uri->total_segments();		
		$this->data['segmentArray'] = $this->uri->segment_array();
		$this->data['directories'] =  array_filter(array_slice($this->data['segmentArray'],2),'stripNumericElements'); 
		$this->data['directories'] = !empty($this->data['directories'])?$this->data['directories']:array();
		$this->data['uri'] = implode('/',$this->data['directories']);
    }
    
    public function index()
    {        
		$lastSegment = end($this->data['segmentArray']);
		$this->load->library("pagination2");	
		$config = $this->config->load('pagination');
		$config = $this->config->config['pagination'];
		$rows_per_page = $config['per_page'];		
		$directoryIds = $this -> pages_model -> getDirectoryId($this->data['directories']);
		//echo "<pre>";print_r($directoryIds);echo "</pre>";exit;
		$this->data['parentid'] = !empty($directoryIds)?key($directoryIds):"0";
		$totalPages = $this -> pages_model -> getTotalPages($this->data['parentid']);
		$pageNumber =  is_numeric($lastSegment)?$lastSegment:"1";
		$pageNumber = $rows_per_page*($pageNumber-1);
		$config['total_rows'] = $totalPages['total_rows'];				
		$this->data['pages'] = $this -> pages_model -> getPages($this->data['parentid'],$pageNumber,$rows_per_page);		
		$config['first_url'] = BASEURL.'/admin/pages/'.$this->data['uri'];
		$config['uri_segment'] = $this->data['totalSegment'];
		$config['base_url'] = BASEURL.'/admin/pages/'.$this->data['uri'];		
		$this->pagination2->initialize($config);
		$this->data['pagination'] = $this->pagination2->create_links();	
		
        $structure = array(				
            'title' => "HTML5 - Hands on UI",
            'keywords' =>"HTML5 - Hands on UI",
            'description' => "HTML5 - Hands on UI",
            'js' => 'backend/js/all.js',
            'css' => array('backend/css/all.css'),
			'misc_head' => '<!--[if gte IE 9]><link rel="stylesheet" href="/assets/backend/css/ie9.css" type="text/css" /><![endif]-->
			<!--[if gte IE 8]><link rel="stylesheet" href="/assets/backend/css/ie8.css" type="text/css" /><![endif]-->',
			//'meta' => array('<meta charset="utf-8" />','<meta name="author" content="" />','<meta name="viewport" content="width=device-width, initial-scale=1.0">')
			/*
			'meta' => array('author'=>'Mahavir Munot', 
							'viewport' => 'width=device-width, initial-scale=1.0',
							'copyright' => 'All content and images copyright &copy; 2013, addedbits'
							)
			*/
			'meta' => array('author'=>'Mahavir Munot', 
							'viewport' => 'width=device-width, initial-scale=1.0'							
							)
        );
		$this->config->set_item('structureFile', 'structure');
        //'header','left','content','footer'
         $views=array(
             'header' => 'layout/header',
			 'left' => 'layout/left_nav',
			 'content' => 'pages/content',
			 'footer' => 'layout/footer',
             );
        $this->hq_layout->set_structure($structure);
        $this->hq_layout->set_layout($views,'2col');
        $this->hq_layout->set_data($this->data);
        $this->hq_layout->render();
    }
	
	public function add()
    {   	
		$parent_id = $this->data['segmentArray'][$this->data['totalSegment']-1];
	
		$this->data['is_dir'] = false;		
		if(in_array('add-directory',$this->data['segmentArray'])) {
			$this->data['is_dir'] = true;
		}else{
			$this->data['is_dir'] = false;
		}
		if(isset($_POST) && !empty($_POST)){
			if($this->data['is_dir']) {
				if (($key = array_search('add-directory', $this->data['directories'])) !== false) {
					unset($this->data['directories'][$key]);
					$this->data['uri'] = implode('/',$this->data['directories']);
				}
				//echo "<pre>";print_r($this->data['uri']);echo "</pre>";exit;
				$directory_slug = (isset($this->data['uri']) && !empty($this->data['uri']))?"/".$this->data['uri']."/".$this->input->post('slug'):"/".$this->input->post('slug');
				$formdata = array(
					'display_name' => $this->input->post('dir_name'), 					
					'slug' => $this->input->post('slug'),   
					'uri' => $directory_slug,
					'parent_id' => $parent_id,
					'created_at' => date(AB_DATE_FORMAT),
					'is_published' => 1
					);				
				$directoryId=$this->pages_model->createDirectory($formdata);
				
				$pagedata = array(
					'uri' => $directory_slug,
					'head' => $this->input->post('h1_tag'),
					'directory_id' => $directoryId,
					'parent_directory_id' => $parent_id,
					'page_type' => 'directory',
					'created_at' => date(AB_DATE_FORMAT),
					'userid' => $this->session->userdata('id')
				);
				$pageID = $this->pages_model->createPage($pagedata);
				//echo $pageID;exit;
				if($pageID){
					$_SESSION['smessage']="Directory created successfully.";					
				}
			} else {
				if (($key = array_search('add-page', $this->data['directories'])) !== false) {
					unset($this->data['directories'][$key]);
					$this->data['uri'] = implode('/',$this->data['directories']);
				}				
				$directory_slug = (isset($this->data['uri']) && !empty($this->data['uri']))?"/".$this->data['uri']."/".$this->input->post('slug'):$this->input->post('slug');
				$pagedata = array(
					'page_name' => $this->input->post('slug'),
					'uri' => $directory_slug,
					'head' => $this->input->post('h1_tag'),
					'directory_id' => $parent_id,
					'parent_directory_id' => $parent_id,
					'page_type' => 'page',
					'created_at' => date(AB_DATE_FORMAT),
					'userid' => $this->session->userdata('id')
				);
				$pageID = $this->pages_model->createPage($pagedata);
			}			
		}
		
		$structure = array(				
            'title' => "HTML5 - Hands on UI",
            'keywords' =>"HTML5 - Hands on UI",
            'description' => "HTML5 - Hands on UI",
            'js' => 'backend/js/all.js,backend/js/jHtmlArea-0.7.5.js',
            'css' => array('backend/css/all.css','backend/css/jHtmlArea.css'),
			'misc_head' => '<!--[if gte IE 9]><link rel="stylesheet" href="/assets/backend/css/ie9.css" type="text/css" /><![endif]-->
			<!--[if gte IE 8]><link rel="stylesheet" href="/assets/backend/css/ie8.css" type="text/css" /><![endif]-->',
			//'meta' => array('<meta charset="utf-8" />','<meta name="author" content="" />','<meta name="viewport" content="width=device-width, initial-scale=1.0">')
			/*
			'meta' => array('author'=>'Mahavir Munot', 
							'viewport' => 'width=device-width, initial-scale=1.0',
							'copyright' => 'All content and images copyright &copy; 2013, addedbits'
							)
			*/
			'meta' => array('author'=>'Mahavir Munot', 
							'viewport' => 'width=device-width, initial-scale=1.0'							
							)
        );
		$this->config->set_item('structureFile', 'structure');
        //'header','left','content','footer'
         $views=array(
             'header' => 'layout/header',
			 'left' => 'layout/left_nav',
			 'content' => 'pages/add',
			 'footer' => 'layout/footer',
             );
        $this->hq_layout->set_structure($structure);
        $this->hq_layout->set_layout($views,'2col');
        $this->hq_layout->set_data($this->data);
        $this->hq_layout->render();
    }
	
	
}    