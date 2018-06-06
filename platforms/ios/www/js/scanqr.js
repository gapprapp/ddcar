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
                        beforeSend: function(){
                            $(".overlay").prop('hidden', false);
                        },             
                        success: function(data){  
                            $(".overlay").prop('hidden', true);                           
                            var name;
                            var img;
                            var msg = "";                             
                            var obj = jQuery.parseJSON(data);              
                            if(obj != ""){                
                              $.each(obj, function(i, field){
                                  img = obj[i].img; 
                                  name = obj[i].prod_name;    
                                  msg = msg + '<div class="row" style="margin-bottom: 3%"><div class="col-6 text-right" style="margin-right: 5%;">'+obj[i][0]+' :'+'</div><div class="col-5 text-left">'+obj[i].amount+'</div></div>';
                              });
                              var top_msg = '<div class="row" style="margin-top: 2%; margin-bottom: 2%;"><div class="col-12 text-center"><img src="'+img+'" id="img" alt="" style="width: 300px; height: 300px;"></div></div><br>'; 
                              $.confirm({
                                  title: name,
                                  content: top_msg + msg,
                                  backgroundDismiss: true,
                                  buttons: {
                                      formSubmit: {
                                      text: 'ปิด',
                                      btnClass: 'btn-regis',
                                      action: function () {
                                          document.elementFromPoint(0, 0).click();
                                      }
                                      }
                                  }
                              });
                            }else{
                              $.confirm({
                                  title: "ไม่มีสินค้าในโกดัง/หน้าร้าน",
                                  content: "",
                                  backgroundDismiss: true,
                                  buttons: {
                                      formSubmit: {
                                      text: 'ปิด',
                                      btnClass: 'btn-regis',
                                      action: function () {
                                          document.elementFromPoint(0, 0).click();
                                      }
                                      }
                                  }
                              });  
                            }                                                                                                                  
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