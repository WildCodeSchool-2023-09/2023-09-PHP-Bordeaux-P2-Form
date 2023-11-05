const hamburgerToggler = document.querySelector(".hamburger")
const navlinksContainer = document.querySelector(".navlinks_container");

const toggleNav = e => {
    hamburgerToggler.classList.toggle("open")
    navlinksContainer.classList.toggle("open")
}
hamburgerToggler.addEventListener("click", toggleNav)

new ResizeObserver(entries => {
    if(entries[0].contentRect.width <= 600){
        navlinksContainer.style.transition = "transform 0.3s ease-out"
    } else {
        navlinksContainer.style.transition = "none"
    }
}).observe(document.body)