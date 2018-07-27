
// クレジット名義の半角英数字のみ入力
$(function() {
    $("input[name='credit_name']").blur(function() {
        chk();
    });
});

function chk(){
    var credit = $("input[name='credit_name']").val();
        if(credit.match(/[^0-9A-Za-z]+/)){
            $('#creditnameError').text('※半角英数字で入力してください');
            $('.submit').prop('disabled', true);
        } else {
            $('#creditnameError').text('');
            $('.submit').prop('disabled', false);
        }
}
