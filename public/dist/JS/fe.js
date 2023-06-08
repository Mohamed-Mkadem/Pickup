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

// const langDropDownToggle = document.getElementById("lang-dropdown-toggle");
// const languagesList = Array.from(
//   document.querySelectorAll("#lang-dropdown li")
// );

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
    if (currentId == "seller-dialogue-toggle") {
        if (currentWidth < 768) {
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
    } else {
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

const mainNav = document.getElementById("main-nav");
const mainNavToggle = document.getElementById("nav-toggle");
const closeMainNavBtn = document.getElementById("close-main-nav");
closeMainNavBtn.addEventListener("click", () => {
    mainNav.classList.remove("show");
});
mainNavToggle.addEventListener("click", () => {
    mainNav.classList.toggle("show");
});

const preLoader = document.getElementById("preloader");
if (preLoader) {
    setTimeout(() => {
        preLoader.style.display = "none";
    }, 1500);
}
