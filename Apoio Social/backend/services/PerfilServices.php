<?php

class PerfilService {

    private $usuarioController;

    public function __construct($usuarioController) {
        $this->usuarioController = $usuarioController;
    }


    /* ALTERAR SENHA */

    public function alterarSenha(
        $usuarioId,
        $email,
        $novaSenha,
        $confirmarSenha
    ) {

        if (
            empty($email) ||
            empty($novaSenha) ||
            empty($confirmarSenha)
        ) {
            return "Preencha todos os campos.";
        }


        $usuario = $this->usuarioController->buscarUsuario($usuarioId);


        if (!$usuario) {
            return "Usuário não encontrado.";
        }


        if ($email !== $usuario['email']) {
            return "O email informado não corresponde à sua conta.";
        }


        if ($novaSenha !== $confirmarSenha) {
            return "As senhas não coincidem.";
        }


        $this->usuarioController->alterarSenha(
            $novaSenha,
            $usuarioId
        );


        return "Senha alterada com sucesso.";
    }


    /* ALTERAR FOTO */

    public function alterarFoto($usuarioId, $arquivo) {

        if (!isset($arquivo) || $arquivo['error'] !== 0) {
            return "Erro ao enviar a foto.";
        }


        $ext = strtolower(
            pathinfo($arquivo['name'], PATHINFO_EXTENSION)
        );


        $permitidas = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];


        if (!in_array($ext, $permitidas)) {
            return "Formato inválido.";
        }


        $novoNome = "user_" . $usuarioId . "." . $ext;

        $pasta = "uploads/";


        if (!is_dir($pasta)) {
            mkdir($pasta, 0755, true);
        }


        $caminho = $pasta . $novoNome;


        if (!move_uploaded_file(
            $arquivo['tmp_name'],
            $caminho
        )) {
            return "Erro ao salvar a foto.";
        }


        $this->usuarioController->alterarFoto(
            $caminho,
            $usuarioId
        );


        return "Foto alterada com sucesso.";
    }
}
?> 