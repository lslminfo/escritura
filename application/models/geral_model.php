<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
//Esse é o arquivo de interação com o banco de dados, é aqui que vamos fazer todas as "Consulta/Inserção/Atualização/Deleção"
//Esse arquivo "MODEL" e chamdo no "ESCRITURAS_CONTROLE"

class Geral_model extends CI_Model {
	
	public function do_login($login=NULL, $senha=NULL){
		if ($login && $senha):
			$this->db->where('login', $login);
			$this->db->where('senha', $senha);
			$this->db->where('ativo', 1);
			$query = $this->db->get('tbusuario');
			if ($query->num_rows == 1):
				return TRUE;
			else:
				return FALSE;
			endif;
		else:
			return FALSE;
		endif;
	}
	
	public function get_bylogin($login=NULL){
		if ($login != NULL):
			$this->db->where('login', $login);
			$this->db->limit(1);
			return $this->db->get('tbusuario');
		else:
			return FALSE;
		endif;
	}

	public function get_byemail($email=NULL){
		if ($email != NULL):
			$this->db->where('email', $email);
			$this->db->limit(1);
			return $this->db->get('tbusuario');
		else:
			return FALSE;
		endif;
	}

	public function get_senha($senha=NULL){
		if ($senha != NULL):
			$this->db->where('id', $this->session->userdata('user_id'));
			$this->db->where('senha', $senha);
			$this->db->limit(1);
			$query = $this->db->get('tbusuario');
			if ($query->num_rows == 1):
				return $this->db->get('tbusuario');
			endif;
		else:
			return FALSE;
		endif;
	}
	
	public function get_empreend(){ // Pega todos os EMPREENDIMENTOS CADASTRADOS NO DB
		$this->db->where('ativo', 1);
		$empreendimento = $this->db->get('tbempreendimento')->result();
		$emp = array('Lista de empreendimento'=>'Lista de empreendimento');
		foreach ($empreendimento as $linha):
			$emp[$linha->fantasia] = $linha->fantasia;
		endforeach;
		return $emp;
	}
	
	public function get_byempreend($empreendimento){ // Pega o EMPREENDIMENTO selecionado no LOGIN
		$this->db->where('fantasia', $empreendimento);
		$this->db->limit(1);
		return $this->db->get('tbempreendimento');
	}

	public function do_update($dados=NULL, $condicao=NULL, $redir=TRUE){
		if ($dados != NULL && is_array($condicao)):
			$this->db->update('tbusuario', $dados, $condicao);
			if ($this->db->affected_rows()>0):
				//auditoria('Alterção de usuários');
				set_msg('msgok', 'Alteração efetuada com sucesso', 'sucesso');
			else:
				set_msg('msgerro', 'Erro ao alterar informações do usuário', 'erro');
			endif;
			if ($redir) redirect(current_url());
		endif;
	}

	public function get_corretor($idemp){
		$lms = $this->db->query('SELECT c_nome FROM tbempreendimento_has_tbcorretor JOIN tbcorretor ON tbcorretor.id = tbcorretor_id AND tbempreendimento_id ='.$idemp)->result();
		$corr = array('id'=>'Selecione um corretor');
		foreach ($lms as $linha):
			$corr[$linha->c_nome] = $linha->c_nome;
		endforeach;
		return $corr;
	}
	
	public function getLote($quadra=NULL, $lote=NULL, $emp){
		return $this->db->query('SELECT * FROM `tbquadralote` WHERE `tbempreendimento_id`='.$emp.' AND `quadra` LIKE "'.$quadra.'" AND lote = '.$lote.' AND `tbsituacaolote_id`=3');
	}
	
	
	
}
/* End of file geral_model.php */
/* Location: ./application/models/geral_model.php */
