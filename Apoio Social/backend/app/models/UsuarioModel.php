<?php
class UsuarioModel {
    private $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function buscarTodos(){
        $stmt = $this->pdo->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function buscarUsuario($id){
        $stmt = $this->pdo->query("SELECT * FROM usuarios WHERE id = $id");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    

    public function cadastrar($nome, $email, $senha, $telefone, $tipo) {
        $sql = "INSERT INTO usuarios (nome, email, senha, telefone, tipo) VALUES (:nome, :email, :senha, :telefone, :tipo)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $senha,
            ':telefone' => $telefone,
            ':tipo' => $tipo
        ]);
    }
    public function editar($nome, $email, $senha, $telefone, $id) {
        $sql = "UPDATE usuarios SET nome=?, email=?, senha=?, telefone=? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $email, $senha, $telefone, $id]);
    }

    public function deletar($id) {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function buscarPorEmail($email){

    $sql = "SELECT * FROM usuarios
    WHERE email = ?";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([$email]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    return $usuario;

}

public function alterarFoto($foto, $id){

    $sql = "
        UPDATE usuarios
        SET foto = ?
        WHERE id = ?
    ";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        $foto,
        $id
    ]);
}

public function alterarSenha($senha, $id){

    $sql = "
        UPDATE usuarios
        SET senha = ?
        WHERE id = ?
    ";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        $senha,
        $id
    ]);
}
    
}
?>