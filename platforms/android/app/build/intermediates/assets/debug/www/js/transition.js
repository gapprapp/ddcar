function transition_page_next() {
    var options = {
        "direction": "left", // 'left|right|up|down', default 'left' (which is like 'next')
        "duration": 300, // in milliseconds (ms), default 400
        "slowdownfactor": 4, // overlap views (higher number is more) or no overlap (1). -1 doesn't slide at all. Default 4
        "iosdelay": 100, // ms to wait for the iOS webview to update before animation kicks in, default 60
        "androiddelay": 100, // same as above but for Android, default 70
        "fixedPixelsTop": 0, // the number of pixels of your fixed header, default 0 (iOS and Android)
        "fixedPixelsBottom": 0  // the number of pixels of your fixed footer (f.i. a tab bar), default 0 (iOS and Android)
    };
    window.plugins.nativepagetransitions.slide(
        options,
        function (msg) { console.log("success: " + msg) }, // called when the animation has finished
        function (msg) { alert("error: " + msg) } // called in case you pass in weird values
    );
}

function transition_page_next_fixed() {
    var options = {
        "direction": "left", // 'left|right|up|down', default 'left' (which is like 'next')
        "duration": 300, // in milliseconds (ms), default 400
        "slowdownfactor": 4, // overlap views (higher number is more) or no overlap (1). -1 doesn't slide at all. Default 4
        "iosdelay": 100, // ms to wait for the iOS webview to update before animation kicks in, default 60
        "androiddelay": 100, // same as above but for Android, default 70
        "fixedPixelsTop": 0, // the number of pixels of your fixed header, default 0 (iOS and Android)
        "fixedPixelsBottom": 50  // the number of pixels of your fixed footer (f.i. a tab bar), default 0 (iOS and Android)
    };
    window.plugins.nativepagetransitions.slide(
        options,
        function (msg) { console.log("success: " + msg) }, // called when the animation has finished
        function (msg) { alert("error: " + msg) } // called in case you pass in weird values
    );
}

function transition_page_back() {
    var options = {
        "direction": "right", // 'left|right|up|down', default 'left' (which is like 'next')
        "duration": 300, // in milliseconds (ms), default 400
        "slowdownfactor": 4, // overlap views (higher number is more) or no overlap (1). -1 doesn't slide at all. Default 4
        "iosdelay": 100, // ms to wait for the iOS webview to update before animation kicks in, default 60
        "androiddelay": 100, // same as above but for Android, default 70
        "fixedPixelsTop": 0, // the number of pixels of your fixed header, default 0 (iOS and Android)
        "fixedPixelsBottom": 0  // the number of pixels of your fixed footer (f.i. a tab bar), default 0 (iOS and Android)
    };
    window.plugins.nativepagetransitions.slide(
        options,
        function (msg) { console.log("success: " + msg) }, // called when the animation has finished
        function (msg) { alert("error: " + msg) } // called in case you pass in weird values
    );
}

function transition_page_back_fixed() {
    var options = {
        "direction": "right", // 'left|right|up|down', default 'left' (which is like 'next')
        "duration": 300, // in milliseconds (ms), default 400
        "slowdownfactor": 4, // overlap views (higher number is more) or no overlap (1). -1 doesn't slide at all. Default 4
        "iosdelay": 100, // ms to wait for the iOS webview to update before animation kicks in, default 60
        "androiddelay": 100, // same as above but for Android, default 70
        "fixedPixelsTop": 0, // the number of pixels of your fixed header, default 0 (iOS and Android)
        "fixedPixelsBottom": 50  // the number of pixels of your fixed footer (f.i. a tab bar), default 0 (iOS and Android)
    };
    window.plugins.nativepagetransitions.slide(
        options,
        function (msg) { console.log("success: " + msg) }, // called when the animation has finished
        function (msg) { alert("error: " + msg) } // called in case you pass in weird values
    );
}

function transition_page_next_flip() {
    var options = {
        "direction": "right", // 'left|right|up|down', default 'right' (Android currently only supports left and right)
        "duration": 500, // in milliseconds (ms), default 400
        "iosdelay": 50, // ms to wait for the iOS webview to update before animation kicks in, default 60
        "androiddelay": 100,  // same as above but for Android, default 70
        "winphonedelay": 150 // same as above but for Windows Phone, default 200
    };
    window.plugins.nativepagetransitions.flip(
        options,
        function (msg) { console.log("success: " + msg) }, // called when the animation has finished
        function (msg) { alert("error: " + msg) } // called in case you pass in weird values
    );
}

function transition_page_back_flip() {
    var options = {
        "direction": "left", // 'left|right|up|down', default 'right' (Android currently only supports left and right)
        "duration": 500, // in milliseconds (ms), default 400
        "iosdelay": 50, // ms to wait for the iOS webview to update before animation kicks in, default 60
        "androiddelay": 100,  // same as above but for Android, default 70
        "winphonedelay": 150 // same as above but for Windows Phone, default 200
    };
    window.plugins.nativepagetransitions.flip(
        options,
        function (msg) { console.log("success: " + msg) }, // called when the animation has finished
        function (msg) { alert("error: " + msg) } // called in case you pass in weird values
    );
}