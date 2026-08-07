<?php

require_once "C:/Turma2/xampp/htdocs/ONG/backend/app/models/ParticipacaoModel.php";

class ParticipacaoController{
    private $participacaoModel;

    public function __construct($pdo){
        $this->participacaoModel = new ParticipacaoModel($pdo);
    }

    public function participar($doadorId, $doacaoId, $mensagem){
        return $this->participacaoModel->participar(
            $doadorId,
            $doacaoId,
            $mensagem
        );
    }

    public function listarParaAdministrador($administradorId){
        return $this->participacaoModel->listarParaAdministrador($administradorId);
    }

    public function atualizarStatus($id, $status){
        return $this->participacaoModel->atualizarStatus($id, $status);
    }

    public function atualizarMensagem($id, $mensagem){
        return $this->participacaoModel->atualizarMensagem($id, $mensagem);
    }

    public function listarPorDoador($doadorId){
        return $this->participacaoModel->listarPorDoador($doadorId);
    }

    public function contarPendentesAdministrador($administradorId){
        return $this->participacaoModel->contarPendetesAdministrador($administradorId);
    }

    public function contarPendentesDoador($doadorId){
        return $this->participacaoModel->contarPendentesDoador($doadorId);
    }

    public function deletar($id){
        return $this->participacaoModel->deletar($id);
    }
}
?>