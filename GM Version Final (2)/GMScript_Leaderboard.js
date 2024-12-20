let popupElement =  document.getElementById("rankingList");
let apartado2 = document.getElementById("ToDivisas");
let apartado3 = document.getElementById("ToAcciones");
let apartado4 = document.getElementById("ToMaterias");

let page = document.getElementById("back2");
let page2 = document.getElementById("bodySettings");
let page3 = document.getElementById("backSettings");
let nav = document.getElementById("mainid");
let bottomPag = document.getElementById("ToPieDePag");


function openInvestments()
{
    document.getElementById("rankingT").disabled = false;
    popupElement.classList.remove("rankingList2");

    /* closing page content */
    apartado2.classList.remove("closeAp2");
    apartado2.classList.remove("changeBack2");

    apartado3.classList.remove("closeAp3");
    apartado3.classList.remove("changeBack2");

    apartado4.classList.remove("closeAp4");
    apartado4.classList.remove("changeBack2");

    deletePageSettings();

}

function deletePageSettings()
{
    let page = document.getElementById("back2");
    let page2 = document.getElementById("bodySettings");
    let page3 = document.getElementById("backSettings");
    let nav = document.getElementById("mainid");
    let bottomPag = document.getElementById("ToPieDePag");

    page.classList.remove('changeBack2');
    page2.classList.remove('changeBack2');
    page3.classList.remove('changeBack2');
    nav.classList.remove('changeBack2');
    bottomPag.classList.remove('changeBack2');

}


function openRanking()
{
    document.getElementById("rankingT").disabled = true;

    /* opening the leaderboard */
    popupElement.classList.toggle("rankingList2");

    /* closing page content */
    apartado2.classList.toggle("closeAp2");

    apartado3.classList.toggle("closeAp3");

    apartado4.classList.toggle("closeAp4");

    changePageSettings();

}


function changePageSettings()
{

    /* Modify page */

    page.classList.toggle("changeBack2");
    page2.classList.toggle("changeBack2");
    page3.classList.toggle("changeBack2");
    apartado2.classList.toggle("changeBack2");
    apartado3.classList.toggle("changeBack2");
    apartado4.classList.toggle("changeBack2");
    nav.classList.toggle("changeBack2");
    bottomPag.classList.toggle("changeBack2");
}