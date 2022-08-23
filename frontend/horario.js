const baseUrl = `../backend/horario/`;

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

    const dia = document.getElementById("dia").value;
    const task = document.getElementById("task").value;
    const tempo = document.getElementById("tempo").value;
    console.log(dia);
    const body = new FormData();
    body.append("dia", dia);
    body.append("task", task);
    body.append("tempo", tempo);

    const response = await fetch(`${baseUrl}salvar.php`, {
      method: "POST",
      body,
    });
    const horario = await response.json();

    const [tbody] = document.getElementsByTagName("tbody");
    const tr = criarLinha(horario);
    tbody.appendChild(tr);

    modal.hide();

    toggleButton(btnSalvar);
  });

  btnAlterar.addEventListener("click", async () => {
    toggleButton(btnAlterar);
    const dia = document.getElementById("dia").value;
    const task = document.getElementById("task").value;
    const tempo = document.getElementById("tempo").value;
    const id = document.getElementById("id").value;

    const body = new Formtempo();
    body.append("dia", dia);
    body.append("task", task);
    body.append("tempo", tempo);
    const response = await fetch(`${baseUrl}alterar.php?id=${id}`, {
      method: "POST",
      body,
    });
    const horario = await response.json();
    atualizarLinha(horario);

    modal.hide();
    toggleButton(btnAlterar);
  });

  const novo = document.getElementById("novo");
  novo.addEventListener("click", () => {
    preencheFormulario();
    btnAlterar.style.display = "none";
    btnSalvar.style.display = "inline";
  });
  await carregaHorarios();
};

const criarLinha = ({ id, dia, task, tempo }) => {
  const tr = document.createElement("TR");
  tr.setAttribute("id", id);
  tr.innerHTML = `
    <td>${tempo}</td>
    <td>${task}</td>
    `;

  const btnEdit = novoBotao("warning", "pencil", () => {
    preencheFormulario(id, dia, task, tempo);
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

const carregaHorarios = async () => {
  toggleLoading();
  // const [tbody] = document.getElementsByTagName("tbody");
  // tbody.innerHTML = "";

  const response = await fetch(`${baseUrl}index.php`);
  //const horarios = await response;

  await response.text().then((tabela) => {
    document.getElementById("horarios").innerHTML = tabela;
    toggleLoading();
  });
  // horarios.forEach((horario) => {
  //   const tr = criarLinha(horario);
  //   tbody.appendChild(tr);
  // });

  // horarios.getData(). then((tbl) => {
  //   console.log(tbl);
  // });
  // //document.getElementById("horarios").innerHTML = response.getData;
};

const novoBotao = (color, icon, cb, label = "") => {
  const btn = document.createElement("BUTTON");
  btn.setAttribute("type", "button");
  btn.setAttribute("class", `btn btn-${color} btn-sm`);
  btn.innerHTML = `<i class='fa-solid fa-${icon}'></i> ${label}`;
  btn.addEventListener("click", cb);
  return btn;
};

const preencheFormulario = (id = "", dia = "", task = "", tempo = "") => {
  const diaInput = document.getElementById("dia");
  const taskInput = document.getElementById("task");
  const tempoInput = document.getElementById("tempo");
  const idInput = document.getElementById("id");

  diaInput.value = dia;
  taskInput.value = task;
  tempoInput.value = tempo;
  idInput.value = id;
};

const atualizarLinha = (horario) => {
  const [tbody] = document.getElementsByTagName("tbody");
  tbody.childNodes.forEach((tr) => {
    if (tr.getAttribute("id") == horario.id) {
      const nova = criarLinha(horario);
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
