const baseUrl = `../backend/tarefa/`;

let modal = null;
let btnSalvar = null;
let btnAlterar = null;

let loading = null;

onload = async () => {
  modal = new bootstrap.Modal(document.getElementById("exampleModal"));
  btnSalvar = document.getElementById("salvar");
  btnAlterar = document.getElementById("alterar");
  loading = document.getElementById("loading");

  btnSalvar.addEventListener("click", async () => {
    toggleButton(btnSalvar);

    const descricao = document.getElementById("descricao").value;
    const categoria = document.getElementById("categoria").value;
    const data = document.getElementById("data").value;

    const body = new FormData();
    body.append("descricao", descricao);
    body.append("categoria", categoria);
    body.append("data", data);

    const response = await fetch(`${baseUrl}salvar.php`, {
      method: "POST",
      body,
    });
    const tarefa = await response.json();

    const [tbody] = document.getElementsByTagName("tbody");
    const tr = criarLinha(tarefa);
    tbody.appendChild(tr);

    modal.hide();

    toggleButton(btnSalvar);
  });

  btnAlterar.addEventListener("click", async () => {
    toggleButton(btnAlterar);
    const descricao = document.getElementById("descricao").value;
    const categoria = document.getElementById("categoria").value;
    const data = document.getElementById("data").value;
    const id = document.getElementById("id").value;

    const body = new FormData();
    body.append("descricao", descricao);
    body.append("categoria", categoria);
    body.append("data", data);
    const response = await fetch(`${baseUrl}alterar.php?id=${id}`, {
      method: "POST",
      body,
    });
    const tarefa = await response.json();
    atualizarLinha(tarefa);

    modal.hide();
    toggleButton(btnAlterar);
  });

  const novo = document.getElementById("novo");
  novo.addEventListener("click", () => {
    preencheFormulario();
    btnAlterar.style.display = "none";
    btnSalvar.style.display = "inline";
  });
  await carregaTarefas();
};

const criarLinha = ({ id, descricao, categoria, data }) => {
  const tr = document.createElement("TR");
  tr.setAttribute("id", id);
  tr.innerHTML = `<td>${descricao}</td>
    <td>${categoria}</td>
    <td>${data
      .split("-")
      .reduce((a, b) => `${b}/${a}`, "")
      .slice(0, -1)}</td>`;

  const btnEdit = novoBotao("warning", "pencil", () => {
    preencheFormulario(id, descricao, categoria, data);
    btnAlterar.style.display = "inline";
    btnSalvar.style.display = "none";
    modal.show();
  });

  const btnDelete = novoBotao("danger", "trash", async () => {
    toggleLoading();
    const response = await fetch(`${baseUrl}remover.php?id=${id}`, {
      method: "DELETE",
    });
    await response.json();

    // await carregaTarefas()
    const [tbody] = document.getElementsByTagName("tbody");
    tbody.childNodes.forEach((tr) => {
      if (tr.getAttribute("id") == id) tbody.removeChild(tr);
    });
    toggleLoading();
  });

  const td = document.createElement("TD");
  td.appendChild(btnEdit);
  td.appendChild(btnDelete);
  tr.appendChild(td);
  return tr;
};

const carregaTarefas = async () => {
  toggleLoading();
  const [tbody] = document.getElementsByTagName("tbody");
  tbody.innerHTML = "";

  const response = await fetch(`${baseUrl}index.php`);
  const tarefas = await response.json();

  toggleLoading();
};

const novoBotao = (color, icon, cb, label = "") => {
  const btn = document.createElement("BUTTON");
  btn.setAttribute("type", "button");
  btn.setAttribute("class", `btn btn-${color} btn-sm`);
  btn.innerHTML = `<i class='fa-solid fa-${icon}'></i> ${label}`;
  btn.addEventListener("click", cb);
  return btn;
};

const preencheFormulario = (
  id = "",
  descricao = "",
  categoria = "",
  data = ""
) => {
  const descricaoInput = document.getElementById("descricao");
  const categoriaInput = document.getElementById("categoria");
  const dataInput = document.getElementById("data");
  const idInput = document.getElementById("id");

  descricaoInput.value = descricao;
  categoriaInput.value = categoria;
  dataInput.value = data;
  idInput.value = id;
};

const atualizarLinha = (tarefa) => {
  const [tbody] = document.getElementsByTagName("tbody");
  tbody.childNodes.forEach((tr) => {
    if (tr.getAttribute("id") == tarefa.id) {
      const nova = criarLinha(tarefa);
      tbody.insertBefore(nova, tr);
      tbody.removeChild(tr);
    }
  });
};

const toggleButton = (btn) => {
  btn.disabled = !btn.disabled;
  btn.childNodes.forEach((el) => {
    if (el.nodeName === "SPAN") {
      el.classList.toggle("visually-hidden");
    }
  });
};

const toggleLoading = () => loading.classList.toggle("visually-hidden");
