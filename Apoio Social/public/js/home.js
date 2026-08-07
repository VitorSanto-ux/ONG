function abrirModalDoacao(
    nome,
    administrador,
    descricao,
    prazo_aarrecadar,
    preco,
    localizacao,
    foto
){
    document.getElementById('modal-titulo').innerText = nome;
    document.getElementById('modal-administrador').innerText = administrador;
    document.getElementById('modal-descricao').innerText = descricao;
    document.getElementById('modal-prazo_aarrecadar').innerText = prazo_aarrecadar + 'dias';
    document.getElementById('modal-preco').innerText = 
    'R$ ' + parseFloat(preco).toFixed(2);
    document.getElementById('modal-localizacao').innerText = localizacao;
    document.getElementById('modal-foto').src = foto;
    document.getElementById('modalDoacao').style.display = 'flex';
}

function fecharModalDoacao() {
    document.getElementById('modalDoacao').style.display = 'none';
}

function toggleCampanhas() {
    const dropdown = document.getElementById('campanhasDropdown');
    dropdown.classList.toggle('ativo');
}

function toggleExpandir(event) {
    event.stopPropagation();

    const extra = document.getElementById('campanhasExtra');
    const icon = document.getElementById('icon-expand');

    extra.classList.toggle('ativo');
    icon.classList.toggle('fa-rotate-180');
}

document.addEventListener('click', function(e) {
    const menu = document.getElementById('campanhasDropdown');
    const btn = document.querySelector('.btn-campanhas');

    if (!menu.contains(e.target) && !btn.contains(e.target)){
        menu.classList.remove('ativo');
    }
});

const searchInput = document.getElementById("searchInput");

const cards = document.querySelectorAll(".card-doacao");

searchInput.addEventListener("input", () => {

    const value = searchInput.value
        .toLowerCase()
        .trim();

    cards.forEach(card => {

        const nome =
            card.dataset.nome;

        const administrador =
            card.dataset.administrador;

        const descricao =
            card.dataset.descricao;

        const match =
            nome.includes(value) ||
            administrador.includes(value) ||
            descricao.includes(value);

        if(value === "" || match){

            card.style.display = "flex";

            requestAnimationFrame(() => {
                card.classList.remove("hidden-card");
            });

        }else{

            card.classList.add("hidden-card");

            setTimeout(() => {

                if(card.classList.contains("hidden-card")){
                    card.style.display = "none";
                }

            }, 120);

        }

    });

});