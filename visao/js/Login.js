function login() {
    if($("#Email").val() != "" && $("#Email").val().toString().indexOf('@') != -1 && $("#Senha").val() != "") {
        $.ajax({
            url: "../control/Login.php",
            type: "POST",
            dataType: 'json',
            data: $("#fLogin").serialize(),
            success: function (data) {
                if (!data.situacao) {
                    swal("Atenção", data.mensagem, "info")
                }else{
                    location.href = "./home";
                }
            }, error: function (errorThrown) {
                swal("Erro", "Erro: " + errorThrown, "error")
            }
        });
    }
}

$(function () {
    $("#btLogin").click(function () {
        login();
    });
});