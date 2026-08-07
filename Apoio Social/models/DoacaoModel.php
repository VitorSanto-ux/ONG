<?php

class DoacaoModel {

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    
    public function listar(){

    $sql = "SELECT 
                d.*,
                u.nome AS administrador,
                u.foto,
                p.nome AS campanha
            FROM doacoes d
            INNER JOIN usuarios u ON u.id = d.usuario_id
            INNER JOIN campanhas c ON c.id = d.campanha_id
            ORDER BY s.id DESC";

    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

    public function listarPorAdministrador($usuarioId){

        $sql = "SELECT 
                    d.*,
                    c.nome AS campanha
                FROM doacoes d
                INNER JOIN campanhas c ON c.id = d.campanha_id
                WHERE d.usuario_id = ?
                ORDER BY d.id DESC";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$usuarioId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarFiltrados($q = null, $campanhaId = null)
{
    $sql = "SELECT 
                d.*,
                u.nome AS administrador,
                u.foto,
                c.nome AS campanha_nome
            FROM doacoes d
            JOIN usuarios u ON u.id = d.usuario_id
            JOIN campanhas c ON c.id = d.campanha_id
            WHERE 1=1";
    $params = [];

    if (!empty($q)) {
        $sql .= " AND (d.nome_doacao LIKE ? OR d.descricao LIKE ?)";
        $params[] = "%$q%";
        $params[] = "%$q%";
    }

    if (!empty($campanhaId)) {
        $sql .= " AND d.campanha_id = ?";
        $params[] = $campanhaId;
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    
    public function listarPorCampanha($campanhaId){

        $sql = "SELECT 
                    d.*,
                    u.nome AS administrador,
                    c.nome AS campanha
                FROM doacoes d
                INNER JOIN usuarios u ON u.id = d.usuario_id
                INNER JOIN campanhas c ON c.id = d.campanha_id
                WHERE d.campanha_id = ?";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$campanhaId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

 
   public function buscarPorId($id) {

    $sql = "SELECT
    doacoes.*,
    usuarios.nome AS administrador,
    usuarios.foto,
    usuarios.email
FROM doacoes
INNER JOIN usuarios
ON doacoes.usuario_id = usuarios.id
WHERE doacoes.id = ?";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    
    public function criar(
    $usuarioId,
    $campanhaId,
    $nomeDoacao,
    $descricao,
    $preco,
    $prazo_aarrecadar,
    $localizacao
){

    $sql = "INSERT INTO doacoes 
    (
        usuario_id,
        campanha_id,
        nome_doacao,
        descricao,
        preco,
        prazo_aarrecadar,
        localizacao
    )
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        $usuarioId,
        $campanhaId,
        $nomeDoacao,
        $descricao,
        $preco,
        $prazo_aarrecadar,
        $localizacao
    ]);
}

    
    public function editar(
    $id,
    $nome_doacao,
    $descricao,
    $preco,
    $prazo_aarrecadar,
    $campanha_id
){

    $sql = "UPDATE doacoes
            SET 
                campanha_id = ?,
                nome_doacao = ?,
                descricao = ?,
                preco = ?,
                prazo_aarrecadar = ?
            WHERE id = ?";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        $campanha_id,
        $nome_doacao,
        $descricao,
        $preco,
        $prazo_aarrecadar,
        $id
    ]);
}

    public function deletar($id){

        $sql = "DELETE FROM doacoes WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    

}

?>