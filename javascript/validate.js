function validate(){
    var phone = document.getElementById('phone').value
    var dob = document.getElementById('dob').value
    var check1 = phone.replace(/\D/g,'').length === 10

    var regEx = /^\d{4}-\d{2}-\d{2}$/;
    if(!dob.match(regEx)) 
        var check2 = false
    else{
        var d = new Date(dob)
        var dNum = d.getTime()
        if(!dNum && dNum !== 0) 
            var check2 = false
        try{
            var check2 = d.toISOString().slice(0,10) === dob
        }catch(e){
            var check2 = false
        }
    }
    if(check1){
        document.getElementById('phoneerror').style.display = "none"
    }else{
        document.getElementById('phoneerror').style.display = "block"
    }
    if(check2){
        document.getElementById('bderror').style.display = "none"
    }else{
        document.getElementById('bderror').style.display = "block"
    }
    if(!check1 || !check2)
        document.getElementById('tech-submit').disabled = true
    else        
        document.getElementById('tech-submit').disabled = false
}
function checkNum(){
    var dur = document.getElementById('duration').value
    var price = document.getElementById('price').value

    var check2 = !isNaN(dur) && Number.parseInt(dur) > 0
    var check3 = !isNaN(price) && Number.parseInt(price) > 0

    document.getElementById('durerror').style.display = check2 ? "none" : "block"
    document.getElementById('priceerr').style.display = check3 ? "none" : "block"
    document.getElementById('tech-submit').disabled = !check2 || !check3
}
function checkPhoneOnly(){
    var phone = document.getElementById('phone').value
    var check1 = phone.replace(/\D/g,'').length === 10
    document.getElementById('phoneerror').style.display = check1 ? "none" : "block"
    document.getElementById('tech-submit').disabled = !check1
}