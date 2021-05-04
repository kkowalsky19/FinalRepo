var ounce1;
var ounce2;
var pump1Slide;
var pump2Slide;

//called every time pour is hit for the first drink
function pour1(event){
  // change to pouring screen while pours
  //alert("1");
  if(document.getElementById("1pour").innerHTML != "Pouring..."){
    garage.setPump1("true");
    document.getElementById("1pour").innerHTML = "Pouring...";
    setTimeout(function(){garage.setPump1("false");document.getElementById("1pour").innerHTML = "Pour";},900 * document.getElementById("drink1Amount").innerHTML);
  }


}

//called every time pour is hit for the second drink
function pour2(event){
  //alert("2");
  garage.setPump2("true");
  document.getElementById("2pour").innerHTML = "Pouring...";
  setTimeout(function(){garage.setPump2("false");document.getElementById("2pour").innerHTML = "Pour";},900 * document.getElementById("drink2Amount").innerHTML);
  //change to pouring screen while pours
}

function stateUpdate(newState) {

}

//called whenever the slide for drink 1 is moved
function dSlide1(event){
      ounce1.innerHTML = pump1Slide.value;
    }

//called whenever the slide for drink2 is moved
    function dSlide2(event){
          ounce2.innerHTML = pump2Slide.value;
        }

    function drink1Slide(){
        document.getElementById("drink1Amount").innerHTML = document.getElementById("slideDrink1").value;
    }

    function drink2Slide(){
      document.getElementById("drink2Amount").innerHTML = pump2Slide.value;
    }

document.addEventListener("DOMContentLoaded", function(event) {
    ounce1 = document.getElementById("drink1Amount")
    ounce2 = document.getElementById("drink2Amount")
    pump1Slide = document.getElementById("slideDrink1")
    pump2Slide = document.getElementById("slideDrink2")
    garage.setStateChangeListener(stateUpdate)
    garage.setup()
    //event handlers
    pump1Slide.addEventListener("change",drink1Slide)
    pump2Slide.addEventListener("change",drink2Slide)
    document.getElementById("1pour").addEventListener("click",pour1)
    document.getElementById("2pour").addEventListener("click",pour2)
    document.getElementById("bothpour").addEventListener("click",pour2)
    document.getElementById("bothpour").addEventListener("click",pour1)
  })