<?php

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/models/CampanhaModel.php";

class CampanhaController
{
    private $campanhaModel;

    public function __construct($pdo)
    {
        $this->campanhaModel = new CampanhaModel($pdo);
    }

    public function listar()
    {
        return $this->campanhaModel->listar();
    }

    public function buscarPorId($id)
    {
        return $this->campanhaModel->buscarPorId($id);
    }
}