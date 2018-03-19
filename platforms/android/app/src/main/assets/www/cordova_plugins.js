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
    "id": "phonegap-plugin-barcodescanner.BarcodeScanner",
    "file": "plugins/phonegap-plugin-barcodescanner/www/barcodescanner.js",
    "pluginId": "phonegap-plugin-barcodescanner",
    "clobbers": [
      "cordova.plugins.barcodeScanner"
    ]
  }
];
module.exports.metadata = 
// TOP OF METADATA
{
  "cordova-plugin-whitelist": "1.3.3",
  "com.telerik.plugins.nativepagetransitions": "0.6.5",
  "phonegap-plugin-barcodescanner": "7.1.0"
};
// BOTTOM OF METADATA
});