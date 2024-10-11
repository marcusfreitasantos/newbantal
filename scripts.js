const callSearchForm = () => {
  const searchForm = document.querySelector(".header__search_form");
  searchForm.classList.toggle("show__search_form");
};

document.addEventListener("DOMContentLoaded", function () {
  const mobileMenuBtn = document.querySelector(".header__main_menu_btn");
  const mobileMenuBtnClose = document.querySelector(
    ".header__main_menu_btn_close"
  );
  const mobileMenu = document.querySelector(".header__main_menu");

  mobileMenuBtn.addEventListener("click", function () {
    mobileMenu.classList.add("show__header_main_menu");
    mobileMenuBtn.style.display = "none";
    mobileMenuBtnClose.style.display = "block";
  });

  mobileMenuBtnClose.addEventListener("click", function () {
    mobileMenu.classList.remove("show__header_main_menu");
    mobileMenuBtn.style.display = "block";
    mobileMenuBtnClose.style.display = "none";
  });

  const loginForm = document.querySelector(".login__form_wrapper");
  const loginFormBtn = document.querySelector(".header__login_form_btn");

  loginFormBtn.addEventListener("mouseover", function () {
    console.log("over");
    loginForm.style.display = "block";
  });

  loginForm.addEventListener("mouseleave", function () {
    loginForm.style.display = "none";
  });
});
