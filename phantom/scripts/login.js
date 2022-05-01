var page = new WebPage(), testindex = 0, loadInProgress = false;


page.onConsoleMessage = function(msg) {
    console.log(msg);
};

page.onLoadStarted = function() {
    loadInProgress = true;
    // console.log("load started");
};

page.onLoadFinished = function() {
    loadInProgress = false;
    console.log("load finished");
};

var steps = [
    function() {
        //Load Login Page
        page.open("https://www.linkedin.com/");
    },
    function() {
        //Enter Credentials
        page.evaluate(function() {

            var arr = document.getElementsByClassName("login-form");
            var i;

            for (i=0; i < arr.length; i++) {
                if (arr[i].getAttribute('method') == "POST") {

                    arr[i].elements["session_key"].value="khalid@carre.co.ma";
                    arr[i].elements["session_password"].value="alert19khatar";
                    return;
                }
            }
        });
    },
    function() {
        //Login
        page.evaluate(function() {
            var arr = document.getElementsByClassName("login-form");
            var i;

            for (i=0; i < arr.length; i++) {
                if (arr[i].getAttribute('method') == "POST") {
                    arr[i].submit();
                    return;
                }
            }

        });
    },
    function() {
        // Output content of page to stdout after form has been submitted
        page.evaluate(function() {
            console.log(document.querySelectorAll('html')[0].outerHTML);
        });
    }
];


interval = setInterval(function() {
    if (!loadInProgress && typeof steps[testindex] == "function") {
        console.log("step " + (testindex + 1));
        steps[testindex]();
        testindex++;
    }
    if (typeof steps[testindex] != "function") {
        // console.log("test complete!");
        phantom.exit();
    }
}, 50);