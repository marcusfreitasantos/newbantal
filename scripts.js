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
});
