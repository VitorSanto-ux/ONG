<?php

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/models/DoacaoModel.php";

class DoacaoController
{
    private $doacaoModel;

    public function __construct($pdo)
    {
        $this->doacaoModel = new DoacaoModel($pdo);
    }


    public function listar()
    {
        return $this->doacaoModel->listar();
    }


    public function listarPorAdministrador($administradorId)
    {
        return $this->doacaoModel->listarPorAdministrador($administradorId);
    }


    public function buscarPorId($id)
    {
        return $this->doacaoModel->buscarPorId($id);
    }

    public function buscarFiltrados($q, $campanhaId)
    {
        return $this->doacaoModel->buscarFiltrados($q, $campanhaId);
    }


    public function listarPorCampanha($campanhaId)
    {
        return $this->doacaoModel->listarPorCampanha($campanhaId);
    }


    public function criar(
        $usuarioId,
        $nomeDoacao,
        $descricao,
        $preco,
        $prazo_aarrecadar,
        $localizacao
    ) {

    
        $campanhaid = $this->doacaoModel->criar(
            $nomeDoacao,
            $descricao,
            $preco,
            $prazo_aarrecadar,
            $localizacao
        );

        return $this->doacaoModel->criarDoacao($preco,$usuarioId, $campanhaid, $descricao, $prazo_aarrecadar,$localizacao);
    }


    public function editar(
        $id,
        $nome_Doacao,
        $descricao,
        $preco,
        $prazo_aarrecadar

    ) {
        return $this->doacaoModel->editar(
            $id,
            $nome_Doacao,
            $descricao,
            $preco,
            $prazo_aarrecadar
        );
    }

    public function deletar($id)
    {
        return $this->doacaoModel->deletar($id);
    }
}
