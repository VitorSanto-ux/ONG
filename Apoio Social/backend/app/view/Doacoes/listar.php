<?php

if (empty($doacoes)) {
    echo "<p>Nenhuma doação encontrada!</p>";
    echo "<a href='view/doacoes/cadastrar.php'>Cadastrar</a>";
    return;
}

echo "<table border='1' cellpadding='5' cellspacing='0'>";

echo "<tr>
        <td colspan='8'>
            <a href='view/doacoes/cadastrar.php'>Cadastrar</a>
        </td>
      </tr>";

echo "<tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Preço à Arrecadar</th>
        <th>Campanha</th>
        <th>Prazo</th>
        <th>Localização</th>
        <th>Ações</th>
      </tr>";

foreach ($doacoes as $doacao) {

    $id = $doacao['id'];

    echo "<tr>";

    echo "<td>{$id}</td>";

    echo "<td>{$doacao['nome_doacao']}</td>";

    echo "<td>{$doacao['descricao']}</td>";

    echo "<td>{$doacao['preco']}</td>";

    echo "<td>{$doacao['campanha']}</td>";

    echo "<td>{$doacao['prazo_aarrecadar']}</td>";

    echo "<td>{$doacao['localizacao']}</td>";

    echo "<td>
            <a href='view/doacoes/editar.php?id={$id}'>
                Editar
            </a>
            |
            <a 
                href='view/doacoes/deletar.php?id={$id}' 
                onclick=\"return confirm('Tem certeza que deseja excluir esta doação?')\"
            >
                Deletar
            </a>
          </td>";

    echo "</tr>";
}

echo "</table>";
?>