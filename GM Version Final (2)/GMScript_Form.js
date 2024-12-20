
let Ncheck = document.getElementById("nameError");
let Mcheck = document.getElementById("mailError");
let Pcheck = document.getElementById("psswError");
let P2check = document.getElementById("psswError2");
let validating;

function validName(){

    let name = document.getElementById('iname').value;

    if(name.length > 20 ){
        Ncheck.innerHTML = "*name must be less than 20 characters";
        return false;
    }
    if(name.match(/\d+/g)){
        Ncheck.innerHTML = "*name must contain letters only";
        return false;
    }
    else{
        Ncheck.innerHTML ="valid";
        return true;
    }

}

function validMail(){

    let email = document.getElementById("iemail").value;
    let validReg =  "^(?=.{1,64}@)[A-Za-z0-9_-]+(\\.[A-Za-z0-9_-]+)*@[^-][A-Za-z0-9-]+(\\.[A-Za-z0-9-]+)*(\\.[A-Za-z]{2,})$";

    if(email.match(validReg) && (email.length < 32 )){
        Mcheck.innerHTML = "Valid";
        return true; 
    }
    else{
        Mcheck.innerHTML = "*invalid email"; 
        return false;
    }
}

function validPssw(){

    let pssw = document.getElementById("ipass").value;
    let psswReg = "^[a-zA-Z0-9_.-]*$";

    if(pssw.match(psswReg) && pssw.length >= 8){
        Pcheck.innerHTML = "valid";
        return true;
    }
    else{
        Pcheck.innerHTML = "*invalid password";
        return false;
    }
}

function validPssw2(){

    let pssw1 = document.getElementById("ipass").value;
    let pssw2 = document.getElementById("ipass2").value;
    let psswReg2 = "^[a-zA-Z0-9_.-]*$";

    if(pssw2.match(psswReg2) && pssw2.length == pssw1.length && pssw2.match(pssw1) ){
        P2check.innerHTML = "valid";
        return true;
    }
    else{
        P2check.innerHTML = "*invalid password";
        return false;
    }
}




