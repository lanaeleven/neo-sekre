@props(['idName' => 'password'])
<script>
    var myInput = document.getElementById("{{ $idName }}");
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

    // When the user starts typing inside the password field
    myInput.onkeyup = function() {

        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("text-red-600");
            letter.classList.add("text-green-600");
        } else {
            letter.classList.remove("text-green-600");
            letter.classList.add("text-red-600");
        }

        // Validate uppercase letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("text-red-600");
            capital.classList.add("text-green-600");
        } else {
            capital.classList.remove("text-green-600");
            capital.classList.add("text-red-600");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            number.classList.remove("text-red-600");
            number.classList.add("text-green-600");
        } else {
            number.classList.remove("text-green-600");
            number.classList.add("text-red-600");
        }

        // Validate symbols
        var symbols = /[\W_]/g;
        if (myInput.value.match(symbols)) {
            symbol.classList.remove("text-red-600");
            symbol.classList.add("text-green-600");
        } else {
            symbol.classList.remove("text-green-600");
            symbol.classList.add("text-red-600");
        }

        // Validate length
        if (myInput.value.length >= 8) {
            length.classList.remove("text-red-600");
            length.classList.add("text-green-600");
        } else {
            length.classList.remove("text-green-600");
            length.classList.add("text-red-600");
        }
    }

    function toggleShowPassword() {
        const x = document.getElementById("{{ $idName }}");
        x.type = x.type === "password" ? "text" : "password";
    }
</script>
