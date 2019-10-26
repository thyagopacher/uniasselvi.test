var lngPt = {
    "lengthMenu": "Mostrando _MENU_ resultados por pág.",
    "zeroRecords": "Nada encontrado - desculpe",
    "info": "Mostrando pág _PAGE_ de _PAGES_",
    "infoEmpty": "Nenhum resultado disponivel",
    "infoFiltered": "(filtrando de _MAX_ total resultados)",
    "search": 'Procurar',
    "paginate": {
        "previous": "Pág. ant.",
        "next": "Próx. pág."
    }
};



function optionClientes() {
    $.ajax({
        url: "/control/OptionClientes.php",
        type: "POST",
        dataType: 'text',
        data: {CodCliente: CodCliente},
        success: function (data, textStatus, jqXHR) {
            if (data != "") {
                $("select#CodCliente").html(data);
            } 
        }, error: function (errorThrown) {
            swal("Erro", "Erro causado por:" + errorThrown, "error");
        }
    });
}

function optionProdutos() {
    $.ajax({
        url: "/control/OptionProdutos.php",
        type: "POST",
        dataType: 'text',
        success: function (data, textStatus, jqXHR) {
            if (data != "") {
                $("select#CodProduto").html(data);
            } 
        }, error: function (errorThrown) {
            swal("Erro", "Erro causado por:" + errorThrown, "error");
        }
    });
}

$(function() {
    if ($(".inteiro").length) {
        $('.inteiro').keypress((event) => {
            var tecla = verificaTelaPressionada(event);
            return (tecla > 47 && tecla < 58) || tecla === 8;
        });
    }    
    
    $(".real").maskMoney({showSymbol: true, symbol: "R$", decimal: ",", thousands: ""});
    
    if($("select#CodCliente").length){
        optionClientes()
    }
    if($("select#CodProduto").length){
        optionProdutos();
    }
});