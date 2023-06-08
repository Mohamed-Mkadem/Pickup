const modalsHolders = Array.from(document.querySelectorAll(".modal-holder"));

const deleteBtns = Array.from(document.querySelectorAll(".deleteBtn"));

const actionsControllers = Array.from(
  document.querySelectorAll(".actions-controller")
);
const pageOverlay = document.getElementById("overlay");
const actionsHolders = document.querySelectorAll(".actions-holder");
const confirmBtns = Array.from(document.querySelectorAll(".confirmBtn"));
const editBtns = Array.from(document.querySelectorAll(".editBtn"));
const cancelBtns = Array.from(document.querySelectorAll(".cancelBtn"));
const closeModalsHolderBtns = Array.from(
  document.querySelectorAll(".close-modal-holder-btn")
);
const decisionrBtns = Array.from(document.querySelectorAll(".decisionBtn"));
const formDialogBtns = Array.from(
  document.querySelectorAll(".form-dialog-btn")
);
const activateBtns = Array.from(document.querySelectorAll(".activateBtn"));
const showBtns = Array.from(document.querySelectorAll(".showBtn"));


actionsControllers.forEach((controller) => {
  controller.addEventListener("click", () => {
    let actionHolder = controller.nextElementSibling;
    actionHolder.classList.toggle("show");
    pageOverlay.classList.toggle("show");
  });
});
pageOverlay.addEventListener("click", () => {
  pageOverlay.classList.remove("show");
  actionsHolders.forEach((holder) => {
    holder.classList.remove("show");
  });
});

deleteBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    let modalHolder = btn.nextElementSibling;
    modalHolder.classList.add("show");
    document.body.classList.add("no-scroll");
  });
});
decisionrBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    let modalHolder = btn.nextElementSibling;
    modalHolder.classList.add("show");
    document.body.classList.add("no-scroll");
  });
});
activateBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    let modalHolder = btn.nextElementSibling;
    modalHolder.classList.add("show");
    document.body.classList.add("no-scroll");
  });
});
showBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    let modalHolder = btn.nextElementSibling;
    modalHolder.classList.add("show");
    document.body.classList.add("no-scroll");
  });
});

modalsHolders.forEach((modalHolder) => {
  modalHolder.addEventListener("click", (e) => {
    if (e.target.classList.contains("modal-holder")) {
      e.target.classList.remove("show");
      document.body.classList.remove("no-scroll");
    }
  });
});

cancelBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    let parentModalHolder = btn.parentElement.parentElement.parentElement;
    parentModalHolder.classList.remove("show");
    document.body.classList.remove("no-scroll");
  });
});

editBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    let modalHolder = btn.nextElementSibling;
    modalHolder.classList.add("show");
    document.body.classList.add("no-scroll");
  });
});
formDialogBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    let modalHolder = btn.nextElementSibling;
    modalHolder.classList.add("show");
    document.body.classList.add("no-scroll");
  });
});
closeModalsHolderBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    let modalHolder = btn.parentElement.parentElement.parentElement;
    modalHolder.classList.remove("show");
    document.body.classList.remove("no-scroll");
  });
});
