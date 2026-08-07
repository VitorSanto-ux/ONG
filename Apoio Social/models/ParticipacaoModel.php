<?php

class ParticipacaoModel {

    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function participar($doadorId, $doacaoId, $mensagem)
{
    $sql = "INSERT INTO participacoes
    (
        doador_id,
        doacao_id,
        mensagem,
        status
    )
    VALUES (?, ?, ?, 'pendente')";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        $doadorId,
        $doacaoId,
        $mensagem
    ]);
}


public function listarParaAdministrador($administradorId)
{
    $sql = "SELECT
            c.*,
            u.nome AS doador,
            d.nome_doacao

        FROM participacoes p

        INNER JOIN usuarios u
        ON p.doador_id = u.id

        INNER JOIN doacoes d
        ON p.doacao_id = d.id

        WHERE d.usuario_id = ?
        AND p.status NOT IN ('concluido', 'recusado')

        ORDER BY p.id DESC";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([$administradorId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function atualizarStatus($id, $status)
{
    $sql = "UPDATE participacoes
            SET status = ?
            WHERE id = ?";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        $status,
        $id
    ]);
}

public function atualizarMensagem($id, $mensagem)
{
    $sql = "
        UPDATE participacoes
        SET mensagem = ?
        WHERE id = ?
    ";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        $mensagem,
        $id
    ]);
}

   public function listarPorDoador($doadorId) {

    $sql = "SELECT
                p.*,
                p.mensagem AS solicitacao,
                d.nome_doacao,
                d.preco,
                u.nome AS administrador
            FROM participacoes p
            INNER JOIN doacoes d
                ON d.id = p.doacao_id
            INNER JOIN usuarios u
                ON u.id = d.usuario_id
            WHERE p.doador_id = ?
            ORDER BY p.id DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$doadorId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function contarPendentesAdministrador($administradorId)
{
    $sql = "SELECT COUNT(*) as total
            FROM participacoes p

            INNER JOIN doacoes d
            ON d.servico_id = d.id

            WHERE d.usuario_id = ?
            AND p.status = 'pendente'";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([$administradorId]);

    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

public function contarNotificacoesDoador($doadorId)
{
    $sql = "
        SELECT COUNT(*) as total
        FROM participacoes
        WHERE cliente_id = ?
        AND (
            status = 'aceito'
            OR status = 'recusado'
            OR status = 'concluido'
        )
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([$doadorId]);

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    return $resultado['total'];
}

public function deletar($id)
{
    $sql = "DELETE FROM participacoes WHERE id = ?";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([$id]);
}
}
?>