function scan(arg,type,ware_id){
        cordova.plugins.barcodeScanner.scan(
        function (result) {
            if(!result.cancelled){
                // In this case we only want to process QR Codes
                if(result.format == "QR_CODE"){
                    var value = result.text;
                    
                    if(value.includes("[transfer]")){
                        var indexT = value.indexOf("]");
                        indexT += 1
                        var valueSS = value.substring(indexT)
                        var groupStr = valueSS.split("|")
                        var prod_id = groupStr[0].split(",")
                        var cost = groupStr[1].split(",")
                        var amt = groupStr[2].split(",")
                        //var ware_id = groupStr[3]
                        var arr_data = [];
                        var sum = 0
                        //var msg_alert = "";
                        for(var i = 0 ; i < prod_id.length ; i++){
                            item = {}
                            item ["prod_id"] =  prod_id[i];
                            item ["cost"] =  cost[i];
                            item ["amt"] =  amt[i]
                            item ["addr"] = ""
                            arr_data.push(item);
                            var sum_prod = cost[i]*amt[i];
                            sum += parseInt(sum_prod);
                            //msg_alert += arr_data[i].name + " คงเหลือ " + (parseInt(arr_data[i].min)+parseInt(arr_data[i].amt)) + '<br>';                          
                        }
                        var d = new Date($.now());         
                        var datetime = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                        json_string = JSON.stringify(arr_data);
                        var dataString =  "JSON=" + json_string + "&ware_id=" + ware_id + "&date=" + datetime
                        + "&sum=" + sum + "&user_id=" + localStorage.user_id + "&type=" + type;
                        $.ajax({
                            type: "POST",
                            url:localStorage.pathServer + "php/stock_in.php",           
                            data: dataString,               
                            beforeSend: function(){
                                $(".overlay").prop('hidden', false);
                            },             
                            success: function(data){  
                            $(".overlay").prop('hidden', true);              
                                if(data == "success"){                       
                                    $.confirm({
                                        title: 'นำสินค้าเข้า' + type,
                                        content: 'สำเร็จ',
                                        backgroundDismiss: true,
                                        buttons: {
                                            formSubmit: {
                                            text: 'ตกลง',
                                            btnClass: 'btn-regis',
                                            action: function () {
                                                document.elementFromPoint(0, 0).click();
                                            }
                                            }
                                        }
                                    });
                                }else{
                                    $.confirm({
                                        title: 'พบข้อผิดพลาด',
                                        content: 'ลองอีกครั้ง',
                                        backgroundDismiss: true,
                                        buttons: {
                                            formSubmit: {
                                            text: 'ตกลง',
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
                        $.ajax({
                        type: "POST",
                        url: localStorage.pathServer + "php/check_amt_prod.php",
                        data: {'qr': value},
                        beforeSend: function(){
                            $(".overlay").prop('hidden', false);
                        },             
                        success: function(data){  
                            $(".overlay").prop('hidden', true);                           
                            var name;
                            var img;
                            var msg = "";    
                            var addr;                         
                            var obj = jQuery.parseJSON(data);              
                            if(obj != ""){                
                              $.each(obj, function(i, field){
                                  price = obj[i].prod_price;
                                  pricesend = obj[i].prod_pricesend;
                                  cost = obj[i].prod_cost;
                                  img = obj[i].img; 
                                  name = obj[i].prod_name;    
                                  id = obj[i].id;
                                  prod_id = obj[i].prod_id;
                                    if(obj[i][9] == "ware"){
                                        datastr = {'prod_id':prod_id,'ware_id':id};
                                    }else{
                                        datastr = {'prod_id':prod_id,'shop_id':id};
                                    }
                                    addr = "";
                                    $.ajax({
                                        type: "POST",
                                        url: localStorage.pathServer + "php/get_place.php",
                                        data: datastr,
                                        async: false,
                                        beforeSend: function(){
                                        $(".overlay").prop('hidden', false);
                                        },             
                                        success: function(data){  
                                        $(".overlay").prop('hidden', true);    
                                        var obj = jQuery.parseJSON(data);								
                                        $.each(obj, function(i, field){ 
                                            addr = addr + field.place + ",";
                                        }); 
                                                                                                                                                                        
                                        }               
                                    });	   
                                  msg = msg + '<div class="row" style="margin-bottom: 3%"><div class="col-6 text-right" style="margin-right: 5%;">'+obj[i][0]+' :'+'</div><div class="col-5 text-left">'+obj[i].amount+' | '+addr+'</div></div>';
                              });
                              var msg_price;					
                              if(localStorage.user_role == "พนักงาน"){
                                msg_price = '<p>ส่ง : '+pricesend+'  ปลีก : '+price+'</p>';
                              }else{
                                msg_price = '<p>ทุน : '+cost+'  ส่ง : '+pricesend+'  ปลีก : '+price+'</p>';
                              }	
                              var top_msg = '<div class="row" style="margin-top: 2%; margin-bottom: 2%;"><div class="col-12 text-center">'+msg_price+'<br><img src="'+img+'" id="img" alt="" onclick="show_pic()" style="width: 300px; height: 300px;"></div></div><br>'; 
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
                    }       
                }else{
                    //alert("Sorry, only qr codes this time ;)");
                }
            }else{
                if(arg == "index"){
                    window.location = "index.html";
                }              
              //alert("The user has dismissed the scan");
            }
        },
        function (error) {
          $.confirm({
            title: 'พบข้อผิดพลาด',
            content: 'กรุณาลองอีกครั้ง',
            backgroundDismiss: true,
            buttons: {
              formSubmit: {
                text: 'ตกลง',
                btnClass: 'btn-regis',
                action: function () {
                }
              }
            }
          });
        },
        {
            prompt : "วางคิวอาโค้ดภายในสี่เหลี่ยมผืนผ้าที่ช่องมองภาพเพื่อแสกน"
        }
        );
    }

function show_pic(){
    localStorage.img = $('#img').attr('src');           
    window.location = "show_pic.html";   
}