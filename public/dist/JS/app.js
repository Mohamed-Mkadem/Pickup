const layoutToggle = document.getElementById("layout-toggle");
const root = document.documentElement;
const aside = document.getElementById("aside");
const asideToggle = document.getElementById("aside-toggle");
const navLinks = document.querySelectorAll(".nav-link");

if (window.sessionStorage.preferedLayout == "full-width") {
  root.classList.add("full-width");
  handleAsideStatus();
}
window.addEventListener("load", () => {
  if (window.innerWidth < 767) {
    enableFullWidth();
    aside.setAttribute("aria-current", "hidden");
    closeSubMenus();
  }
});
layoutToggle.addEventListener("click", () => {
  if (root.classList.contains("full-width")) {
    // window.sessionStorage.preferedLayout = "boxed";
    // root.classList.remove("full-width");
    // aside.setAttribute("aria-current", "expanded");
    disableFullWidth();
  } else {
    // window.sessionStorage.preferedLayout = "full-width";
    // root.classList.add("full-width");
    enableFullWidth();
    handleAsideStatus();
    closeSubMenus();
  }
});
if (asideToggle) {
  asideToggle.addEventListener("click", () => {
    if (root.classList.contains("full-width")) {
      // window.sessionStorage.preferedLayout = "boxed";
      // root.classList.remove("full-width");
      // aside.setAttribute("aria-current", "expanded");
      disableFullWidth();
    } else {
      enableFullWidth();
      aside.setAttribute("aria-current", "hidden");
      closeSubMenus();
    }
  });
}

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

const navCollapsedLinks = document.querySelectorAll(".nav-link.collapsed");
navCollapsedLinks.forEach((navLink) => {
  navLink.addEventListener("click", () => {
    let dropdown = navLink.nextElementSibling;

    if (aside.getAttribute("aria-current") != "detached") {
      dropdown.classList.toggle("show");
    } else {
      // window.sessionStorage.preferedLayout = "boxed";
      // root.classList.remove("full-width");
      // aside.setAttribute("aria-current", "expanded");
      disableFullWidth();
      dropdown.classList.toggle("show");
    }
  });
});

const subMenus = document.querySelectorAll(".nav-sub-dropdown");

// Close Sub Menus
function closeSubMenus() {
  subMenus.forEach((subMenu) => {
    subMenu.classList.remove("show");
  });
}

// Aside Status
function handleAsideStatus() {
  if (window.innerWidth > 768) {
    aside.setAttribute("aria-current", "detached");
  } else {
    aside.setAttribute("aria-current", "hidden");
  }
}

// Enable full width

function enableFullWidth() {
  window.sessionStorage.preferedLayout = "full-width";
  root.classList.add("full-width");
}

// Disable full width

function disableFullWidth() {
  window.sessionStorage.preferedLayout = "boxed";
  root.classList.remove("full-width");
  aside.setAttribute("aria-current", "expanded");
}

const preLoader = document.getElementById("preloader");

setTimeout(() => {
  if (preLoader) {
    preLoader.style.display = "none";
  }
}, 1500);

// Popup holder and it's buttons
const popUpHolder = document.querySelector(".pop-up-holder");

const popUpController = document.querySelector(".pop-up-controller");
const popUpCloser = document.querySelector(".close-pop-up-btn");

if (popUpController) {
  popUpController.addEventListener("click", () => {
    popUpHolder.classList.add("show");
    document.body.classList.add("no-scroll");
  });
}
if (popUpCloser) {
  popUpCloser.addEventListener("click", () => {
    popUpHolder.classList.remove("show");
    document.body.classList.remove("no-scroll");
  });
}
if (popUpHolder) {
  popUpHolder.addEventListener("click", (e) => {
    if (e.target == popUpHolder) {
      popUpHolder.classList.remove("show");
      document.body.classList.remove("no-scroll");
    }
  });
}

// Filters
const filterHolderController = document.getElementById(
  "filters-wrapper-controller"
);
const filtersWrapper = document.getElementById("filters-wrapper");
if (filterHolderController) {
  filterHolderController.addEventListener("click", () => {
    filtersWrapper.classList.toggle("hidden");
  });
}

// Description Holders

const descriptionHolderController = document.getElementById(
  "description-holder-controller"
);
const descriptionWrapper = document.getElementById("description-body");
if (descriptionHolderController) {
  descriptionHolderController.addEventListener("click", () => {
    descriptionWrapper.classList.toggle("hidden");
  });
}
