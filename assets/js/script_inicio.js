const body = document.querySelector("body"), 
    sidebar = body.querySelector(".sidebar"),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box");

    toggle.addEventListener("click",() =>{
        sidebar.classList.toggle("close");
    });

    searchBtn.addEventListener("click",() =>{
        sidebar.classList.remove("close");
    });



const menuLinks = document.querySelectorAll('.nav-link');

menuLinks.forEach(link => {
    link.addEventListener('click', (event) => {
    menuLinks.forEach(item => item.classList.remove('active'));
    event.target.classList.add('active');
    });
});