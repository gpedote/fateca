$(document).ready(function () {
    $("#cart-index").on('click','.rm', function() {
        $.ajax({
            async:true, 
            beforeSend:function (XMLHttpRequest) {
                $("#busy-indicator").fadeIn();
            }, 
            complete:function (XMLHttpRequest, textStatus) {
                $("#busy-indicator").fadeOut();
            }, 
            data:$(this).closest('form').serialize(), 
            dataType:"html", 
            success:function (data, textStatus) {
                $("#cart-index").html(data);
            }, 
            type:"POST", 
            url:"\/loans\/removeCart"
        });
        return false;
    });
});
