<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Esse é o primeiro arquivo a ser carregado no sistema um controlador "ONDE HAVERA PROCESSAMENTO"
// Na função "index()" ele chama outra funcção "inicio()" esta ultima carrega "escrituras_controle" e executa a função "login()" que esta lá dentro

class Inicio_controle extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->inicio();
	}
	
	public function inicio(){
		if (esta_logado(FALSE)):
			redirect('escrituras_controle/empreendimento');//
		else:
			redirect('escrituras_controle/login');
		endif;
	}

}

/* End of file inicio_controle.php */
/* Location: ./application/controllers/inicio_controle.php */