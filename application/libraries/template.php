<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/* CodeIgniter Template Engine
 *  @author whizkraft
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Template {
    private $ci;
    private $controller, $method;
    private $data;
    private $meta, $css, $js, $sidebar;
    private $header, $footer;

    /* Constructor
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function __construct() {
        $this->ci = & get_instance();

        /* Start initialization */
        $this->init();
    }

    /* Initialization
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    private function init() {
      
        /* Initialize config */
        $this->loadConfig();
		$this->setConfig();
        /* Identify called controller and method */
        $this->identifyController();
        $this->identifyMethod();
		
		/* Initialize main data array */
        $this->initData();
    }

	private function identifyController() {
        $this->controller = $this->ci->router->class;

        // Mike's check if this is the admin part
        //$this->admin = $this->ci->rt_config->admin;
    }
	
	/* Identify called method
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    private function identifyMethod() {
        $this->method = $this->ci->router->method;
    }
	
	/* Get current controller
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function getController() {
        return $this->controller;
    }

    /* Get current method
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function getMethod() {
        return $this->method;
    }
	
		
	/* Initialize data array
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    private function initData() {
        
		
		$this->data = array(
            'base_url'      => $this->identifyBaseUrl(),
            //'charset'       => $this->config['charset'],
            'meta'          => array(),
			'css'           => array(),
            'js'            => array(),
            'title'         => $this->config['template']['title']
            
        );		
		 $seg = $this->ci->uri->segment(1);
		 if($seg == "admin")
		{
		$this->header   = $this->config['template']['admin_header'];
        $this->footer   = $this->config['template']['admin_footer'];
		}
		else { 	
		$this->header   = $this->config['template']['header'];
        $this->footer   = $this->config['template']['footer'];
		}
    }
	
	/* Identify base url
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    private function identifyBaseUrl() {
        $baseUrl = trim($this->ci->config->item('base_url'));

        if(substr($baseUrl, -1) == '/') {
            $baseUrl = substr($baseUrl, 0, -1);
        }

        return $baseUrl;
    }

    
	 /* Load configuration file and set main configuration variables
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    private function loadConfig() {
        /* Load config files */
        $this->ci->config->load('template');
        
        /* Init config variables */
        $result = array(
            'template'  => $this->ci->config->item('template')
         );
		

        return $result;
    }
	
	 //set config
	 private function setConfig() {
		$this->config = $this->loadConfig();
	}
	
	
	
	
	/* Generate page
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function page($content_area = NULL,$data = array(), $header = NULL, $footer = FALSE) {
                
		/* Include data */
        $this->data[] = $data;
		
		//
		if($header)
			$this->ci->load->view($header, $this->data, false);
		else
			$this->ci->load->view($this->header, $this->data, false);
			
		/* Parse main page template - final step */
		$this->ci->load->view($content_area, $data, false);
		
		if($footer)
			$this->ci->load->view($footer, $this->data, false);
		else
			$this->ci->load->view($this->footer, $this->data, false);
		
    }
	public function title($title)
	{
		$this->data['title'] .=" | ".$title;
	}	
	/* Generate view
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
   /*  public function view($template, $data = array(), $return = FALSE) {
        $this->data['body'] = $this->ci->load->view($template, $data, TRUE);
        $this->data['body_class'] = 'bg-none';

        //$pageTemplate = $this->folder['system'].'/'.$this->file['main'];
        return $this->ci->load->view($view, $this->data, $return);
    }  */
	
}

?>