let mode = sessionStorage.getItem("mode");

const modeSwitcher = document.getElementById("mode-switcher");
if (mode) {
  enableDarkMode();
}

modeSwitcher.addEventListener("click", () => {
  let currentMode = mode;
  if (!currentMode) {
    enableDarkMode();
  } else if (currentMode) {
    diasbleDarkMode();
  }
});

function enableDarkMode() {
  document.body.classList.add("dark");
  if (modeSwitcher) {
    modeSwitcher.setAttribute("aria-current", "Enabled");
  }

  sessionStorage.setItem("mode", "dark");
  mode = sessionStorage.getItem("mode");
}
function diasbleDarkMode() {
  document.body.classList.remove("dark");
  if (modeSwitcher) {
    modeSwitcher.setAttribute("aria-current", "Disabled");
  }
  sessionStorage.removeItem("mode");
  mode = sessionStorage.getItem("mode");
}

const overlay = document.getElementById("overlay");

const dropdownsTogglers = Array.from(
  document.querySelectorAll(".dropdown-toggle")
);
const dropdowns = Array.from(document.querySelectorAll(".dropdown-menu"));

dropdownsTogglers.forEach((btn) => {
  btn.addEventListener("click", () => {
    hideDropDowns();
    removeAriaPressed(btn);
    showDropDown(btn);
  });
});

overlay.addEventListener("click", () => {
  hideDropDowns();
  removeAriaPressed();
  overlay.classList.remove("show");
});

function showDropDown(dropdownBtn) {
  const dropdown = dropdownBtn.nextElementSibling;
  let currentStatus = dropdownBtn.getAttribute("aria-pressed");
  let currentId = dropdownBtn.getAttribute("id");
  let currentWidth = window.innerWidth;

  if (currentStatus == "false") {
    overlay.classList.add("show");
    dropdown.classList.add("show");
    dropdownBtn.setAttribute("aria-pressed", "true");
  } else {
    overlay.classList.remove("show");
    dropdown.classList.remove("show");
    dropdownBtn.setAttribute("aria-pressed", "false");
  }
}

function hideDropDowns() {
  dropdowns.forEach((dMenu) => {
    dMenu.classList.remove("show");
  });
}
function removeAriaPressed(exceptionBtn = null) {
  dropdownsTogglers.forEach((btn) => {
    // btn.setAttribute("aria-pressed", "false");

    if (btn != exceptionBtn) {
      btn.setAttribute("aria-pressed", "false");
    }
  });
}

const preLoader = document.getElementById("preloader");

setTimeout(() => {
  if (preLoader) {
    preLoader.style.display = "none";
  }
}, 1500);

const navToggle = document.getElementById("nav-toggle");
const mainNavigation = document.getElementById("store-navigation-menu");
const mainNavigationCloseBtn = document.getElementById("close-main-navigation");
navToggle.addEventListener("click", () => {
  mainNavigation.classList.toggle("show");
  document.body.classList.toggle("no-scroll");
});
mainNavigationCloseBtn.addEventListener("click", () => {
  mainNavigation.classList.toggle("show");
  document.body.classList.toggle("no-scroll");
});
const actionsControllers = Array.from(
  document.querySelectorAll(".actions-controller")
);
const actionsHolders = document.querySelectorAll(".actions-holder");
actionsControllers.forEach((controller) => {
  controller.addEventListener("click", () => {
    let actionHolder = controller.nextElementSibling;
    actionHolder.classList.toggle("show");
    overlay.classList.toggle("show");
  });
});
overlay.addEventListener("click", () => {
  overlay.classList.remove("show");
  actionsHolders.forEach((holder) => {
    holder.classList.remove("show");
  });
});
const modalsHolders = Array.from(document.querySelectorAll(".modal-holder"));
modalsHolders.forEach((modalHolder) => {
  modalHolder.addEventListener("click", (e) => {
    if (e.target.classList.contains("modal-holder")) {
      e.target.classList.remove("show");

      document.body.classList.remove("no-scroll");
    }
  });
});
const unPublishBtn = document.querySelector(".unPublishBtn");
if (unPublishBtn) {
  unPublishBtn.addEventListener("click", () => {
    let modalHolder = unPublishBtn.nextElementSibling;
    modalHolder.classList.add("show");
    document.body.classList.add("no-scroll");
  });
}
const closeModalsHolderBtns = Array.from(
  document.querySelectorAll(".close-modal-holder-btn")
);
closeModalsHolderBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    let modalHolder = btn.parentElement.parentElement.parentElement;
    modalHolder.classList.remove("show");
    document.body.classList.remove("no-scroll");
  });
});

const publishBtn = document.querySelector(".publishBtn");
if (publishBtn) {
  publishBtn.addEventListener("click", () => {
    let modalHolder = publishBtn.nextElementSibling;
    modalHolder.classList.add("show");
    document.body.classList.add("no-scroll");
  });
}

const cancelBtns = Array.from(document.querySelectorAll(".cancelBtn"));
cancelBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    let parentModalHolder = btn.parentElement.parentElement.parentElement;
    parentModalHolder.classList.remove("show");
    document.body.classList.remove("no-scroll");
  });
});
