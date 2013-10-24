$(document).ready(function () {
    $("#PersonFind").bind("change paste keyup", function (event) {
        $.ajax({
            async:true, 
            beforeSend:function (XMLHttpRequest) {
                $("#busy-indicator").fadeIn();
            }, 
            complete:function (XMLHttpRequest, textStatus) {
                $("#busy-indicator").fadeOut();
            }, 
            data:$("#PersonFindForm").closest("form").serialize(), 
            dataType:"html", 
            success:function (data, textStatus) {
                $("#people-index").html(data);
            }, 
            type:"POST", 
            url:"\/people\/loan"
        });
    return false;
    });
});