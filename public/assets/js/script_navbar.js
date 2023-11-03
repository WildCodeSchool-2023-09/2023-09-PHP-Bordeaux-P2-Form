const hamburgerToggler = document.querySelector(".hamburger")
const navlinksContainer = document.querySelector(".navlinks_container");

const toggleNav = e => {
    navlinksContainer.classList.toggle("open")
    hamburgerToggler.classList.toggle("open")
}
hamburgerToggler.addEventListener("click", toggleNav)