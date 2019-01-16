

function execPurchase(response){
    if(respomse.resultCode != '000'){
        window.alert('カード情報に誤りがあります。')
    }else{
        document.getElementById("token").value = response.tokenObject.token;
        console.log(response);
    }
}

function doPurchase(){
    var cardno,expire,holdername
    var cardno = document.getElementById("credit_num");
    var expire = document.getElementById("expiration_date_year").value + document.getElementById("expiration_date_month").value;
    var holdername = document.getElementById("credit_name");
    Multipayment.init("tshop00033421");
    Multipayment.getToken({
        cardno : cardno,
        expire : expire,
        holdername : holdername
    }.execPurchase);

}