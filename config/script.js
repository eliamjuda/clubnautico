const d = document; 

const $nombre = d.getElementById("nombre"),
        $apellidos = d.getElementById("apellidos"),
        $telefono = d.getElementById("telefono"),
        $correo = d.getElementById("correo"),
        $membresia = d.getElementById("membresia"),
        $formInput = d.getElementById("formInput");


const isEmpty = value => value.length == '' ? true : false;
const isBetween = (length, min, max) => length < min || length > max ? false : true;
const hasNumber = (value) => /\d/.test(value);
const hasLetter = (value) => /[a-zA-Z]/.test(value);
const isValidEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);



function showError( element, message ) {
    
    element.classList.remove("success");
    element.classList.add("error");

    let error = element.nextElementSibling;

    error.textContent = message;
}

function showSuccess( element ) {
    
    element.classList.remove("error");
    element.classList.add("success");

    let error = element.nextElementSibling;
    error.textContent = "";
}

function checkName(){
    
    let valid = false; 
    const MIN = 2, MAX = 30;
    
    let name = $nombre.value.trim();
    
    if ( isEmpty(name) ){
        
        showError($nombre, "El campo no debe estar vacío");

    } else if( !isBetween(name.length, MIN, MAX) ) {
        
        showError($nombre, "El nombre debe tener más de 1 letra y menos de 30.")

    } else if( hasNumber(name) ){

        showError($nombre, "El nombre no puede contener números.")

    } else {
        showSuccess($nombre);
        valid = true; 
    }

    return valid; 
    
}

function checkLastNames() {

    let valid = false; 

    const MIN = 5, MAX = 60;
    
    let lastnames = $apellidos.value.trim();

    if ( isEmpty(lastnames) ){

        showError($apellidos, "El campo no debe estar vacío");

    } else if ( !isBetween(lastnames.length, MIN, MAX) ){

        showError($apellidos, "Los apellidos deben de tener al menos 5 letras y menos de 60");
    } else if ( hasNumber(lastnames) ){

        showError($apellidos, "Los apellidos no deben contener números");

    } else {
        showSuccess($apellidos);
        valid = true;
    }

    return valid;


}

function checkPhone(phoneData) {
    
    const MIN = 10, MAX = 11;
    let valid = false;

    let phone = $telefono.value.trim();

    if ( isEmpty(phone) ){

        showError($telefono, "El campo no debe estar vacío.");

    } else if ( !isBetween(phone.length, MIN, MAX) ){

        showError($telefono, "El teléfono debe tener un número válido.");

    } else if ( hasLetter(phone) ){

        showError($telefono, "El teléfono no debe contener letras.");

    } else if (phoneData === phone) {

        showError($telefono, "El teléfono ya existe, ingresa otro.");

    } else {
        showSuccess($telefono);
        valid = true;
    }

    return valid;

}

function checkEmail(emailData) {

    let valid = false; 

    let email = $correo.value.trim();

    if ( isEmpty(email) ){
        
        showError($correo, "El campo no debe estar vacío.");

    } else if ( !isValidEmail(email) ){

        showError($correo, "El correo debe ser válido.");

    }else if ( emailData === email ) {

        showError($correo, "El correo ya existe, ingresa otro.");

    } else {
        showSuccess($correo);
        valid = true;
    }

    return valid;
}

// Submit function
$formInput.addEventListener("submit", function(e) {

    e.preventDefault();

    //If formValid returns true, it means that all the check functions returned true. 
    // The form is validated and has no errors, so we can proceed with the submit.

    let validEmail = checkEmail(),
        validName = checkName(),
        validLastNames = checkLastNames(),
        validPhone = checkPhone();

    let formValid = validEmail && validName && validLastNames && validPhone;

    console.log(formValid);

    // this means that if formSubmit is true, then we go ahead with the submit.
    if ( formValid ) {

        let correo = $correo.value.trim();
        let telefono = $telefono.value.trim();

        //we get the email and phone to send both to PHP file
        
        /*
            INFO ABOUT AJAX REQUEST

            Without jQuery, the request needs to be made in the following way

            -Need to create a XMLHttpRequest object
                
                let objct = new XMLHttpRequest();

            -then make the request where specifies the type of request
            method: the type of request: GET or POST
            url: the server (file) location
            async: true (asynchronous) or false (synchronous)
                
                objct.open(method,url,async);

            -Finally we send the request

                objct.send();// In this we are'nt sending any data
                
                objct.setRequestHeader("Content-type", "application/x-www-form-urlencoded");//encode the data that will be sent to the server from the browser
                objct.send(data);//after encode the data we send the request
        */

       //we need to import JQuery to simplify the AJAX request
        
        //
        $.ajax({
            //url: the server (file) location
            url: '../includes/email-check.php',
            //the type of request: GET or POST
            type: 'POST',
            //Data to be sent to the server.
            // int this case contentType (default: 'application/x-www-form-urlencoded; charset=UTF-8') is included by default
            // also async (default: true) is included by default
            data: {correo, telefono},

            //In this case if the request was successful execute the function containing
            //-response is the JSON that we get from the POST request
            success: function(response){
                
                var jsonData = JSON.parse(response);
                console.log(jsonData);

                //if JSON isn't empty means that exist other user with the same email o phone
                if(jsonData.length !== 0){//Other option can be this line jQuery.isEmptyObject(jsonData) in if statement
                
                    // using map to check all the individual data
                    jsonData.map(data => {

                        console.log(data.correo, data.telefono);
                        // We pass the required parameter that will validate if it already exists
                        checkEmail(data.correo);
                        checkPhone(data.telefono);
                    })
                }else{
                    $formInput.submit();
                }
            },
            //Finally if the request was not succesfull we send the error to the console
            error: function(jqXHR,textStatus, errorThrown){
                console.error("AJAX Error:",textStatus,errorThrown);
            }
        });

        

    }

});

$formInput.addEventListener('blur', function (e) {
    
    if ( e.target.id == "nombre" ) {
        checkName();
    }

    if ( e.target.id == "apellidos" ) {
        checkLastNames();
    }

    if ( e.target.id == "telefono" ) {
        checkPhone();
    }

    if ( e.target.id == "correo" ){
        checkEmail();
    }

    e.preventDefault();
}, true );



