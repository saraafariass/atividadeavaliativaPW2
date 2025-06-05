<?php 
require_once("../Config/Helpers.php");
if(isset($_SESSION['usuario_logado'])){
    if($_SESSION['usuario_logado']->usuarios_nivel == 2){
?>


    <div class="container">
        <h1><?= $pagina ?></h1>

        <?php if(isset($_SESSION['msg'])){ ?>
            <div class="alert alert-<?= $_SESSION['msg']['color'] ?>">
                <?= $_SESSION['msg']['texto'] ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
        <?php } ?>

        <form method="GET" action="<?= base_url('carros/search') ?>" class="mb-4">
            <div class="input-group">
                <input type="text" name="pesquisar" class="form-control" placeholder="Pesquisar por modelo...">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <a href="<?= base_url('carros/new') ?>" class="btn btn-success mb-3">Novo Carro</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Placa</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($carros as $carro): ?>
                <tr>
                    <td><?= $carro->carros_modelo ?></td>
                    <td><?= $carro->marca_nome ?? 'N/A' ?></td>
                    <td><?= $carro->carros_placa ?></td>
                    <td>
                        <a href="<?= base_url('carros/edit/' . $carro->carros_id) ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="<?= base_url('carros/delete/' . $carro->carros_id) ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
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