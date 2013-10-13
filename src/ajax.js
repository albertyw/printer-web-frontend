function convertFile(fileName){
    var convertFileReady = false;
    $.ajax({
        url: '/codes/printer/include/convert.php',
        type: 'get',
        data:{
            filename:fileName
        },
        async: false,
        success:function(feedback){
            if (feedback == "1"){
                $("#pdfConversionSuccess").show("slow");
                convertFileReady = true;
            }
            else{
                $("#pdfConversionFail").show("slow");
            }
        }
     });
    return convertFileReady;
}

function doPrint(fileName, printerName, numCopies){
    $.ajax({
        url:'/codes/printer/include/doPrint.php',
        type:'get',
        data:{
            filename:fileName,
            printer:printerName,
            copies:numCopies
        },
        success:function(data){
            if (data == "1"){
                $("#printSuccess").show("slow");
            }
            else{
                $("#printFail").show("slow");
            }
        }
    });
}

function checkNumeric(numCopies){
    var length = numCopies.length;
    var acceptable = true;
    for(var i=0;i<length;i++){
        var charCode = numCopies.charCodeAt(i);
        if(charCode<48 || charCode > 57) acceptable = false;
    }
    if(numCopies=='') acceptable = false;
    if(acceptable){
        var numCopies = parseInt(numCopies);
        if(numCopies<1 || numCopies>10){
            acceptable = false;
        }
    }
    console.log(numCopies);
    if(acceptable){
        $("#printSubmit").removeAttr("disabled");
        $("#badNumCopies").hide("slow");
    }else{
        $("#printSubmit").attr("disabled","true");
        $("#badNumCopies").show("slow");
    }
}



