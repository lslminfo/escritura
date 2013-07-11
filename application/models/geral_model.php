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

	public function get_corretor1($idemp){
		$this->db->select('*');
		$this->db->from('tbempreendimento_has_tbcorretor');
		$this->db->join('tbcorretor', 'tbcorretor.id = tbcorretor_id');
		$this->db->where('tbempreendimento_id', $idemp);
		$this->db->where('tbcorretor.c_ativo', 1);
		$query = $this->db->get()->result();
		$corr1 = array(''=>'Selecione um corretor');
		foreach ($query as $linha):
			$corr1[$linha->id] = $linha->c_nome;
		endforeach;
		return $corr1;
	}
	
	public function getCorretor2($idemp=NULL, $idcorr1=NULL){
		if(!is_null($idcorr1))
			$this->db->where(array('tbempreendimento_has_tbcorretor.tbempreendimento_id' => $idemp, 'tbcorretor.id !='=>$idcorr1));
		
		return $this->db->select('*')
						->from('tbempreendimento_has_tbcorretor')
						->join('tbcorretor', 'tbcorretor.id = tbcorretor_id')
						->get()->result();
	}

	public function getQuadra($idemp){
		$this->db->where('tbempreendimento_id', $idemp);
		$this->db->group_by('quadra');
		$query = $this->db->get('tbquadralote')->result();
		$qd = array(''=>'Qds');
		foreach ($query as $quadra):
			$qd[$quadra->quadra] = $quadra->quadra;
		endforeach;
		return $qd;
	}
	
	public function getLote($idemp=NULL, $idqd=NULL){
		$this->session->set_userdata('quadra',$idqd);
		if(!is_null($idqd))
			$this->db->where('tbempreendimento_id', $idemp);
			$this->db->where('quadra', $idqd);
			$this->db->where('tbsituacaolote_id', 3);
		
		return $this->db->select('*')
						->from('tbquadralote')
						->get()->result();
	}
	
	public function getqdlt($quadra, $lote){
		$this->db->where('quadra', $quadra);
		$this->db->where('lote', $lote);
		$query = $this->db->get('tbquadralote')->row();
		return $query;
	}
	
	public function getcivil(){
		$query = $this->db->get('tbestadocivil')->result();
		$civil1 = array();
		foreach ($query as $linha):
			$civil1[$linha->id] = $linha->estadocivil;
		endforeach;
		return $civil1;
	}
	
	public function get_regimes($idcivil){
		$this->db->where('tbestadocivil_id', $idcivil);
		return $this->db->get('tbestadocivilregime')->result();
	}	
	
	
}
/* End of file geral_model.php */
/* Location: ./application/models/geral_model.php */
