function abrirModal(
    id,
    nome,
    descricao,
    preco,
    prazo_aarrecadar,
    localizacao,
    campanha
){

    document.getElementById('edit-id').value = id;

    document.getElementById('edit-nome').value = nome;

    document.getElementById('edit-descricao').value = descricao;

    document.getElementById('edit-preco').value = preco;

    document.getElementById('edit-prazo_arrecadar').value = prazo_aarrecadar;

    document.getElementById('edit-localizacao').value = localizacao;

    document.getElementById('modalEditar').style.display = 'flex';
}

function fecharModal(){

    document.getElementById('modalEditar').style.display = 'none';
}