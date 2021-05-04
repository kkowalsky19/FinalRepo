
var textBoxListener = 0;
var amount =  0;
var cost = 0;


function setSnack(){
    amount = document.getElementById("amountOfSnacks").value;
    console.log(amount);
}

function buttonPress(){
    if(document.getElementById("phone").value.length != 16){
        alert("Please enter a valid phone number!");
    }
    else{
    document.getElementsByClassName("phone")[0].style.visibility = "hidden";
    document.getElementsByClassName("phone")[1].style.visibility = "hidden";
    document.getElementById("paymentDiv").style.visibility = "visible";
    document.getElementById("inputDiv").style.visibility = "hidden";
    document.getElementById("totalCost").style.visibility = "visible";
    document.getElementById("purchaseButton").style.visibility = "hidden";
    cost = document.getElementById("totalCost").innerHTML;
    document.getElementById("totalCost").innerHTML = "Total Costs: $" + Math.round(((cost * document.getElementById("amountOfSnacks").value) + ((cost * document.getElementById("amountOfSnacks").value)*.029) + .30) * 100) / 100 ;
    document.getElementById("flatDiv").innerHTML = "Flat Cost: $" + document.getElementById("amountOfSnacks").value * cost;

    // Round to 2 decimal places
    let ccFee = ((((cost * document.getElementById("amountOfSnacks").value)*.029)) + .3).toFixed(2);
    document.getElementById("taxDiv").innerHTML = "CC Fee: $" + ccFee;
    // document.getElementById("testDiv").style.visibility = "hidden";
    // document.getElementById("amountDiv").style.visibility = "hidden";
    document.getElementById("testDiv").style.display = "none"; // Removes the html element for better spacing
    document.getElementById("amountDiv").style.display = "none";

    // Redisplay removed elements
    document.getElementById("taxDiv").style.display = "flex";
    document.getElementById("flatDiv").style.display = "flex";
    document.getElementById("totalCost").style.display = "flex";

    // let mediaQuery = window.matchMedia('(min-width: 600px)');
    // if (mediaQuery.matches) {
    //   document.getElementById("paymentDiv").style.width = "300px";
    //   document.getElementById("credit-info").style.width = "100%;";
    // }

    }


 console.log("Pressed");
}

function buttonPlus(){
    if(document.getElementById("amountOfSnacks").value < 4){
    document.getElementById("amountOfSnacks").value = parseInt(document.getElementById("amountOfSnacks").value) + 1;
    }

}
function buttonMinus(){
    if(document.getElementById("amountOfSnacks").value > 1){
        document.getElementById("amountOfSnacks").value = parseInt(document.getElementById("amountOfSnacks").value) - 1;
    }

}
function backButtonPress(){
    document.getElementById("paymentDiv").style.visibility = "hidden";
    document.getElementById("inputDiv").style.visibility = "visible";
}



const isNumericInput = (event) => {
    const key = event.keyCode;
    return ((key >= 48 && key <= 57) || // Allow number line
        (key >= 96 && key <= 105) // Allow number pad
    );
};

const isModifierKey = (event) => {
    const key = event.keyCode;
    return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
        (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
        (key > 36 && key < 41) || // Allow left, up, right, down
        (
            // Allow Ctrl/Command + A,C,V,X,Z
            (event.ctrlKey === true || event.metaKey === true) &&
            (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
        )
};

const enforceFormat = (event) => {
    // Input must be of a valid number format or a modifier key, and not longer than ten digits
    if(!isNumericInput(event) && !isModifierKey(event)){
        event.preventDefault();
    }
};

const formatToPhone = (event) => {
    if(isModifierKey(event)) {return;}

    // I am lazy and don't like to type things more than once
    const target = event.target;
    const input = target.value.replace(/\D/g,'').substring(0,10); // First ten digits of input only
    const zip = input.substring(0,3);
    const middle = input.substring(3,6);
    const last = input.substring(6,10);

    if(input.length > 6){target.value = `(${zip}) ${middle} - ${last}`;}
    else if(input.length > 3){target.value = `(${zip}) ${middle}`;}
    else if(input.length > 0){target.value = `(${zip}`;}
};



document.addEventListener("DOMContentLoaded", function(event) {
    const inputElement = document.getElementById('phone');
    inputElement.addEventListener('keydown',enforceFormat);
    inputElement.addEventListener('keyup',formatToPhone);
    //document.getElementById("statusOfKiosk").style.visibility = "hidden";
    document.getElementById("amountOfSnacks").readOnly = true;
    document.getElementById("totalCost").style.visibility = "hidden";
    document.getElementById("amountOfSnacks").value = "1";
    document.getElementById("paymentDiv").style.visibility = "hidden";
    document.getElementById("inputDiv").style.visibility = "visible";
    document.getElementById("minus").addEventListener("click",buttonMinus);
    document.getElementById("plus").addEventListener("click",buttonPlus);
    textBoxListener = document.getElementById("amountOfSnacks").addEventListener("change",setSnack);
    window.addEventListener("popstate", backButtonPress);
    document.getElementById("purchaseButton").addEventListener("click",buttonPress);

    document.getElementById("taxDiv").style.display = "none";
    document.getElementById("flatDiv").style.display = "none";
    document.getElementById("totalCost").style.display = "none";
})
