var myInput = document.getElementById("password");
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("number");
  var symbol = document.getElementById("symbol");
  var length = document.getElementById("length");
  
  // When the user clicks on the password field, show the message box
  myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
  }
  
  // When the user clicks outside of the password field, hide the message box
  myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
  }
  
  // When the user starts to type something inside the password field
  myInput.onkeyup = function() {
    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if(myInput.value.match(lowerCaseLetters)) {
      letter.classList.remove("text-danger");
      letter.classList.add("text-success");
    } else {
      letter.classList.remove("text-success");
      letter.classList.add("text-danger");
  }
  
    // text-successate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(myInput.value.match(upperCaseLetters)) {
      capital.classList.remove("text-danger");
      capital.classList.add("text-success");
    } else {
      capital.classList.remove("text-success");
      capital.classList.add("text-danger");
    }
  
    // text-successate numbers
    var numbers = /[0-9]/g;
    if(myInput.value.match(numbers)) {
      number.classList.remove("text-danger");
      number.classList.add("text-success");
    } else {
      number.classList.remove("text-success");
      number.classList.add("text-danger");
    }
  
    // text-successate symbols
    var symbols = /[\W_]/g; // regex untuk karakter khusus
    if(myInput.value.match(symbols)) {
      symbol.classList.remove("text-danger");
      symbol.classList.add("text-success");
    } else {
      symbol.classList.remove("text-success");
      symbol.classList.add("text-danger");
    }
  
  
    // text-successate length
    if(myInput.value.length >= 8) {
      length.classList.remove("text-danger");
      length.classList.add("text-success");
    } else {
      length.classList.remove("text-success");
      length.classList.add("text-danger");
    }
  }