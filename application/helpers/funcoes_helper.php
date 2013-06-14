<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Esse aquivo é um aquivo que guarda dos as funções do sistema que vamos usar.

//carrega um modulo do sistema devolvendo a tela solicitada
function load_modulo($modulo=NULL, $tela=NULL, $diretorio='telas'){
	$CI =& get_instance();
	if ($modulo!=NULL):
		return $CI->load->view("$diretorio/$modulo", array('tela'=>$tela), TRUE);
	else:
		return FALSE;
	endif;
}

//seta valores ao array $tema da classe /libraries/sistema
function set_tema($prop, $valor, $replace=TRUE){
	$CI =& get_instance();
	$CI->load->library('sistema');
	if ($replace):
		$CI->sistema->tema[$prop] = $valor;
	else:
		if (!isset($CI->sistema->tema[$prop])) $CI->sitema->tema[$prop] = '';
		$CI->sistema->tema[$prop] .= $valor;
	endif;
}

//retorna os valores do array $tema da classe sistema
function get_tema(){
	$CI =& get_instance();
	$CI->load->library('sistema');
	return $CI->sistema->tema;
}

//Inicializar o SISTEMA carregando os recursos necessários
function init_painel(){
	$CI =& get_instance();
	$CI->load->library(array('sistema', 'session', 'form_validation'));
	$CI->load->helper(array('form', 'array', 'text'));
	//carregamento dos models para inderação com DB
	$CI->load->model('geral_model', 'geral_m');
		
	set_tema('tituloaba', 'SIS_ESCRITURAS | ');
	set_tema('logo', '<h4 class="subheader text-center">STARBUSINESS</h4><h5 class="subheader text-center">Négocios Imobiliarios</h5><h6 class="subheader text-center">Fone/Fax: ????-????</h6>');
	set_tema('rodape', '<h5><small>2013&copy; | Todos os direitos reservados para <a href="#">STARBUSINESS</a></small></h5>');
	set_tema('template', 'inicio_view');
	
	set_tema('headerinc', load_css(array('foundation.min', 'app')));
	set_tema('footerinc', load_js(array('foundation.min', 'app')));
	//set_tema('footerinc', '');
}

//carrega um template passando o array $tema como parametro
function load_template(){
	$CI =& get_instance();
	$CI->load->library('sistema');
	$CI->parser->parse($CI->sistema->tema['template'], get_tema());
}

//carrega um ou varios arquivos .css de uma pasta
function load_css($arquivo=NULL, $pasta='css', $media='all'){
	if ($arquivo != NULL):
		$CI =& get_instance();
		$CI->load->helper('url');
		$retorno = '';
		if (is_array($arquivo)):
			foreach ($arquivo as $css):
				$retorno .= '<link rel="stylesheet" type="text/css" href="'.base_url("$pasta/$css.css").'" media="'.$media.'" />';				
			endforeach;
		else:
			$retorno = '<link rel="stylesheet" type="text/css" href="'.base_url("$pasta/$arquivo.css").'" media="'.$media.'" />';
			
		endif;
	endif;
	return $retorno;
}


//carrega um ou varios aquivos .js de uma pasta ou servidor remoto
function load_js($arquivo=NULL, $pasta='js', $remoto=FALSE){
	if ($arquivo != NULL):
		$CI =& get_instance();
		$CI->load->helper('url');
		$retorno = '';
		if (is_array($arquivo)):
			foreach ($arquivo as $js):
				if ($remoto):
					$retorno .= '<script type="text/javascript" src="'.$js.'"></script>';
				else:
					$retorno .= '<script type="text/javascript" src="'.base_url("$pasta/$js.js") .'"></script>';
				endif;
			endforeach;
		else:
			if ($remoto):
				$retorno .= '<script type="text/javascript" src="'.$arquivo.'"></script>';
			else:
				$retorno .= '<script type="text/javascript" src="'.base_url("$pasta/$arquivo.js") .'"></script>';
			endif;
		endif;
	endif;
	return $retorno;
}

//mostra erro de validação em FORMS
function erros_validacao(){
	if(validation_errors()) echo '<div class="alert-box alert">'.validation_errors('<p>', '</p>').'</div>';  //-> Isso apresenta o erro onde a função for chamada no FORM 
}

// verifica se o usuário esta logado no sistema
function esta_logado($redir=TRUE){
	$CI =& get_instance();
	$CI->load->library('session');
	$user_status = $CI->session->userdata('user_logado');
	if (!isset($user_status) || $user_status != TRUE):
		if ($redir):
			$CI->session->set_userdata(array('redir_para'=>current_url()));
			set_msg('errologin', 'Acesso restrito, faça login antes de prosseguir', 'erro');
			redirect('escrituras_controle/login');
		else:
			return FALSE;
		endif;
	else:
		return TRUE;
	endif;
}

//define uma mensagem para ser exibida na próxima tela carregada
function set_msg($id='msgerro', $msg=NULL, $tipo='erro'){
	$CI =& get_instance();
	switch ($tipo):
		case 'erro':
			$CI->session->set_flashdata($id, '<div class="alert-box alert"><p>'.$msg.'</p></div>');
			break;
		case 'sucesso':
		 	$CI->session->set_flashdata($id, '<div class="alert-box success"><p>'.$msg.'</p></div>');
			break;
		default:
			$CI->session->set_flashdata($id, '<div class="alert-box"><p>'.$msg.'</p></div>');
			break;
	endswitch;
}

//verifica se existe uma mensagem para ser exibida na tela atual
function get_msg($id, $printar=TRUE){
	$CI =& get_instance();
	if ($CI->session->flashdata($id)):
		if ($printar):
			echo $CI->session->flashdata($id);
			return TRUE;
		else:
			return $CI->session->flashdata($id);
		endif;
	endif;
	return FALSE;
}

