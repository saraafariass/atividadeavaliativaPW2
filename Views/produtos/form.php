<?php 
if(isset($_SESSION['usuario_logado'])){
    if($_SESSION['usuario_logado']->usuarios_nivel == 2){

?>
        <div class="container pt-4 pb-5 bg-light">
            
            <h2 class="border-bottom border-2 border-primary">
                <?= ucfirst($data['pagina']) ?>
            </h2>
            <form action="<?php echo base_url('produtos/'.$data['method']); ?>" method="post">
                <div class="mb-3">
                    <label for="produtos_nome" class="form-label"> Produto</label>
                    <input type="text" class="form-control" name="produtos_nome" value="<?= $data['produtos']->produtos_nome; ?>"  id="produtos_nome">
                </div>

                <div class="mb-3">
                    <label for="produtos_descricao" class="form-label"> Descrição </label>
                    <textarea name="produtos_descricao" class="form-control" id="produtos_descricao"><?= $data['produtos']->produtos_descricao; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="produtos_preco_custo" class="form-label"> Preço custo</label>
                    <input type="text" class="form-control" name="produtos_preco_custo" value="<?= $data['produtos']->produtos_preco_custo; ?>"  id="produtos_preco_custo">
                </div>

                <div class="mb-3">
                    <label for="produtos_preco_venda" class="form-label"> Preço venda</label>
                    <input type="text" class="form-control" name="produtos_preco_venda" value="<?= $data['produtos']->produtos_preco_venda; ?>"  id="produtos_preco_venda">
                </div>

                <div class="mb-3">
                    <label for="produtos_categorias_id" class="form-label"> Categorias</label>
                    <select class="form-control" name="produtos_categorias_id" id="produtos_categorias_id">
                        <?php 
                        for($i=0; $i < count($data['categorias']);$i++){
                            $selected = "";
                            if($data['categorias'][$i]->categorias_id ==
                             $data['produtos']->produtos_categorias_id){
                                $selected = "selected";
                            } 
                            ?>  
                        ?>

                        <option <?= $selected ?> value="<?= $data['categorias'][$i]->categorias_id?>">
                            <?= $data['categorias'][$i]->categorias_nome?>
                        </option>

                        <?php } ?>

                    </select>

                    
                </div>

                <input type="hidden" name="produtos_id" value="<?= $data['produtos']->produtos_id; ?>" >

                <div class="mb-3">
                    <input class="btn btn-success" type="submit" name="<?= $data['method']; ?>" value="Salvar">
                </div>
            
            </form>

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