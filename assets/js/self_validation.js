"use strict";
function required(data){
    var parentElements = document.getElementById(data["element_id"]);
    var error_color = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
    var error_message = (data["error_message"]!== undefined) ? data["error_message"] : "This field is required.";
    
    while(true){
        parentElements = parentElements.parentElement;
        if(!parentElements.classList.contains("form-group")){
            continue;
        }
        break;
    }
    if(document.getElementById(data["element_id"]).value.trim() === ""){
        if(parentElements.querySelector("i."+ error_color)){
            parentElements.removeChild(parentElements.querySelector("i." + error_color));
        }
        var errorElement = document.createElement("i");
        errorElement.className = error_color;               
        errorElement.textContent = error_message;                
        parentElements.appendChild(errorElement);
        return false;
    }
    else{
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+ error_color));
        }
        return true;
    }
}

function min_length(data){
    var parentElements = document.getElementById(data["element_id"]);
    var error_color = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
    var error_message = (data["error_message"]!== undefined) ? data["error_message"] : "This field is required.";
    
    while(true){
        parentElements = parentElements.parentElement;
        if(!parentElements.classList.contains("form-group")){
            continue;
        }
        break;
    }
    if(document.getElementById(data["element_id"]).value.trim().length < data.min_length){
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        var errorElement = document.createElement("i");
        errorElement.className = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
        errorElement.textContent = (data["error_message"]!== undefined) ? data["error_message"] : "This field must not be less than min length.";
        parentElements.appendChild(errorElement);
        return false;
    }

    else{
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        return true;
    }
}

function max_length(data){
    var parentElements = document.getElementById(data["element_id"]);
    var error_color = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
    var error_message = (data["error_message"]!== undefined) ? data["error_message"] : "This field is required.";
   
    while(true){
        parentElements = parentElements.parentElement;
        if(!parentElements.classList.contains("form-group")){
            continue;
        }
        break;
    }
    if(document.getElementById(data["element_id"]).value.trim().length > data.max_length){
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        var errorElement = document.createElement("i");
        errorElement.className = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
        errorElement.textContent = (data["error_message"]!== undefined) ? data["error_message"] : "This field must not be greater than max length.";
        parentElements.appendChild(errorElement);
        return false;
    }

    else{
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        return true;
    }
}

function valid_email(data){
    var parentElements = document.getElementById(data["element_id"]);
    var error_color = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
    var error_message = (data["error_message"]!== undefined) ? data["error_message"] : "This field is required.";
    
    while(true){
        parentElements = parentElements.parentElement;
        if(!parentElements.classList.contains("form-group")){
            continue;
        }
        break;
    }
    if(!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/.test(document.getElementById(data["element_id"]).value.trim())){
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        var errorElement = document.createElement("i");
        errorElement.className = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
        errorElement.textContent = (data["error_message"]!== undefined) ? data["error_message"] : "Email must be valid.";
        parentElements.appendChild(errorElement);
        return false;
    }
    else{
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        return true;
    }
}

function zip_code(data){
    var parentElements = document.getElementById(data["element_id"]);
    var error_color = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
    var error_message = (data["error_message"]!== undefined) ? data["error_message"] : "This field is required.";
    
    while(true){
        parentElements = parentElements.parentElement;
        if(!parentElements.classList.contains("form-group")){
            continue;
        }
        break;
    }
    if((document.getElementById(data["element_id"]).value.trim() !== "") && (!/^\d{6}$/.test(document.getElementById(data["element_id"]).value.trim()))){
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        var errorElement = document.createElement("i");
        errorElement.className = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
        errorElement.textContent = (data["error_message"]!== undefined) ? data["error_message"] : "Zip must be valid.";
        parentElements.appendChild(errorElement);
        return false;
    }
    else{
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        return true;
    }
}

function allow_only_character(data){
    var parentElements = document.getElementById(data["element_id"]);
    var error_color = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
    var error_message = (data["error_message"]!== undefined) ? data["error_message"] : "This field is required.";
    
    while(true){
        parentElements = parentElements.parentElement;
        if(!parentElements.classList.contains("form-group")){
            continue;
        }
        break;
    }
    if(!/^[a-zA-Z ]*$/.test(document.getElementById(data["element_id"]).value.trim())){
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        var errorElement = document.createElement("i");
        errorElement.className = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
        errorElement.textContent = (data["error_message"]!== undefined) ? data["error_message"] : "Only characters are allowed.";
        parentElements.appendChild(errorElement);
        return false;
    }
    else{
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        return true;
    }
}

function allow_only_number(data){
    var parentElements = document.getElementById(data["element_id"]);
    var error_color = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
    var error_message = (data["error_message"]!== undefined) ? data["error_message"] : "This field is required.";
    
    while(true){
        parentElements = parentElements.parentElement;
        if(!parentElements.classList.contains("form-group")){
            continue;
        }
        break;
    }
    if(!/^[+-]?\d+(\.\d+)?$/.test(document.getElementById(data["element_id"]).value.trim())){
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        var errorElement = document.createElement("i");
        errorElement.className = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
        errorElement.textContent = (data["error_message"]!== undefined) ? data["error_message"] : "Only numbers are allowed.";
        parentElements.appendChild(errorElement);
        return false;
    }
    
    else{
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        return true;
    }			
}

function allow_only_digit(data){
    var parentElements = document.getElementById(data["element_id"]);
    var error_color = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
    var error_message = (data["error_message"]!== undefined) ? data["error_message"] : "This field is required.";
    
    while(true){
        parentElements = parentElements.parentElement;
        if(!parentElements.classList.contains("form-group")){
            continue;
        }
        break;
    }
    if(!/^\d+$/.test(document.getElementById(data["element_id"]).value.trim())){
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        var errorElement = document.createElement("i");
        errorElement.className = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
        errorElement.textContent = (data["error_message"]!== undefined) ? data["error_message"] : "Only digits are allowed.";
        parentElements.appendChild(errorElement);
        return false;
    }
    else{
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        return true;
    }
}

function allow_special_character(data){
    var parentElements = document.getElementById(data["element_id"]);
    var error_color = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
    var error_message = (data["error_message"]!== undefined) ? data["error_message"] : "This field is required.";
    
    while(true){
        parentElements = parentElements.parentElement;
        if(!parentElements.classList.contains("form-group")){
            continue;
        }
        break;
    }
    if(!/^[a-zA-Z0-9 !@#\$%\^\&*\)\(+=._-]+$/g.test(document.getElementById(data["element_id"]).value.trim())){
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        var errorElement = document.createElement("i");
        errorElement.className = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
        errorElement.textContent = (data["error_message"]!== undefined) ? data["error_message"] : "Only characters, digits, spaces and hipens are allowed.";
        parentElements.appendChild(errorElement);
        return false;
    }
    else{
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        return true;
    }
}

function allow_file_type(data){
    var parentElements = document.getElementById(data["element_id"]);
    var error_color = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
    var error_message = (data["error_message"]!== undefined) ? data["error_message"] : "This field is required.";
    
    while(true){
        parentElements = parentElements.parentElement;
        if(!parentElements.classList.contains("form-group")){
            continue;
        }
        break;
    }
    if(!data['extension'].includes(document.getElementById(data["element_id"]).value.trim().split('.').pop())){
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        var errorElement = document.createElement("i");
        errorElement.className = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
        errorElement.textContent = (data["error_message"]!== undefined) ? data["error_message"] : "Only jpg, jpeg, bmp, gif and png files are allowed.";
        parentElements.appendChild(errorElement);
        return false;
    }
    else{
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        return true;
    }
}

function allow_file_size(data){
    var parentElements = document.getElementById(data["element_id"]);
    var error_color = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
    var error_message = (data["error_message"]!== undefined) ? data["error_message"] : "This field is required.";
    
    while(true){
        parentElements = parentElements.parentElement;
        if(!parentElements.classList.contains("form-group")){
            continue;
        }
        break;
    }
    if(!data['extension'].includes(document.getElementById(data["element_id"]).value.trim().split('.').pop())){
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        var errorElement = document.createElement("i");
        errorElement.className = (data["error_color"]!== undefined) ? data["error_color"] : "text-danger";
        errorElement.textContent = (data["error_message"]!== undefined) ? data["error_message"] : "Only jpg, jpeg, bmp, gif and png files are allowed.";
        parentElements.appendChild(errorElement);
        return false;
    }
    else{
        if(parentElements.querySelector("i."+error_color)){
            parentElements.removeChild(parentElements.querySelector("i."+error_color));
        }
        return true;
    }
}


function validate_form(all_function_name=[]){
    var total_result=[];
    for(let i=0; i<all_function_name.length; i++){
        total_result.push(all_function_name[i]());
    }
    for(let i=0; i<total_result.length; i++){
        if(total_result[i] === true){
            continue;
        }
        return false;
    }
    return true;
}