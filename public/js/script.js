
const nav  = document.getElementsByClassName('nav')[0]
const navOpenBtn = document.getElementsByClassName('navOpenBtn')[0]
const navClose = document.querySelector('.navClose') 

// console.log(iconNav);
// console.log(iconNav)
navOpenBtn.addEventListener("click",() =>
{ 

    nav.classList.add("openNav")}
);


navClose.addEventListener("click",() =>
{ nav.classList.remove("openNav")}
);




