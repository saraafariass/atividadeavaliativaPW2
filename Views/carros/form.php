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

        <form method="POST" action="<?= base_url('carros/' . $method) ?>">
            <input type="hidden" name="carros_id" value="<?= $carros->carros_id ?>">

            <div class="form-group">
                <label>Modelo*</label>
                <input type="text" name="carros_modelo" class="form-control" 
                       value="<?= $carros->carros_modelo ?>" required>
            </div>

            <div class="form-group">
                <label>Marca*</label>
                <select name="marca_id" class="form-control" required>
                    <option value="">Selecione</option>
                    <?php
                    $db = new Conexao('marcas');
                    $marcas = $db->select()->fetchAll(PDO::FETCH_OBJ);
                    foreach($marcas as $marca){
                        $selected = ($marca->id == $carros->marca_id) ? 'selected' : '';
                        echo "<option value='{$marca->id}' $selected>{$marca->nome}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Placa* (Formato: ABC-1A34)</label>
                <input type="text" name="carros_placa" class="form-control" 
                       value="<?= $carros->carros_placa ?>" 
                       pattern="[A-Z]{3}-\d{1}[A-Z]{1}\d{2}" 
                       title="Formato: ABC-1A34" required>
            </div>

            <div class="form-group">
                <a href="<?= base_url('carros') ?>" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php 
    } else {
        $msg = ['texto' => 'Acesso negado!', 'color' => 'danger'];
        $this->redirect(base_url('home'), $msg);
    }
} else {
    $msg = ['texto' => 'Faça login primeiro!', 'color' => 'danger'];
    $this->redirect(base_url('login'), $msg);
}
?>