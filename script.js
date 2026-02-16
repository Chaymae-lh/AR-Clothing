document.addEventListener("DOMContentLoaded", () => {

  // =======================
  // SELECTORS
  // =======================
  const products = document.querySelectorAll(".product");
  const count = document.getElementById("count");
  const search = document.getElementById("searchInput");
  const hamburger = document.getElementById("hamburger");
  const navLinks = document.getElementById("nav-links");
  const navbar = document.querySelector(".navbar");

  // =======================
  // SCROLL NAVBAR HIDE/SHOW
  // =======================
  let lastScrollTop = 0;
  window.addEventListener("scroll", () => {
    let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
    
    if (currentScroll > lastScrollTop) {
      // Scrolling DOWN
      navbar.classList.add("navbar-hide");
    } else {
      // Scrolling UP
      navbar.classList.remove("navbar-hide");
    }
    
    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
  });

  // =======================
  // UPDATE COUNT (DOIT ÊTRE AVANT)
  // =======================
  function updateCount(){
    let visible = 0;
    products.forEach(p => {
      if (p.style.display !== "none") visible++;
    });
    if (count) count.innerText = visible;
  }

  // =======================
  // INITIALIZE PRODUCT COUNT
  // =======================
  if (products.length && count) {
    updateCount();
  }

  // =======================
  // CATEGORY FILTER
  // =======================
  window.filterCategory = function(cat){
    products.forEach(p=>{
      p.style.display =
        p.dataset.category.toLowerCase() === cat.toLowerCase()
        ? "block"
        : "none";
    });
    updateCount();
    // Scroll vers la section produits
    const productsSection = document.getElementById("products");
    if (productsSection) {
      productsSection.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  };

  window.showAll = function(){
    products.forEach(p => p.style.display = "block");
    updateCount();
    // Scroll vers la section produits
    const productsSection = document.getElementById("products");
    if (productsSection) {
      productsSection.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  };

  // =======================
  // SEARCH
  // =======================
  if (search) {
    search.addEventListener("input", () => {
      const v = search.value.toLowerCase().trim();
      products.forEach(p => {
        const words = p.innerText.toLowerCase().split(/\s+/);
        p.style.display = words.some(word => word.startsWith(v))
          ? "block"
          : "none";
      });
      updateCount();
      // Scroll vers la section produits
      if (v.length > 0) {
        const productsSection = document.getElementById("products");
        if (productsSection) {
          productsSection.scrollIntoView({ behavior: "smooth", block: "start" });
        }
      }
    });
  }

  // =======================
  // 🍔 HAMBURGER MENU (MAINTENANT OK)
  // =======================
  if (hamburger && navLinks) {
    hamburger.addEventListener("click", () => {
      navLinks.classList.toggle("active");
      document.body.style.overflow = navLinks.classList.contains("active") ? "hidden" : "auto";
    });

    const navLinksItems = navLinks.querySelectorAll("a");
    navLinksItems.forEach(link => {
      link.addEventListener("click", () => {
        navLinks.classList.remove("active");
        document.body.style.overflow = "auto";
      });
    });
  }

});
