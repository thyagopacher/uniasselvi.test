function excluirTudo() {
    swal({
        title: "Deseja excluir clientes selecionados?",
        text: "Uma vez apagado, você não poderá mais recuperar estas informações!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/control/ExcluirClientesSelecionados.php",
                type: "POST",
                data: $("#fExcluirCliente").serialize(),
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data.situacao) {
                        swal("Cliente", data.mensagem, "success");
                        $("#btProcurarCliente").click();
                    } else {
                        swal("Atenção", data.mensagem, "error");
                    }
                }, error: function (errorThrown) {
                    swal("Erro", "Erro causado por:" + errorThrown, "error");
                }
            });
        }
    });
}

function excluirCliente(codigo) {
    if (codigo > 0) {
        swal({
            title: "Deseja excluir este cliente?",
            text: "Uma vez apagado, você não poderá mais recuperar as informações dele!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "/control/ExcluirCliente.php",
                    type: "POST",
                    data: {CodCliente: codigo},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao) {
                            swal("Cliente", data.mensagem, "success");
                            $("#btProcurarCliente").click();
                        } else {
                            swal("Atenção", data.mensagem, "error");
                        }
                    }, error: function (errorThrown) {
                        swal("Erro", "Erro causado por:" + errorThrown, "error");
                    }
                });
            }
        });
    }
}

$("#btSalvarCliente").click(function () {
    $.ajax({
        url: "/control/SalvarCliente.php",
        type: "POST",
        data: $("#fcliente").serialize(),
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            if (data.situacao) {
                swal("Cliente", data.mensagem, "success");
                $("#fcliente input").val('');
                window.history.pushState("", "Cadastro de cliente", "/cliente");
            } else {
                swal("Atenção", data.mensagem, "error");
            }
        }, error: function (errorThrown) {
            swal("Erro", "Erro causado por:" + errorThrown, "error");
        }
    });
});

$("#btProcurarCliente").click(function () {
    var buttonCommon = {
        exportOptions: {
            columns: [0, 1, 2]
        }
    };
    $.ajax({
        url: "/control/ProcurarCliente.php",
        type: "POST",
        data: $("#fpcliente").serialize(),
        dataType: 'text',
        success: function (data, textStatus, jqXHR) {
            $("#listagemCliente").html(data);
            $('#tCliente').DataTable({
                "lengthMenu": [[5, 10, 20, 40, -1], [5, 10, 20, 40, "All"]],
                "pageLength": 20,
                "searching": false,
                dom: 'Blfrtip',
                "language": lngPt,
                buttons: [
                    $.extend(true, {}, buttonCommon, {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF'
                    })
                ]
            });
            $("#btExcluirTudo").hide();
        }, error: function (errorThrown) {
            swal("Erro", "Erro causado por:" + errorThrown, "error");
        }
    });
});