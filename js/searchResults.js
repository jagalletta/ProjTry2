/************* Welcome1.php *********/
            //list of elements with name 'inputBox' (all inputs on form)
            var input_list = document.getElementsByName('inputBox');
            var resultsPlaceholderHTML = "";
            // to keep form from opening a new page
            function preventSubmission() {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    showResults();
                }
            }
            //simple validation that form has content in at least one inputBox
            function validateFields() {
                var validated = false;
                for (var i = 0; i < input_list.length; i++) {
                    //loop through array of inputs in input_list defined at top of page.
                    if (input_list[i].value.toString().trim() != "") {
                        validated = true;
                    }
                }
                return validated;
            }
            function showResults() {
                var input_list = document.getElementsByName('inputBox');
                var results_area = document.getElementById('results');
                if (validateFields() == true) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function ()
                    {
                        if (xmlhttp.readyState === 4 && this.status === 200) {
                            //results_area.style = resultsStyle;
                            results_area.innerHTML = xmlhttp.responseText;
                            document.getElementById('search').scrollIntoView();
                        }
                    }
                    //var age = document.getElementById("age").value.toString().trim();
                    var searchString = "";
                    var attribute = "";
                    var value;
                    for (var i = 0; i < input_list.length; i++) {
                        attribute = input_list[i].getAttribute('id').toString();
                        value = input_list[i].value.toString();
                        searchString += attribute + '=' + value;
                        if (i < input_list.length - 1) {
                            searchString += "&";
                        }
                        //alert(input_list[i].value.toString().trim());
                    }
                    //alert(searchString);
                    xmlhttp.open("GET", "artists.php?" + searchString, false);
                    xmlhttp.send();

                } else {
                    resetResults();
                }
            }
            function clearForm() {
                var input_list = document.getElementsByName('inputBox');
                for (var i = 0; i < input_list.length; i++) {
                    input_list[i].value = "";
                }
                resetResults();
            }
            function resetResults() {
                var results_area = document.getElementById('results');
                resultsPlaceholderStyle = "margin-top:285px;  margin-bottom:60px; text-align:center;";
                //results_area.style = resultsPlaceholderStyle;
                results_area.innerHTML = resultsPlaceholderHTML;
            }
            function startDictation() { //from Google API Example at
                if (window.hasOwnProperty('webkitSpeechRecognition')) {
                    var recognition = new webkitSpeechRecognition();
                    recognition.continuous = false;
                    recognition.interimResults = false;
                    recognition.lang = "<?php echo $_SESSION['language'] ?>";
                    recognition.start();
                    document.getElementById("micImg").src = "img/mic-animate.gif";
                    recognition.onresult = function (e) {
                        document.getElementById('artist').value
                                = e.results[0][0].transcript;
                        recognition.stop();
                        document.getElementById('micImg').src = "img/mic.gif";
                        showResults();
                    };
                    recognition.onerror = function (e) {
                        recognition.stop();
                        document.getElementById('micImg').src = "img/mic.gif";
                    }
                    //recognition.ontimout = function (e){
                    //  ??? something like this to turn off mic-animate.gif and set to mic.gif ???
                    //}
                } else {
                    alert("Webkit speech recognition is not supported by this browser.");
                }
            }


/************* Index.html JavaScript *********/
//list of elements with name 'inputBox' (all inputs on form)
var input_list = document.getElementsByName('inputBox');
var resultsPlaceholderHTML = "";

// to keep form from opening a new page
function preventSubmission() {
    if (event.keyCode === 13) {
        event.preventDefault();
        showResults();
    }
}
//simple validation that form has content in at least one inputBox
function validateFields() {
    var validated = false;
    for (var i = 0; i < input_list.length; i++) {
        //loop through array of inputs in input_list defined at top of page.
        if (input_list[i].value.toString().trim() != "") {
            validated = true;
        }
    }
    return validated;
}
function showResults() {
    var input_list = document.getElementsByName('inputBox');
    var results_area = document.getElementById('results');
    if (validateFields() == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState === 4 && this.status === 200) {
                //results_area.style = resultsStyle;
                results_area.innerHTML = xmlhttp.responseText;
                document.getElementById('search').scrollIntoView();
            }
        }
        //var age = document.getElementById("age").value.toString().trim();
        var searchString = "";
        var attribute = "";
        var value;
        for (var i = 0; i < input_list.length; i++) {
            attribute = input_list[i].getAttribute('id').toString();
            value = input_list[i].value.toString();
            searchString += attribute + '=' + value;
            if (i < input_list.length - 1) {
                searchString += "&";
            }
            //alert(input_list[i].value.toString().trim());
        }
        //alert(searchString);
        xmlhttp.open("GET", "artists.php?" + searchString, false);
        xmlhttp.send();
    } else {
        if (document.getElementById("price").value < 0) {
            negativeResults();
        } else {
            resetResults();
        }
    }
}
function clearForm() {
    var input_list = document.getElementsByName('inputBox');
    for (var i = 0; i < input_list.length; i++) {
        input_list[i].value = "";
    }
    resetResults();
}
function resetResults() {
    var results_area = document.getElementById('results');
    resultsPlaceholderStyle = "margin-top:285px;  margin-bottom:60px; text-align:center;";
    //results_area.style = resultsPlaceholderStyle;
    results_area.innerHTML = resultsPlaceholderHTML;
}
function startDictation() { //from Google API Example at
    if (window.hasOwnProperty('webkitSpeechRecognition')) {
        var recognition = new webkitSpeechRecognition();
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.lang = "en-US";
        recognition.start();
        document.getElementById("micImg").src = "img/mic-animate.gif";
        recognition.onresult = function (e) {
            document.getElementById('artist').value
                    = e.results[0][0].transcript;
            recognition.stop();
            document.getElementById('micImg').src = "img/mic.gif";
            showResults();
        };
        recognition.onerror = function (e) {
            recognition.stop();
            document.getElementById('micImg').src = "img/mic.gif";
        }
        //recognition.ontimout = function (e){
        //  ??? something like this to turn off mic-animate.gif and set to mic.gif ???
        //}
    } else {
        alert("Webkit speech recognition is not supported by this browser.");
    }
}
