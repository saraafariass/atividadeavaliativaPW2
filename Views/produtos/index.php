<?php 
if(isset($_SESSION['usuario_logado'])){
    if($_SESSION['usuario_logado']->usuarios_nivel == 2){

?>

        <div class="container pt-4 pb-5 bg-light">
            <h2 class="border-bottom border-2 border-primary">
                <?= $data['pagina'] ?>
            </h2>

            <?php
            
            // Mensangem de retorno
            if(isset($_SESSION['msg'])){
                echo$_SESSION['msg']['texto'];
                #echo msg($data['msg']['texto'], $data['msg']['color']); 
            } 

            ?>
            <div class="container-fluid p-3">
                <form class="d-flex" action="<?php echo base_url('produtos/search'); ?>" role="search" method="POST">
                    <input class="form-control me-2" name="pesquisar" type="search" placeholder="Pesquisar" aria-label="Search">
                    <button type="submit" class="btn btn-outline-success" type="submit">pesquisar</button>
                </form>
            </div>

            <table class="table">
                <!-- Cabeçalho da tabela -->
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Preço de custo</th>
                        <th scope="col">Preço de venda</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">
                            <a class="btn btn-primary" href="<?php echo base_url('produtos/new'); ?>">
                            Novo
                            </a>
                        </th>
                    </tr>
                </thead>
                <!-- Corpo da tabela -->
                <tbody class="table-group-divider">
                    <?php 
                    foreach($data['produtos'] as $produtos ){?>
                    <tr>
                        <td><?= $produtos->produtos_id; ?></td>
                        <td><?= $produtos->produtos_nome; ?></td>
                        <td><?= $produtos->produtos_preco_custo; ?></td>
                        <td><?= $produtos->produtos_preco_venda; ?></td>
                        <td><?= $produtos->categorias_nome; ?></td>
                        <td>
                            <a class="btn btn-secondary" href="<?php echo base_url('produtos/edit/'.$produtos->produtos_id); ?>">Editar</a>
                            <a class="btn btn-danger" href="<?php echo base_url('produtos/delete/'.$produtos->produtos_id); ?>">Excluir</a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>

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