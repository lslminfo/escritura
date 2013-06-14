<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Esse tambem é um controlador que vai carragar algumas propriedades e carrega o arquivo de "funcoes_helper"

class LM_Sistema{
	
	protected $CI;
	public $tema = array();
	
	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->helper('funcoes_helper');	
	}

	public function enviar_email($para, $assunto, $mensagem, $formato='html'){
		$this->CI->load->library('email');
		$config['mailtype'] = $formato;
		$this->CI->email->initialize($config);
		$this->CI->email->from('leandro@maxxinet.net.br', 'Administração do site');
		$this->CI->email->to($para);
		$this->CI->email->subject($assunto);
		$this->CI->email->message($mensagem);
		if ($this->CI->email->send()):
			return TRUE;
		else:
			return $this->CI->email->print_debugger();
		endif;
		
	}

}

/* End of file sistema.php */
/* Location: ./application/libraries/sistema.php */