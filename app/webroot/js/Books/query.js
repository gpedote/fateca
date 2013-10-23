$(document).ready(function () {
    $("#BookFind").bind("change paste keyup", function (event) {
        $.ajax({
            async:true, 
            beforeSend:function (XMLHttpRequest) {
                $("#busy-indicator").fadeIn();
            }, 
            complete:function (XMLHttpRequest, textStatus) {
                $("#busy-indicator").fadeOut();
            }, 
            data:$("#BookFindForm").closest("form").serialize(), 
            dataType:"html", 
            success:function (data, textStatus) {
                $("#books-index").html(data);
            }, 
            type:"POST", 
            url:"\/books\/loan"
        });
        return false;
    });
});