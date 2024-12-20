
/*function call: */

main();

//========================================================================

function main(){

    startingPrice();

    //initializing values:
    displayValue();

    //values displayed every 5.5 sec:
    setInterval(displayValue, 5500);

}

/*===========cotizaciones aca: ============================ */


function startingPrice(){

    //EURUSD:
    let get1 = getRandomFloat(0.9800,0.9835,4);
    let price1 = document.getElementById('openingPrice1').value = Number(get1);
    //USDJPY
    let get2 = getRandomFloat(120.65, 180.65,2);
    let price2 = document.getElementById('openingPrice2').value = Number(get2);
    //GBPUSD
    let get3 = getRandomFloat(1.0, 1.3, 4);
    let price3 = document.getElementById('openingPrice3').value = Number(get3);
    //USD/TRY
    let get4 = getRandomFloat(18.0, 24.0, 4);
    let price4 = document.getElementById('openingPrice4').value = Number(get4);
    
    //USD/CAD
    let get5 = getRandomFloat(1.0, 1.9, 4);
    let price5 = document.getElementById('openingPrice5').value = Number(get5);
    //EUR/JPY
    let get6 = getRandomFloat(135.02, 144.50, 2);
    let price6 = document.getElementById('openingPrice6').value = Number(get6);
    //AUD/USD
    let get7 = getRandomFloat( 0.3000, 0.8000, 4);
    let price7 = document.getElementById('openingPrice7').value = Number(get7);
    //-------------- EUR/GBP: ------------
    let get8 = getRandomFloat(  0.57 , 0.85, 4);
    let price8 = document.getElementById('openingPrice8').value = Number(get8);
    //-------------- GBP/NZD: ------------
    let get9 = getRandomFloat( 1.72 , 3.62, 4);
    let price9 = document.getElementById('openingPrice9').value = Number(get9);
    //-------------- GBP/CAD: ------------
    let get10 = getRandomFloat(1.49 , 2.60, 4);
    let price10 = document.getElementById('openingPrice10').value = Number(get10);
    //-------------- USD/RUB: ------------
    let get11 = getRandomFloat(23.22 , 120, 4);
    let price11 = document.getElementById('openingPrice11').value = Number(get11);


    //-------------- TECENT: ------------
    let get12 = getRandomFloat(100.20 , 704, 2);
    let price12 = document.getElementById('openingPrice12').value = Number(get12);
    //-------------- Denso: ------------
    let get13 = getRandomFloat(12.33 , 61.04, 2);
    let price13 = document.getElementById('openingPrice13').value = Number(get13);
    //-------------- Xiaomi: ------------
    let get14 = getRandomFloat(8.20 , 32.12, 2);
    let price14 = document.getElementById('openingPrice14').value = Number(get14);
    //-------------- Bank of E. Asia: ------------
    let get15 = getRandomFloat(8.00 , 48, 2);
    let price15 = document.getElementById('openingPrice15').value = Number(get15);
    //-------------- Porsche AG: ------------
    let get16 = getRandomFloat(42.10 , 124.43, 2);
    let price16 = document.getElementById('openingPrice16').value = Number(get16);
    //-------------- Apple: ------------
    let get17 = getRandomFloat(45.20 , 432.21, 2);
    let price17 = document.getElementById('openingPrice17').value = Number(get17);
    //-------------- Tesla: ------------
    let get18 = getRandomFloat(100 , 532.67, 2);
    let price18 = document.getElementById('openingPrice18').value = Number(get18);
    //-------------- Colruyt: ------------
    let get19 = getRandomFloat(8.36 , 64.12, 2);
    let price19 = document.getElementById('openingPrice19').value = Number(get19);
    //-------------- NIO: ------------
    let get20 = getRandomFloat(1.60 , 61.52, 2);
    let price20 = document.getElementById('openingPrice20').value = Number(get20);
    //-------------- Alphabet: ------------
    let get21 = getRandomFloat(100 , 532.67, 2);
    let price21 = document.getElementById('openingPrice21').value = Number(get21);
    //-------------- Amazon: ------------
    let get22 = getRandomFloat(2.02 , 170.07, 2);
    let price22 = document.getElementById('openingPrice22').value = Number(get22);



    //-------------- Petroleo: ------------
    let get23 = getRandomFloat(10.48 , 173.20, 2);
    let price23 = document.getElementById('openingPrice23').value = Number(get23);
    //-------------- Plata: ------------
    let get24 = getRandomFloat(2.50 , 50, 3);
    let price24 = document.getElementById('openingPrice24').value = Number(get24);
    //-------------- Petroleo Brent: ------------
    let get25 = getRandomFloat(12.72 , 136.36, 2);
    let price25 = document.getElementById('openingPrice25').value = Number(get25);
    //-------------- Oro: ------------
    let get26 = getRandomFloat(213.01 , 1932.50, 2);
    let price26 = document.getElementById('openingPrice26').value = Number(get26);
    //-------------- Azucar: ------------
    let get27 = getRandomFloat(3.27, 52.06, 2);
    let price27 = document.getElementById('openingPrice27').value = Number(get27);
    //-------------- Cobre: ------------
    let get28 = getRandomFloat(4550 , 10263, 2);
    let price28 = document.getElementById('openingPrice28').value = Number(get28);
    //-------------- Paladio: ------------
    let get29 = getRandomFloat(168 , 2910, 2);
    let price29 = document.getElementById('openingPrice29').value = Number(get29);
    //-------------- cafe: ------------
    let get30 = getRandomFloat(43.61, 294.97, 2);
    let price30 = document.getElementById('openingPrice30').value = Number(get30);
    //-------------- Gas Natural: ------------
    let get31 = getRandomFloat(1.22 , 13.75, 2);
    let price31 = document.getElementById('openingPrice31').value = Number(get31);
    //-------------- Gasolina: ------------
    let get32 = getRandomFloat(0.575 , 3.857, 3);
    let price32 = document.getElementById('openingPrice32').value = Number(get32);
    //-------------- Soja: ------------
    let get33 = getRandomFloat(419.00, 1742, 2);
    let price33 = document.getElementById('openingPrice33').value = Number(get33);
    
}


function operations(min,max,decimals,increment,sell,buy, openingprice){

    //-------- Setting prices every 5.5 seconds: ---------
    let opPrice = document.getElementById(openingprice).value;
    opPrice = Number(opPrice);

	sellitem = getRandomFloat(min, max, decimals);
	document.getElementById(sell).value = sellitem ;
    //check if sell under opening value or not (RED/GREEN):
    
    if( sellitem > opPrice  ){
        document.getElementById(sell).style.color = "red";
    }
    else if(sellitem == opPrice){
        document.getElementById(sell).style.color = "black";
    }
    else if(sellitem < opPrice){
        document.getElementById(sell).style.color = "lightgreen";
    }

    aux = sellitem + increment;
    buyitem = aux.toFixed(decimals);
	document.getElementById(buy).value = buyitem ;

    //check if buy its under opening value or not (RED/GREEN):

    if( buyitem < opPrice ){
        document.getElementById(buy).style.color = "red";
    }
    else if(buyitem == opPrice){
        document.getElementById(buy).style.color = "black";
    }
    else if( buyitem > opPrice){
        document.getElementById(buy).style.color = "lightgreen";
    }
    //.....
}

/*                  ----No usar---- modificacion arriba
function buyOperations(min,max,decimals,buy){

	buyitem = getRandomFloat(min, max, decimals);
	document.getElementById(buy).innerHTML = buyitem ;

}
*/

function displayValue() {


    //DIVISAS

    //-------------- EURUSD: ------------
    operations(0.9800,0.9835,4, 0.0001,"s_eurusd","b_eurusd", "openingPrice1");
    //-------------- USDJPY: ------------
    operations(120.65, 180.65,2, 0.01,"s_usdjpy","b_usdjpy", "openingPrice2");
    //-------------- GBPUSD: ------------
    operations( 1.0, 1.3, 4, 0.0003, "s_gbpusd", "b_gbpusd","openingPrice3");
    //-------------- USD/TRY: ------------
    operations( 18.0, 24.0, 4, 0.1133, "s_usdtry", "b_usdtry","openingPrice4");
    //-------------- USD/CAD: ------------
    operations( 1.0, 1.9, 4, 0.0004, "s_usdcad", "b_usdcad","openingPrice5");
    //-------------- EUR/JPY: ------------
    operations( 135.02, 144.50, 2, 0.08, "s_eurjpy", "b_eurjpy","openingPrice6");
    //-------------- AUD/USD: ------------
    operations( 0.3000, 0.8000, 4, 0.0002, "s_audusd", "b_audusd","openingPrice7");
    //-------------- EUR/GBP: ------------
    operations( 0.57 , 0.85, 4, 0.0006, "s_eurgbp", "b_eurgbp","openingPrice8");
    //-------------- GBP/NZD: ------------
    operations( 1.72 , 3.62, 4, 0.0014, "s_gbpnzd", "b_gbpnzd","openingPrice9");
    //-------------- GBP/CAD: ------------
    operations( 1.49 , 2.60, 4, 0.0004, "s_gbpcad", "b_gbpcad","openingPrice10");
    //-------------- USD/RUB: ------------
    operations( 23.22 , 120, 4, 0.0012, "s_usdrub", "b_usdrub","openingPrice11");


    //ACCIONES

    //-------------- TECENT: ------------
    operations(100.20 , 704, 2, 1,"s_tecent","b_tecent","openingPrice12");
    //-------------- Denso: ------------
    operations(12.33 , 61.04, 2, 0.03, "s_denso", "b_denso","openingPrice13");
    //-------------- Xiaomi: ------------
    operations(8.20 , 32.12, 2, 0.03, "s_xiaomi", "b_xiaomi","openingPrice14");
    //-------------- Bank of E. Asia: ------------
    operations(8.00 , 48, 2, 0.6, "s_bea", "b_bea","openingPrice15");
    //-------------- Porsche AG: ------------
    operations(42.10 , 124.43, 2, 0.10, "s_porsche", "b_porsche","openingPrice16");
    //-------------- Apple: ------------
    operations(45.20 , 432.21, 2, 0.10, "s_apple", "b_apple","openingPrice17");
    //-------------- Tesla: ------------
    operations(100 , 532.67, 2, 0.021,"s_tesla","b_tesla","openingPrice18");
    //-------------- Colruyt: ------------
    operations(8.36 , 64.12, 2, 0.04,"s_colruyt","b_colruyt","openingPrice19");
    //-------------- NIO: ------------
    operations(1.60 , 61.52, 2, 0.12, "s_nio", "b_nio","openingPrice20");
    //-------------- Alphabet: ------------
    operations(100 , 532.67, 2, 0.54, "s_alphabet", "b_alphabet","openingPrice21");
    //-------------- Amazon: ------------
    operations(2.02 , 170.07, 2, 0.072, "s_amazon", "b_amazon","openingPrice22");


    //MATERIAS PRIMAS

    //-------------- Petroleo: ------------
    operations(10.48 , 173.20, 2, 0.9,"s_oil","b_oil","openingPrice23");
    //-------------- Plata: ------------
    operations(2.50 , 50, 3, 0.012,"s_plata","b_plata","openingPrice24");
    //-------------- Petroleo Brent: ------------
    operations(12.72 , 136.36, 2, 0.010,"s_brent","b_brent","openingPrice25");
    //-------------- Oro: ------------
    operations(213.01 , 1932.50, 2, 0.20, "s_oro", "b_oro","openingPrice26");
    //-------------- Azucar: ------------
    operations(3.27, 52.06, 2, 0.085, "s_azucar", "b_azucar","openingPrice27");
    //-------------- Cobre: ------------
    operations(4550 , 10263, 2, 1.48, "s_cobre", "b_cobre","openingPrice28");
    //-------------- Paladio: ------------
    operations(168 , 2910, 2, 0.954, "s_paladio", "b_paladio","openingPrice29");
    //-------------- cafe: ------------
    operations(43.61, 294.97, 2, 1.02, "s_cafe", "b_cafe","openingPrice30");
    //-------------- Gas Natural: ------------
    operations(1.22 , 13.75, 2, 0.077, "s_gasn", "b_gasn","openingPrice31");
    //-------------- Gasolina: ------------
    operations(0.575 , 3.857, 3, 0.011, "s_gasolina", "b_gasolina","openingPrice32");
    //-------------- Soja: ------------
    operations(419.00, 1742, 2, 0.98, "s_soja", "b_soja","openingPrice33");
    
}

// creating a random number: 

function getRandomFloat(min, max, decimals) {

    let str = (Math.random() * (max - min) + min).toFixed(decimals);
    str = parseFloat(str); 

  return str;
}

//---Window alert---

function showAlert(pr_name,price){

    let pr_value = document.getElementById(price).value;
    let message = "opening value: "+ pr_value;
    window.alert(pr_name + "\n" + message);
}



//-------------------------------------------AJAX-------------------------------

//-----AJAX: preventing the page to submit-----


/*
$(document).ready(function() {
    $("form").submit(function(event) {
        event.preventDefault()

        var s_price = document.getElementById("s_eurusd").value
        var b_price = document.getElementById("b_eurusd").value

        $.post("GM_AppManagement.php", {s_price:"s_eurusd", b_price:"b_eurusd"}, function(data){
            console.log(data)
        } )

    })
})
*/





