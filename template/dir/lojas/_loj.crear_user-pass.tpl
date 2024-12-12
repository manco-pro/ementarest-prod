{include file="_cabecera.tpl"}
<link rel="stylesheet" href="{$stRUTAS.vendor}select2/select2.min.css">
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h4 mb-4 text-gray-800">{$stTITLE}</h1>

    {if ($stMENSAJE != '')}
        <h1 id="mensaje" class="h4 text-gray-900 mb-4 border-bottom-success">{$stMENSAJE}</h1>
    {/if}
    {if ($stERROR != '')}
        <h1 class="h4 text-gray-900 mb-4 border-bottom-danger">{$stERROR}</h1>
    {/if}
    <form method="post" action="{$stACTION}" accept-charset="UTF-8">
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{$stSUBTITLE}</h6>
                    <p class='mb-0 small'>Insira o nome da Loja.</p>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-group">
                            <label for="nombre">Nome</label>
                            <input type="text" class="form-control" name="nombre" id="nombre"
                                placeholder="Insira o nome" value="{$stNOMBRE}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Outras Informa&ccedil;&otilde;es</h6>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="empresa">Empresa</label>
                                <input type="text" class="form-control" name="empresa" id="empresa"
                                    placeholder="Insira o nome do Empresa" value="{$stEMPRESA}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="NIF">NIF</label>
                                <input type="text" class="form-control" name="nif" id="nif" placeholder="Insira o NIF"
                                    value="{$stNIF}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Endere&ccedil;o</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Insira e-mail" value="{$stEMAIL}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telefono">Telefone</label>
                                <input type="tel" class="form-control" name="telefono" id="telefono"
                                    placeholder="Insira o n&uacute;mero do telefone" value="{$stTELEFONO}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="morada">Morada</label>
                                <input type="text" class="form-control" name="morada" id="morada"
                                    placeholder="Insira o morada" value="{$stMORADA}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="freguesiaSelect">Freguesia</label>
                                <select class="form-control select2" id="freguesiaSelect" name="freguesia">
                                    {$stFREGUESIAS}
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="Mesas">N&deg; de mesas</label>
                                <input type="text" class="form-control" name="mesas" id="mesas"
                                    placeholder="Insira n&deg; de mesas" value="{$stMESAS}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">Senha</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Insira a senha" {if ($stBTN_ACTION != 'Modificar')} Required{/if}>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirmarPassword">Confirmar senha</label>
                                <input type="password" class="form-control" name="confirmarPassword"
                                    id="confirmarPassword" placeholder="Confirme a Senha"
                                    {if ($stBTN_ACTION != 'Modificar')} Required{/if}>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="checkbox" name="enabled" id="enabled" {$stENABLED}>
                            <label for="enabled">Habilitado</label>
                            <input name="id" type="hidden" value="{$stID|default:''}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">
                <div class="d-sm-flex align-items-center justify-content-between mb-3 ">
                    <button type="submit" class="btn btn-primary" name="{$stBTN_ACTION}">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"> </i>
                        </span>
                        <span class="text">{$stBTN_ACTION}</span>
                    </button>
                    <a href="{$stRUTAS.loj}loj.listar.php" class="btn btn-dark">
                        <span class="icon text-white-50">
                            <i class="fas fa-undo"></i>
                        </span>
                        <span class="text">Retornar</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Content Row -->
    </form>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->



<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->

<script src="{$stRUTAS.vendor}jquery/jquery.min.js"></script>
<script src="{$stRUTAS.vendor}select2/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            selectionCssClass: 'border-1 '
        });
    });
</script>

{include file="_pie.tpl"}