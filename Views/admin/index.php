<?php 
if(isset($_SESSION['usuario_logado'])){
    if($_SESSION['usuario_logado']->usuarios_nivel == 2){

?>

        <div class="container pt-4 pb-5 bg-light">
            <h2 class="border-bottom border-2 border-primary">
                Página Administrativa
            </h2>

            <?php print_r($_SESSION['usuario_logado']) ?>
        </div>


<?php
    }else{
        $msg = "Sem permissão de acesso";
        redirectPage(base_url('login'), $msg);

    }
}else{
    $msg = "Sem permissão de acesso";
    redirectPage(base_url('login'), $msg);
}

?>