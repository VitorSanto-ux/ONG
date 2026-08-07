const scrollIndicator = document.getElementById("scrollIndicator");

window.addEventListener("scroll", () => {

    if(window.scrollY > 80){
        scrollIndicator.classList.add("hide");
    }else{
        scrollIndicator.classList.remove("hide");
    }

});

scrollIndicator.addEventListener("click", () => {

    window.scrollTo({
        top: window.innerHeight,
        behavior: "smooth"
    });

});