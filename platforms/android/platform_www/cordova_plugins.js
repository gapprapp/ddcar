cordova.define('cordova/plugin_list', function(require, exports, module) {
module.exports = [
  {
    "id": "com.telerik.plugins.nativepagetransitions.NativePageTransitions",
    "file": "plugins/com.telerik.plugins.nativepagetransitions/www/NativePageTransitions.js",
    "pluginId": "com.telerik.plugins.nativepagetransitions",
    "clobbers": [
      "window.plugins.nativepagetransitions"
    ]
  },
  {
    "id": "cordova-plugin-camera.Camera",
    "file": "plugins/cordova-plugin-camera/www/CameraConstants.js",
    "pluginId": "cordova-plugin-camera",
    "clobbers": [
      "Camera"
    ]
  },
  {
    "id": "cordova-plugin-camera.CameraPopoverOptions",
    "file": "plugins/cordova-plugin-camera/www/CameraPopoverOptions.js",
    "pluginId": "cordova-plugin-camera",
    "clobbers": [
      "CameraPopoverOptions"
    ]
  },
  {
    "id": "cordova-plugin-camera.camera",
    "file": "plugins/cordova-plugin-camera/www/Camera.js",
    "pluginId": "cordova-plugin-camera",
    "clobbers": [
      "navigator.camera"
    ]
  },
  {
    "id": "cordova-plugin-camera.CameraPopoverHandle",
    "file": "plugins/cordova-plugin-camera/www/CameraPopoverHandle.js",
    "pluginId": "cordova-plugin-camera",
    "clobbers": [
      "CameraPopoverHandle"
    ]
  },
  {
    "id": "cordova-plugin-datepicker.DatePicker",
    "file": "plugins/cordova-plugin-datepicker/www/android/DatePicker.js",
    "pluginId": "cordova-plugin-datepicker",
    "clobbers": [
      "datePicker"
    ]
  },
  {
    "id": "cordova-plugin-device.device",
    "file": "plugins/cordova-plugin-device/www/device.js",
    "pluginId": "cordova-plugin-device",
    "clobbers": [
      "device"
    ]
  },
  {
    "id": "cordova-plugin-fullscreen.AndroidFullScreen",
    "file": "plugins/cordova-plugin-fullscreen/www/AndroidFullScreen.js",
    "pluginId": "cordova-plugin-fullscreen",
    "clobbers": [
      "AndroidFullScreen"
    ]
  },
  {
    "id": "es6-promise-plugin.Promise",
    "file": "plugins/es6-promise-plugin/www/promise.js",
    "pluginId": "es6-promise-plugin",
    "runs": true
  },
  {
    "id": "cordova-plugin-screen-orientation.screenorientation",
    "file": "plugins/cordova-plugin-screen-orientation/www/screenorientation.js",
    "pluginId": "cordova-plugin-screen-orientation",
    "clobbers": [
      "cordova.plugins.screenorientation"
    ]
  },
  {
    "id": "cordova-plugin-statusbar.statusbar",
    "file": "plugins/cordova-plugin-statusbar/www/statusbar.js",
    "pluginId": "cordova-plugin-statusbar",
    "clobbers": [
      "window.StatusBar"
    ]
  },
  {
    "id": "phonegap-plugin-barcodescanner.BarcodeScanner",
    "file": "plugins/phonegap-plugin-barcodescanner/www/barcodescanner.js",
    "pluginId": "phonegap-plugin-barcodescanner",
    "clobbers": [
      "cordova.plugins.barcodeScanner"
    ]
  },
  {
    "id": "cordova-plugin-printer.Printer",
    "file": "plugins/cordova-plugin-printer/www/printer.js",
    "pluginId": "cordova-plugin-printer",
    "clobbers": [
      "plugin.printer",
      "cordova.plugins.printer"
    ]
  }
];
module.exports.metadata = 
// TOP OF METADATA
{
  "com.telerik.plugins.nativepagetransitions": "0.6.5",
  "cordova-plugin-camera": "4.0.2",
  "cordova-plugin-datepicker": "0.9.3",
  "cordova-plugin-device": "2.0.1",
  "cordova-plugin-fullscreen": "1.1.0",
  "es6-promise-plugin": "4.2.2",
  "cordova-plugin-screen-orientation": "3.0.1",
  "cordova-plugin-statusbar": "2.4.2",
  "cordova-plugin-whitelist": "1.3.3",
  "phonegap-plugin-barcodescanner": "7.1.0",
  "cordova-plugin-printer": "0.7.3"
};
// BOTTOM OF METADATA
});