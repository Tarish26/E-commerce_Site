let magnify = document.getElementsByClassName("fa-search")[0];
let navBar = document.getElementById("navbar2");
let cross = document.querySelector(".fa-xmark");


magnify.addEventListener("click", func);

function func(){
    navBar.style.display = "flex";
}

cross.addEventListener("click", toggleCloseNavbar);

function toggleCloseNavbar(){
    navBar.style.display = "none";
}


function submitForm() {
  const input = document.getElementById('input');
  const inputValue = input.value;
  console.log('Submitted form data:', inputValue);
}

document.getElementById("submit").addEventListener("click", submitForm);

document.getElementById("profileIcon").addEventListener("click", function(){
    if(document.getElementById("profileDropdown").style.display == "grid"){
        document.getElementById("profileDropdown").style.display = "none";
    }
    else{
        document.getElementById("profileDropdown").style.display = "grid";
    }
})

document.getElementById("openCart").addEventListener("click", funCart);

function funCart(){
    if(document.getElementById("cartItems").style.display == "flex"){
       document.getElementById("cartItems").style.display = "none";
    }
    else{
    document.getElementById("cartItems").style.display = "flex";
    }
}

let filterOn = false;

document.getElementById("darkMode").addEventListener("click", function(){
    filterOn = !filterOn;
    var allElements = document.querySelectorAll("*");
    for(var i = 0; i < allElements.length; i++){
        allElements[i].style.filter = filterOn ? "invert(100%)" : "invert(0%)";
        allElements[i].style.color = filterOn ? "white" : "black";
    }
})