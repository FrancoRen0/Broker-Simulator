
let popupContainer = document.getElementById("popupDetails");
let closedPos = document.getElementById("IdcartTable2");
let openPos = document.getElementById("IdCartTable");
let intervalID = 0;

function openDetails(pr_descr, pr_price, pr_qty, operation)
{
    // Clear the prices given:
    if(intervalID != 0){
        clearInterval(intervalID);
    }

    popupContainer.classList.toggle("popupDetailsOpen");

    let productName = document.getElementById(pr_descr).value;      //products name from table
    let productValue = document.getElementById(pr_price).value;     //products total value from table
    let productQty = document.getElementById(pr_qty).value;         //products total quantity from table

    document.getElementById("detailsTitle").value = productName ;
    document.getElementById("detailsPrice").value = productValue ;
    document.getElementById("initialRate").value = (productValue/productQty).toFixed(4);   // user's initial currency rate rate

    //initializing first random values:
    displayValue(productName,productQty, operation);

    //Updating product values:
    intervalID = setInterval(function() {displayValue(productName,productQty, operation)}, 5500);

}



/* 1) Function to display current exchange rates */
function displayValue(productName,productQty, operation) {

    let priceId = "currentPrice";

    /* DIVISAS/ CURRENCIES */
    if(productName == "EUR/USD"){
        operations(0.9800, 0.9999, 4, priceId,productQty, operation);
    }
    if(productName == "USD/JPY"){
        operations(120.65, 180.65,2, priceId,productQty, operation);
    }
    //-------------- GBPUSD: ------------
    if(productName == "GBP/USD"){
        operations( 1.0, 1.3, 4, priceId,productQty, operation);
    }
    //-------------- USD/TRY: ------------
    if(productName == "USD/TRY"){
        operations( 18.0, 24.0, 4, priceId,productQty, operation);
    }
    //-------------- USD/CAD: ------------
    if(productName == "USD/CAD"){
        operations( 1.0, 1.9, 4, priceId,productQty, operation);
    }
    //-------------- EUR/JPY: ------------
    if(productName == "EUR/JPY"){
        operations( 135.02, 144.50, 2, priceId,productQty, operation);
    }
    //-------------- AUD/USD: ------------
    if(productName == "AUD/USD"){
        operations( 0.3000, 0.8000, 4, priceId,productQty, operation);
    }
    //-------------- EUR/GBP: ------------
    if(productName == "EUR/GBP"){
        operations( 0.57 , 0.85, 4, priceId,productQty, operation);
    }
    //-------------- GBP/NZD: ------------
    if(productName == "GBP/NZD"){
        operations( 1.72 , 3.62, 4, priceId,productQty, operation);
    }
    //-------------- GBP/CAD: ------------
    if(productName == "GBP/CAD"){
        operations( 1.49 , 2.60, 4, priceId,productQty, operation);
    }
    //-------------- USD/RUB: ------------
    if(productName == "USD/RUB"){
        operations( 23.22 , 120, 4, priceId,productQty, operation);
    }

    /* STOCK MARKET */

    //-------------- TECENT: ------------
    if(productName == "TECENT"){
        operations( 100.20 , 704, 2, priceId,productQty, operation);
    }
    //-------------- Denso: ------------
    if(productName == "Denso"){
        operations( 12.33 , 61.04, 2, priceId,productQty, operation);
    }
    //-------------- Xiaomi: ------------
    if(productName == "Xiaomi"){
        operations( 8.20 , 32.12, 2, priceId,productQty, operation);
    }
    //-------------- Bank of E. Asia: ------------
    if(productName == "Bank_of_E_Asia"){
        operations( 8.00 , 48, 2, priceId,productQty, operation);
    }
    //-------------- Porsche AG: ------------
    if(productName == "PorscheAG"){
        operations( 42.10 , 124.43, 2, priceId,productQty, operation);
    }
    //-------------- Apple: ------------
    if(productName == "Apple"){
        operations( 45.20 , 432.21, 2, priceId,productQty, operation);
    }
    //-------------- Tesla: ------------
    if(productName == "Tesla"){
        operations( 100 , 532.67, 2, priceId,productQty, operation);
    }
    //-------------- Colruyt: ------------
    if(productName == "Colruyt"){
        operations( 8.36 , 64.12, 2, priceId,productQty, operation);
    }
    //-------------- NIO: ------------
    if(productName == "NIO"){
        operations( 1.60 , 61.52, 2, priceId,productQty, operation);
    }
    //-------------- Alphabet: ------------
    if(productName == "Alphabet"){
        operations( 100 , 532.67, 2, priceId,productQty, operation);
    }
    //-------------- Amazon: ------------
    if(productName == "Amazon"){
        operations( 2.02 , 170.07, 2, priceId,productQty, operation);
    }

    /*COMMODITIES */

    //-------------- Petroleo: ------------
    if(productName == "Petroleo"){
        operations( 10.48 , 173.20, 2, priceId,productQty, operation);
    }
    //-------------- Plata: ------------
    if(productName == "Plata"){
        operations( 2.50 , 50, 3, priceId,productQty, operation);
    }
    //-------------- Petroleo Brent: ------------
    if(productName == "Petroleo_Brent"){
        operations( 12.72 , 136.36, 2, priceId,productQty, operation);
    }
    //-------------- Oro: ------------
    if(productName == "Oro"){
        operations( 213.01 , 1932.50, 2, priceId,productQty, operation);
    }
    //-------------- Azucar: ------------
    if(productName == "Azucar"){
        operations( 3.27, 52.06, 2, priceId,productQty, operation);
    }
    //-------------- Cobre: ------------
    if(productName == "Cobre"){
        operations( 4550 , 10263, 2, priceId,productQty, operation);
    }
    //-------------- Paladio: ------------
    if(productName == "Paladio"){
        operations( 168 , 2910, 2, priceId,productQty, operation);
    }
    //-------------- cafe: ------------
    if(productName == "Cafe"){
        operations( 43.61, 294.97, 2, priceId,productQty, operation);
    }
    //-------------- Gas Natural: ------------
    if(productName == "Gas_Natural"){
        operations( 1.22 , 13.75, 2, priceId,productQty, operation);
    }
    //-------------- Gasolina: ------------
    if(productName == "Gasolina"){
        operations( 0.575 , 3.857, 3, priceId,productQty, operation);
    }
    //-------------- Soja: ------------
    if(productName == "Soja"){
        operations( 419.00, 1742, 2, priceId,productQty, operation);
    }
    
}

// 2)-->
function operations(min, max, decimals, priceId,productQty, operation){

    //-------- Setting prices every 5.5 seconds: ---------

    let qty = document.getElementById(productQty).value;                //quantity of product
	let priceRate = getRandomFloat(min, max, decimals);                 //random product's rate
    let Laverage = (priceRate*qty)*(1/5) ;                               //Laverage 1:5
    let totalPrice = (priceRate*qty) + Laverage;                        // total price

    document.getElementById("priceRate").value = priceRate;         //current product's rate
	document.getElementById(priceId).value = (totalPrice).toFixed(3);            //priceID = "currentPrice"


    //profit / loss calculation:
    profitLoss(productQty, operation);
    
}

// 3)-->
function getRandomFloat(min, max, decimals) {
    const str = (Math.random() * (max - min) + min).toFixed(decimals);
  
    return parseFloat(str);
  }

    // Profit / Loss calculation:

function profitLoss(productQty, operation)
{
    let initial_rate = document.getElementById("initialRate").value; 
    //let qty = document.getElementById(productQty).value;                //quantity of product
    let updatedPriceRate = document.getElementById("priceRate").value;  //current price rate
    let updatedPrice = document.getElementById("currentPrice").value;  //current price with lavarage
    let userPrice = document.getElementById("detailsPrice").value;     // User price
    let operation1 = String(operation);                                        // operation type: sell/buy

    let res = initial_rate - updatedPriceRate;
    res = res.toFixed(3)

    if(operation1 == "buy")
    {
        //if price rising when BUY
        if( res < 0 ){

            let buy1 = 0;
            buy1 = updatedPrice - userPrice;
            resultBuy = buy1.toFixed(2);
            document.getElementById("profitLoss").value = resultBuy;
        }
        //if price drops when BUY
        else if( res > 0 ){

            let buy2 = 0;
            buy2 =  -1*(userPrice - updatedPrice);
            if(buy2 > 0){
                buy2 = -1*(buy2);
            }
            resultBuy = buy2.toFixed(2);
            document.getElementById("profitLoss").value = resultBuy;
        }
    }
    else if(operation1 == "sell")
    {
       //if price rising when SELL --> 'loss'
        if( res < 0){
            
            let sell1 = 0;
            sell1 = userPrice - updatedPrice;
            resultSell = sell1.toFixed(2);
            document.getElementById("profitLoss").value = resultSell;
        }
        //if price drops when SELL --> 'profit'
        else if( res > 0){
            
            let sell2 = 0;
            sell2 = -1*(updatedPrice - userPrice);
            if(sell2 < 0){ //if its close to user price
                sell2 = -1*(sell2);
            }
            resultSell = sell2.toFixed(2);
            document.getElementById("profitLoss").value = resultSell;
        }
    }

}

function popupClose()
{

    document.getElementById("detailsPrice").value = 0;
    document.getElementById("currentPrice").value = 0;
    document.getElementById("priceRate").value = 0;
    document.getElementById("profitLoss").value = 0;

    //closing displayValue() prices=0
    clearInterval(intervalID);

    popupContainer.classList.remove("popupDetailsOpen");
}

                                    //opened positions/closed positions button
function showClosedP()
{
    closedPos.classList.toggle("openCartTable2");  //abre posiciones cerradas
    openPos.classList.toggle("openCartTable");  //a pesar del nombre, oculta a la lista de posiciones abiertas

    document.getElementById("closeButton").disabled = true;
    document.getElementById("openButton").disabled = false;

}

function showOpenP()
{   
    openPos.classList.toggle("openCartTable"); //abre posiciones abiertas
    closedPos.classList.toggle("openCartTable2"); // oculta posiciones cerradas

    document.getElementById("openButton").disabled = true;
    document.getElementById("closeButton").disabled = false;

}
