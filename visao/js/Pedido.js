function excluirItemPedido(CodItem, NumPedido) {
    if (CodItem > 0) {
        swal({
            title: "Deseja excluir este item pedido?",
            text: "Uma vez apagado, você não poderá mais recuperar as informações dele!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "/control/ExcluirItemPedido.php",
                    type: "POST",
                    data: {CodItem: CodItem},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao) {
                            swal("Item Pedido", data.mensagem, "success");
                            listarItensPedido(NumPedido);
                            $("#btProcurarPedido").click();
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

function excluirTudo() {
    swal({
        title: "Deseja excluir pedidos selecionados?",
        text: "Uma vez apagado, você não poderá mais recuperar estas informações!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "/control/ExcluirPedidosSelecionados.php",
                type: "POST",
                data: $("#fExcluirPedido").serialize(),
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data.situacao) {
                        swal("Pedido", data.mensagem, "success");
                        $("#btProcurarPedido").click();
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

function excluirPedido(codigo) {
    if (codigo > 0) {
        swal({
            title: "Deseja excluir este pedido?",
            text: "Uma vez apagado, você não poderá mais recuperar as informações dele!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "/control/ExcluirPedido.php",
                    type: "POST",
                    data: {NumPedido: codigo},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data.situacao) {
                            swal("Pedido", data.mensagem, "success");
                            $("#btProcurarPedido").click();
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

function removerLinha(linha) {
    $("#item" + linha).remove();
}

function adicionarLinha(linha) {
    var html = "";
    var proxLinha = linha + 1;
    html += `<div class="col-md-12" id="item${linha}">`;
    html += `<select name="CodProduto[]" id="CodProduto${linha}" class="form-control col-md-5">`;
    html += `</select> `;
    html += `<input type="number" name="Quantidade[]" id="Quantidade${linha}" onkeyup="verificaTotal(${linha});" class="form-control col-md-2 inteiro" maxlength="999" minlength="1"/> `;
    html += `<input type="text" disabled id="VlTotal${linha}" class="form-control col-md-2" placeholder="Vl. Total"/> `;
    html += '<div class="col-md-2">';
    html += `<button class="btn btn-primary" onclick="adicionarLinha(${proxLinha})">+</button> `;
    html += `<button class="btn btn-danger" onclick="removerLinha(${linha})">-</button> `;
    html += `</div>`;
    html += `</div>`;
    $("#itensPedidos").append(html);
    var optionsHTML = $("datalist#ListaProduto").html();
    $("#CodProduto" + linha).html(optionsHTML);
}

function verificaTotal(linha) {
    if ($("#Quantidade" + linha).val() == "") {
        $("#VlTotal" + linha).val("");
    } else {
        var qtd = parseInt($("#Quantidade" + linha).val());
        var vlUnitario = parseFloat($("#CodProduto" + linha + " option:selected").attr('valor'));
        var total = qtd * vlUnitario;
        $("#VlTotal" + linha).val(total.toFixed(2).toString().replace('.', ','));
    }
}

function listarItensPedido(codpedido) {
    var buttonCommon = {
        exportOptions: {
            columns: [0, 1, 2]
        }
    };
    $.ajax({
        url: "/control/ProcurarItemPedido.php",
        type: "POST",
        data: {NumPedido: codpedido},
        dataType: 'text',
        success: function (data, textStatus, jqXHR) {
            if (data != "") {
                $("#mItensPedidos .modal-body").html(data);
                $('#tItemPedido').DataTable({
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
                $("#mItensPedidos").modal();
            }
        }, error: function (errorThrown) {
            swal("Erro", "Erro causado por:" + errorThrown, "error");
        }
    });

}

$(document).ready(function () {

    if ($("#NumPedido").val() == "" || $("#itensPedidos").html().toString().trim() == "") {
        adicionarLinha(1);
    }
    $("#btSalvarPedido").click(function () {
        $.ajax({
            url: "/control/SalvarPedido.php",
            type: "POST",
            data: $("#fpedido").serialize(),
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                if (data.situacao) {
                    swal("Pedido", data.mensagem, "success");
                    $("#fpedido input, #fpedido select").val('');
                    $("#itensPedidos").html('');
                    window.history.pushState("", "Cadastro de Pedidos", "/pedido");
                } else {
                    swal("Atenção", data.mensagem, "error");
                }
            }, error: function (errorThrown) {
                swal("Erro", "Erro causado por:" + errorThrown, "error");
            }
        });
    });

    $("#btProcurarPedido").click(function () {
        var buttonCommon = {
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6]
            }
        };
        $.ajax({
            url: "/control/ProcurarPedido.php",
            type: "POST",
            data: $("#fppedido").serialize(),
            dataType: 'text',
            success: function (data, textStatus, jqXHR) {
                $("#listagemPedido").html(data);
                $('#tPedido').DataTable({
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
});

