var messages = {
    required : "mandatory field",
    repassword: "passwords don't match",
    password: "10 chars at least 1 number 1 lowercase and 1 uppercase",
    email: "invalid email format"
}

var reps = [];
document.addEventListener("DOMContentLoaded", function(event) { 
    
    var fields = document.querySelectorAll('[data-validate]');

    for (let item of fields) {
        
        var validats = item.getAttribute("data-validate").split("|");
        
        for(let val of validats){
            if(val == "repassword"){
                reps.push(item.getAttribute("id"));
            }
        }
       

        item.onblur = function(e){
            var validations = item.getAttribute("data-validate").split("|");
            
            var error = false;
            for(let validation of validations){
                
                if(!window[validation](e.srcElement.value)){
                    console.log("pwd mala");
                    
                    item.parentElement.getElementsByClassName("form_error_msg")[0].innerText=messages[validation];
                    error = true;
                    break;
                }

            }
            if(error){
                item.classList.add("bg-error");
            } else {
                item.parentElement.getElementsByClassName("form_error_msg")[0].innerText="";
                item.classList.remove("bg-error");
            }
            
        };
    }

});

var required = function(val){

    if(val.trim() == ""){
        return false;
    }

    return true;
    
}

var email = function(val){

    var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(val);

}

var password = function(val){

    var pattern = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{10,}/;

    return pattern.test(val);

}

var repassword = function(val){

    if(document.getElementById(reps[0]).value != document.getElementById(reps[1]).value){
        return false;
    } 

    return true;
    
}