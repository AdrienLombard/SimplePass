<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
	private $CI;
	private $var = array();
	
	/** le theme choisi actuellement pour le site */
	private $current_theme = "default";
	
	public function __construct()
	{
		$this->CI = get_instance();
		
		$this->var['output'] = '';
		
		$this->var['titre'] = ucfirst($this->CI->router->fetch_method()) . ' - ' . ucfirst($this->CI->router->fetch_class());
		
		$this->var['charset'] = $this->CI->config->item('charset');
		
		$this->var['css'] = array();
		
		$this->var['js'] = array();
		
		$this->var['flash_msg'] = Array();
		
		$this->var['redirect'] = Array();
		
		define('MSG_OK', 0);	// vert
		define('MSG_ERR', 1);	// rouge
		define('MSG_INFO', 2);	// jaune
	}
	
	
	public function view($name, $data = array())
	{
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		
		$this->CI->load->view('../themes/'.$this->current_theme, $this->var);
	}
	
	
	public function views($name, $data = array())
	{
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		return $this;
	}
	
	
	public function set_titre($titre)
	{
		if(is_string($titre) AND !empty($titre))
		{
			$this->var['titre'] = $titre;
			return true;
		}
		return false;
	}
	

	public function set_charset($charset)
	{
		if(is_string($charset) AND !empty($charset))
		{
			$this->var['charset'] = $charset;
			return true;
		}
		return false;
	}
	
	public function ajouter_css($nom)
	{
		if(is_string($nom) AND !empty($nom) AND file_exists('./assets/css/' . $nom . '.css'))
		{
			$this->var['css'][] = css_url($nom);
			return true;
		}
		return false;
	}
	
	public function ajouter_js($nom)
	{
		if(is_string($nom) AND !empty($nom) AND file_exists('./assets/js/' . $nom . '.js'))
		{
			$this->var['js'][] = js_url($nom);
			return true;
		}
		return false;
	}
	
	
	/**
	 * fonction pour demander l'affichage d'une flash_message sur la vue appeler ensuite.
	 * @param char $message
	 * @param int  $flag
	 */
	function flash_message ($message, $flag=2)
	{
		$rep = '<div id="flash_message" ';
		switch ($flag)
		{
			case MSG_OK :
				$rep = $rep.'class="Ok_Message" >';
			break;
			
			case MSG_ERR :
				$rep = $rep.'class="Error_Message" >';
			break;
			
			case MSG_INFO :
				$rep = $rep.'class="Info_Message" >';
			break;
			
			default :	
				$rep = $rep.'class="Info_Message" >';
			break;
		}
		$rep = $rep.$message;
		$rep = $rep.'</div>';
		
		$this->var['flash_msg'][] = $rep;
	}
	
	
	/**
	 * ajouter une redirection automatique sur la vue appeler ensuite
	 * @param int $url	 url de redirection
	 * @param int $tempo temps en seconde avant la redirection automatique
	 */
	function add_redirect ($url, $tempo=1)
	{
		$this->var['redirect']['url'] = $url;
		$this->var['redirect']['tempo'] = $tempo;
	}
	
	
	
	
	
	
	
	
	
	
}