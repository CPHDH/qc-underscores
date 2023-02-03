/**
 * File navigation.js.
 */
(function () {
  // function: set body class
  let toggleMenuActive = (body, megamenu) => {
    megamenu.classList.toggle("active");
    body.classList.toggle("megamenu-active");
  };
  // function: toggle the menu button attributes
  let toggleButtonExpanded = (button) => {
    button.setAttribute(
      "aria-expanded",
      button.getAttribute("aria-expanded") == "true" ? "false" : "true"
    );
  };
  // function: trap focus -- works everywhere except Firefox
  let toggleInert = (lockable) => {
    lockable.forEach((el) => {
      el.toggleAttribute("inert");
    });
  };
  // function: set search focus on open
  let setFocus = (where) => {
    if (where == "search") {
      setTimeout(() => {
        // timeout accounts for animation
        document.querySelector("#megamenu .search-form input").focus();
      }, 500);
    } else if (where == "menu_button") {
      document.querySelector("#masthead #menu").focus();
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };
  // function: close on escape key
  let escapeKeyCloseEvent = (body, megamenu, button, lockable) => {
    document.onkeydown = (k) => {
      k = k || window.event;
      var _esc = false;
      if ("key" in k) {
        _esc = k.key === "Escape" || k.key === "Esc";
      } else {
        _esc = k.keyCode === 27;
      }
      if (_esc && megamenu.classList.contains("active")) {
        toggleMenu(body, megamenu, button, lockable);
        setFocus("menu_button");
      }
    };
  };
  // function: close when click off-menu
  let offClickCloseEvent = (body, megamenu, button, lockable) => {
    document.querySelector("#megamenu-overlay").addEventListener(
      "click",
      () => {
        if (megamenu.classList.contains("active")) {
          toggleMenu(body, megamenu, button, lockable);
        }
      },
      { once: true }
    );
  };
  // function: main menu toggle
  let toggleMenu = (body, megamenu, button, lockable) => {
    toggleMenuActive(body, megamenu);
    toggleButtonExpanded(button);
    toggleInert(lockable);
    if (megamenu.classList.contains("active")) {
      setFocus("search");
      escapeKeyCloseEvent(body, megamenu, button, lockable);
      offClickCloseEvent(body, megamenu, button, lockable);
    }
  };

  // click to init menu
  document.querySelector("#masthead #menu").addEventListener("click", (e) => {
    let megamenu = document.querySelector("#megamenu");
    let body = document.querySelector("body");
    let button = e.currentTarget;
    let lockable = document.querySelectorAll("#primary-container, #colophon"); // these will be made inert when menu is active to trap focus
    toggleMenu(body, megamenu, button, lockable);
  });

  // set aria-current for location type link on location-type archive
  let slugs = window.location.pathname.split("/");
  if (slugs.length >= 2 && slugs[1] == "location-type") {
    let path = "/" + slugs[1] + "/" + slugs[2] + "/";
    let type_links = document.querySelectorAll(
      '.terms-menu a[href="' + path + '"]'
    );
    if (type_links.length) {
      type_links.forEach((type) => {
        type.setAttribute("aria-current", "page");
      });
    }
  }
  // focus on inline search when 404 or no search results
  let try_search = document.querySelectorAll(
    ".search-no-results .page-content .search-form input,.error404 .page-content .search-form input"
  );
  if (try_search.length) {
    try_search[0].focus();
  }
})();
