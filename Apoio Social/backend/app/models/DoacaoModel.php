<?php

class DoacaoModel
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function listar()
    {

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

    public function listarPorAdministrador($usuarioId)
    {

        $sql = "SELECT 
                    d.*,
                    c.nome AS campanha
                FROM doacao d
                INNER JOIN campanha c ON c.id_campanha = d.id_campanha
                WHERE d.id_doador = ?
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
            FROM doacao d
            JOIN usuarios u ON u.id = d.id_doador
            JOIN campanha c ON c.id_campanha = d.id_campanha
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


    public function listarPorCampanha($campanhaId)
    {

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


    public function buscarPorId($id)
    {

        $sql = "SELECT
    doacao.*,
    usuarios.nome AS administrador,
    usuarios.foto,
    usuarios.email
    FROM doacao
    INNER JOIN usuarios
    ON doacao.id_doador = usuarios.id
    WHERE doacao.id = ?";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function criar(
        $nome,
        $descricao,
        $metaValor,
        $prazo_aarrecadar,
        $localizacao

    ) {
        $sql = "INSERT INTO campanha (
                nome,
                descricao,
                data_inicio,
                data_fim,
                meta_valor
            )
            VALUES (?, ?, NOW(), NOW(), ?)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $nome,
            $descricao,
            $metaValor
        ]);

        // Retorna o ID da campanha recém-criada
        return $this->pdo->lastInsertId();
    }

    public function criarDoacao(
        $preco,
        $usuarioId,
        $campanhaId,
        $descricao,
        $prazo_aarrecadar,
        $localizacao
    ) {
        $sql = "INSERT INTO doacao (
                preco,
                id_doador,
                id_campanha,
                descricao,
                prazo_aarrecadar,
                localizacao
            )
            VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $preco,
            $usuarioId,
            $campanhaId,
            $descricao,
            $prazo_aarrecadar,
            $localizacao
        ]);
    }


    public function editar(
        $id,
        $nome_doacao,
        $descricao,
        $preco,
        $prazo_aarrecadar
    ) {

        $sql = "UPDATE doacao
            SET 
                descricao = ?,
                preco = ?,
                prazo_aarrecadar = ?
            WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $descricao,
            $preco,
            $prazo_aarrecadar,
            $id
        ]);
    }

    public function deletar($id)
    {

        $sql = "DELETE FROM doacao WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }
}
