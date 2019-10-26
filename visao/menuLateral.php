
<div id="vertical-menu">
    <?php 
        $arrayPagina = array('home', 'cliente', 'produto', 'pedido', 'sair');
        foreach ($arrayPagina as $paginaTxt) {
            $classeA = '';
            if($paginaTxt == $pagina){
                $classeA = "active";
            }
            echo '<a href="/',$paginaTxt,'" class="',$classeA,'">', ucfirst($paginaTxt),'</a>';
        }
    ?>
</div> 