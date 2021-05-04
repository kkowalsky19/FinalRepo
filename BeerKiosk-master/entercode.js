function enter0(){
    document.getElementById("codeInput").value = document.getElementById("codeInput").value + "0";
}
function enter1(){
    document.getElementById("codeInput").value = document.getElementById("codeInput").value + "1";
}
function enter2(){
    document.getElementById("codeInput").value = document.getElementById("codeInput").value + "2";
}
function enter3(){
    document.getElementById("codeInput").value = document.getElementById("codeInput").value + "3";
}
function enter4(){
    document.getElementById("codeInput").value = document.getElementById("codeInput").value + "4";
}
function enter5(){
    document.getElementById("codeInput").value = document.getElementById("codeInput").value + "5";
}
function enter6(){
    document.getElementById("codeInput").value = document.getElementById("codeInput").value + "6";
}
function enter7(){
    document.getElementById("codeInput").value = document.getElementById("codeInput").value + "7";
}
function enter8(){
    document.getElementById("codeInput").value = document.getElementById("codeInput").value + "8";
}
function enter9(){
    document.getElementById("codeInput").value = document.getElementById("codeInput").value + "9";
}
function clearUs(){
    document.getElementById("codeInput").value = "";
}

document.addEventListener("DOMContentLoaded", function(event) {
    document.getElementById("0").addEventListener("click",enter0);
    document.getElementById("1").addEventListener("click",enter1);
    document.getElementById("2").addEventListener("click",enter2);
    document.getElementById("3").addEventListener("click",enter3);
    document.getElementById("4").addEventListener("click",enter4);
    document.getElementById("5").addEventListener("click",enter5);
    document.getElementById("6").addEventListener("click",enter6);
    document.getElementById("7").addEventListener("click",enter7);
    document.getElementById("8").addEventListener("click",enter8);
    document.getElementById("9").addEventListener("click",enter9);
    document.getElementById("enter").addEventListener("click",clearUs);
    document.getElementById("clear").addEventListener("click",clearUs);
})