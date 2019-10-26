function excluirProduto(codigo) {
    if (codigo > 0) {
        swal({
            title: "Deseja excluir este produto?",
            text: "Uma vez apagado, você não poderá mais recuperar as informações dele!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "/control/ExcluirProduto.php",
                    type: "POST",
                    data: {CodProduto: codigo},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao) {
                            swal("Produto", data.mensagem, "success");
                            $("#btProcurarProduto").click();
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

$("#btSalvarProduto").click(function () {
    $.ajax({
        url: "/control/SalvarProduto.php",
        type: "POST",
        data: $("#fproduto").serialize(),
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            if (data.situacao) {
                swal("Produto", data.mensagem, "success");
                $("#fproduto input").val('');
                window.history.pushState("", "Cadastro de produto", "/produto");
            } else {
                swal("Atenção", data.mensagem, "error");
            }
        }, error: function (errorThrown) {
            swal("Erro", "Erro causado por:" + errorThrown, "error");
        }
    });
});

$("#btProcurarProduto").click(function () {
    var buttonCommon = {
        exportOptions: {
            columns: [0, 1, 2]
        }
    };
    $.ajax({
        url: "/control/ProcurarProduto.php",
        type: "POST",
        data: $("#fpproduto").serialize(),
        dataType: 'text',
        success: function (data, textStatus, jqXHR) {
            $("#listagemProduto").html(data);
            $('#tProduto').DataTable({
                "lengthMenu": [[5,10, 20, 40, -1], [5,10, 20, 40, "All"]],
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
        }, error: function (errorThrown) {
            swal("Erro", "Erro causado por:" + errorThrown, "error");
        }
    });
});