function scan(){
        cordova.plugins.barcodeScanner.scan(
        function (result) {
            if(!result.cancelled){
                // In this case we only want to process QR Codes
                if(result.format == "QR_CODE"){
                    var value = result.text;                        
                            
                    $.ajax({
                        type: "POST",
                        url: "https://omise-webpack.000webhostapp.com/www/php/check_amt_prod.php",                
                        data: {'qr': value},             
                        success: function(data){                             
                            var name;
                            var msg = "";                             
                            var obj = jQuery.parseJSON(data); 
                            console.log(obj);
                            $.each(obj, function(i, field){ 
                                name = obj[i].prod_name;    
                                msg = msg + obj[i][0] + " : " + obj[i].amount + "<br>";
                            }); 
                            $.alert({
                                title: name,
                                content: msg,
                                type: 'blue',
                            });                                                                                                     
                        }               
                    });         
                }else{
                    //alert("Sorry, only qr codes this time ;)");
                }
            }else{
              //alert("The user has dismissed the scan");
            }
        },
        function (error) {
          $.alert({
              title: 'คำเตือน!',
              content: error,
          });
        },
        {
            prompt : "วางคิวอาโค้ดภายในสี่เหลี่ยมผืนผ้าที่ช่องมองภาพเพื่อแสกน"
        }
        );
    }