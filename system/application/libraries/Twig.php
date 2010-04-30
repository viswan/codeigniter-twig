<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Twig
{
	private $CI;
	private $_twig;
	private $_template_dir;
	private $_cache_dir;

	/**
	 * Constructor
	 *
	 */
	function __construct($debug = false)
	{

	    $this->CI =& get_instance();
	    $this->CI->config->load('twig');
	    
	    ini_set('include_path',
            ini_get('include_path') . PATH_SEPARATOR . APPPATH . 'libraries/Twig');
            require_once (string) "Autoloader" . EXT;
            
            log_message('debug', "Twig Autoloader Loaded");

            Twig_Autoloader::register();

            $this->_template_dir = $this->CI->config->item('template_dir');
            $this->_cache_dir = $this->CI->config->item('cache_dir');

            $loader = new Twig_Loader_Filesystem($this->_template_dir);

            $this->_twig = new Twig_Environment($loader, array(
                'cache' => $this->_cache_dir,
                'debug' => $debug,
            ));
		
	}

	public function render($template, $data = array()) {

            $template = $this->_twig->loadTemplate($template);

            return $template->render($data);
	}

        public function display($template, $data = array()) {

            $template = $this->_twig->loadTemplate($template);

            $template->display($data);
	}
}

?>