async function scan(arg, type, ware_id) {
    // ดึง CapacitorBarcodeScanner จาก Capacitor.Plugins
    const CapacitorBarcodeScanner = window.Capacitor?.Plugins?.CapacitorBarcodeScanner || window.CapacitorBarcodeScanner;

    if (!CapacitorBarcodeScanner) {
        console.error("CapacitorBarcodeScanner plugin is not available.");
        return;
    }
    try {
        // เช็กว่าเป็น Emulator หรือไม่ (หากเป็น Emulator อาจจะจำลองค่าสแกนเพื่อทดสอบ)
        if (Capacitor.getPlatform() === 'web') {
            console.log("Running on web / unsupported environment");
        }
        // 2. เรียกใช้ plugin ผ่าน CapacitorBarcodeScanner (หรือ Capacitor.Plugins.CapacitorBarcodeScanner)
        const result = await CapacitorBarcodeScanner.scanBarcode({
            hint: 0, // 0 หมายถึง QR_CODE (ตาม enum Html5QrcodeSupportedFormats) หรือใส่ 17 เพื่อรับทุกรูปแบบ
            scanInstructions: "วางคิวอาโค้ดภายในสี่เหลี่ยมผืนผ้าที่ช่องมองภาพเพื่อแสกน"
        });

        // ตรวจสอบว่ามีข้อมูลจากการสแกนหรือไม่ (ถ้ายกเลิก result.ScanResult จะไม่มีค่า)
        if (result && result.ScanResult) {
            
            // ในกรณีที่ต้องการเช็คว่าเป็น QR Code
            if (result.format === "QR_CODE" || result.format === 0) {
                var value = result.ScanResult; // เปลี่ยนจาก result.text เป็น result.ScanResult
                
                if (value.includes("[transfer]")) {
                    var indexT = value.indexOf("]");
                    indexT += 1;
                    var valueSS = value.substring(indexT);
                    var groupStr = valueSS.split("|");
                    var prod_id = groupStr[0].split(",");
                    var cost = groupStr[1].split(",");
                    var amt = groupStr[2].split(",");
                    var arr_data = [];
                    var sum = 0;

                    for (var i = 0; i < prod_id.length; i++) {
                        item = {};
                        item["prod_id"] = prod_id[i];
                        item["cost"] = cost[i];
                        item["amt"] = amt[i];
                        item["addr"] = "";
                        arr_data.push(item);
                        var sum_prod = cost[i] * amt[i];
                        sum += parseInt(sum_prod);
                    }

                    var d = new Date($.now());         
                    var datetime = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                    json_string = JSON.stringify(arr_data);
                    var dataString = "JSON=" + json_string + "&ware_id=" + ware_id + "&date=" + datetime
                    + "&sum=" + sum + "&user_id=" + localStorage.user_id + "&type=" + type;

                    $.ajax({
                        type: "POST",
                        url: localStorage.pathServer + "php/stock_in.php",           
                        data: dataString,               
                        beforeSend: function(){
                            $(".overlay").prop('hidden', false);
                        },             
                        success: function(data){  
                            $(".overlay").prop('hidden', true);              
                            if (data == "success") {                       
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
                            } else {
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
                } else {
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
                            if (obj != "") {                
                                $.each(obj, function(i, field){
                                    price = obj[i].prod_price;
                                    pricesend = obj[i].prod_pricesend;
                                    cost = obj[i].prod_cost;
                                    img = obj[i].img; 
                                    name = obj[i].prod_name;    
                                    id = obj[i].id;
                                    prod_id = obj[i].prod_id;
                                    if (obj[i][9] == "ware") {
                                        datastr = {'prod_id': prod_id, 'ware_id': id};
                                    } else {
                                        datastr = {'prod_id': prod_id, 'shop_id': id};
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
                                if (localStorage.user_role == "พนักงาน") {
                                    msg_price = '<p>ส่ง : '+pricesend+'  ปลีก : '+price+'</p>';
                                } else {
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
                            } else {
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
            }
        } else {
            // กรณีผู้ใช้กดยกเลิกสแกน (cancelled)
            if (arg == "index") {
                window.location = "index.html";
            }
        }
    } catch (error) {
        // พิมพ์ Error ออกมาดูใน Console ก่อนเพื่อดูสาเหตุที่แท้จริง
        console.error("Barcode Scan Error:", error);
        // จัดการเมื่อเกิดข้อผิดพลาดในการเปิดกล้องหรือการสแกน
        $.confirm({
            title: 'พบข้อผิดพลาด',
            content: 'ไม่สามารถเปิดกล้องได้: ' + (error.message || 'กรุณาลองอีกครั้ง'),
            backgroundDismiss: true,
            buttons: {
                formSubmit: {
                    text: 'ตกลง',
                    btnClass: 'btn-regis',
                    action: function () {}
                }
            }
        });
    }
}

function show_pic(){
    localStorage.img = $('#img').attr('src');           
    window.location = "show_pic.html";   
}