
/*Background popup settings: */
let popupBG = document.getElementById("back2");

/* popup settings> */
let popupContainer = document.getElementById("popupOperacion");
let titleOp = document.getElementById("operationTitle");

let popupContainer2 = document.getElementById("popupOperacion2");
let titleOp2 = document.getElementById("operationTitle2");

// constant values:
let displayPriceB = document.getElementById("precio");
let displayPriceS = document.getElementById("precio2");
let price = parseFloat(displayPriceB.value);

/* Slider menu*/
const sliders = [...document.querySelectorAll('.apartado1_1')]; /*array of elements with same class */
const arrowBefore = document.querySelector('#before');
const arrowNext = document.querySelector('#next');
let value;
arrowNext.addEventListener('click', ()=>changeSlide(1));
arrowBefore.addEventListener('click', ()=>changeSlide(-1));



/*===================================================================================================================
===================================Opening AJAX session: ========================================================================== */

function ajaxObject(){
    var xmlhttp=false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch(E){
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest!= 'undefined'){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}


//====================================================================================================================

/* changing sliders with data-id number */
//onclick function

function changeSlide(change)
{
    const currentElement = Number(document.querySelector('.showApartado').dataset.id );
    value = currentElement;
    value += change;

    if(value == 0 || value == sliders.length+1){
        if(value==0){
            value = sliders.length;
        }
        else{
            value = 1;
        }
    }
    sliders[currentElement-1].classList.toggle('showApartado');      //put the class with opacity "1" to an element
    sliders[value-1].classList.toggle('showApartado');      //put the class with opacity "1" to an element

}


function popupOpen2(investment,sellPrice,_buyPrice){

    // Funcion "sendToForm()" procesado por ajax:
    sendToForm2(sellPrice);

    // Obtain the product's name:
    document.getElementById("prName2").value = investment;

    /*scroll to top:*/  
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    
    titleOp2.innerHTML = investment;
    popupContainer2.classList.toggle("open-popup2");

    popupBG.classList.toggle("openSettings2");

}
function popupClose2(){

    document.getElementById("cantidad2").value = 1;
    displayPriceS.innerHTML = 0;

    popupContainer2.classList.remove("open-popup2");
    popupBG.classList.remove("openSettings2");
}

function popupOpen(investment,_sellPrice,buyPrice){

    // Funcion "sendToForm()" procesado por ajax:
    sendToForm(buyPrice);

    // Obtain the product's name:
    document.getElementById("prName").value = investment;

    /*scroll to top:  */
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    
    titleOp.innerHTML = investment;
    popupContainer.classList.toggle("open-popup");

    popupBG.classList.toggle("openSettings2");

}

//================Sending form data and xmlhttp request====================================

function sendToForm(buyPrice){
    let value = document.getElementById(buyPrice).value;
    ajax = ajaxObject();
    ajax.open("POST", "GM_AppManagement.php", true );
    ajax.onreadystatechange = function() {
        if(ajax.readyState==4) {
            document.getElementById("precio").value = value;

        }
    }
    ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    ajax.send( "productPrice="+value );
}

function sendToForm2(sellPrice){
    let value = document.getElementById(sellPrice).value;
    ajax = ajaxObject();
    ajax.open("POST", "GM_AppManagement.php", true );
    ajax.onreadystatechange = function() {
        if(ajax.readyState==4) {
            document.getElementById("precio2").value = value;

        }
    }
    ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    ajax.send( "productPrice="+value );
}

//========================================================


function popupClose(){

    /* dejar valores en 0 */
    document.getElementById("cantidad").value = 1;
    displayPriceB.innerHTML = 0;

    popupContainer.classList.remove("open-popup");
    popupBG.classList.remove("openSettings2");
}

function add(precio) {
  
    let val = document.getElementById("cantidad").value;
     val++;
    
    document.getElementById("cantidad").value = val;
    displayPriceB.innerHTML = val;

    // Update the total price acording to the amount of product:
    let buyPrice = document.getElementById(precio).value;
    if (val <= 2){
        buyPrice = (buyPrice*val);
    }
    else{
        buyPrice = (buyPrice*val)/(val-1);
    }
    document.getElementById(precio).value = buyPrice.toFixed(4);

 }
 
 function sub(precio) {
   
    let val = document.getElementById("cantidad").value;
    let val2 = (val)/(val-1);

    val--;
    if (val <= 0){
        val = 0;
    }
    document.getElementById("cantidad").value = val;
    displayPriceB.innerHTML = val;

    // Update the total price acording to the amount of product:

    let sellPrice = document.getElementById(precio).value;
    if(val >= 1){
        sellPrice = sellPrice/val2 ;
    }
    document.getElementById(precio).value = sellPrice.toFixed(4);

}

function add2(precio) {
  
   let val = document.getElementById("cantidad2").value;
    val++;
   
   document.getElementById("cantidad2").value = val;
   displayPriceS.innerHTML = val;

    // Update the total price acording to the amount of product:
    let buyPrice = document.getElementById(precio).value;
    if (val <= 2){
        buyPrice = (buyPrice*val);
    }
    else{
        buyPrice = (buyPrice*val)/(val-1);
    }
    document.getElementById(precio).value = buyPrice.toFixed(4);

}

function sub2(precio) {
  
    let val = document.getElementById("cantidad2").value;
    let val2 = (val)/(val-1);
     val--;
     if (val < 0){
        val = 0;
    }
     document.getElementById("cantidad2").value = val;
     displayPriceS.innerHTML = val;


    // Update the total price acording to the amount of product:

    let sellPrice = document.getElementById(precio).value;
    if(val >= 1){
        sellPrice = sellPrice/val2 ;
    }
    document.getElementById(precio).value = sellPrice.toFixed(4);

  }








