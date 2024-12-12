{include file="_cabecera.tpl"}

<link rel="stylesheet" href="{$stRUTAS.vendor}select2/select2.min.css">
<form method="POST" id="miFormulario" action="{$stACTION}" accept-charset="utf-8">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h4 mb-4 text-gray-800">{$stTITLE}</h1>
        {if ($stMENSAJE != '')}
            <h1 id="mensaje" class="h4 text-gray-900 mb-4 border-bottom-success">{$stMENSAJE}</h1>
        {/if}
        {if ($stERROR != '')}
            <h1 class="h4 text-gray-900 mb-4 border-bottom-danger">{$stERROR}</h1>
        {/if}
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-3">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{$stSUBTITLE}</h6>
                    <p class='mb-0 small' style="text-align: justify">Ao escolher um produto e inserir a quantidade
                        m&iacute;nima desejada, voc&ecirc; est&aacute; configurando um alerta para o sistema notificar quando o estoque
                        desse produto estiver abaixo do n&uacute;mero informado. Al&eacute;m disso, ao adicionar a quantidade
                        dispon&iacute;vel do produto, voc&ecirc; est&aacute; atualizando o estoque desse produto.</p>
                    <p class='mb-0 small' style="text-align: justify">
                        O "Stock m&iacute;nimo" dispon&iacute;vel &eacute; calculado como 20% do estoque esperado. Por exemplo, se voc&ecirc;
                        definir o m&iacute;nimo como 10 unidades, o sistema calcular&aacute; que 50 unidades &eacute; o total de 100% do seu
                        estoque.
                    </p>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="coleccionSelect">Produto</label>
                                <select class="form-control select2" id="coleccionSelect" name="coleccionSelect"
                                    {$stDISABLE}>
                                    {$stCOLECCION_SELECT}
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="minimo">Minimo</label>
                                <input type="text" class="form-control" id="minimo" name="minimo" value="{$stMINIMO}">
                            </div>
                            {if !isset($stDISABLE)}
                                <div class="form-group col-md-4">
                                    <label for="precio">Dispon&iacute;vel</label>
                                    <input type="text" class="form-control" id="cantidad" name="cantidad"
                                        value="{$stCANTIDAD}">
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-8">
                <div class="d-sm-flex align-items-center justify-content-between mb-3 ">
                    <div><button type="submit" class="btn btn-primary" id="buttonForm" name="{$stBTN_ACTION}">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"> </i>
                            </span>
                            <span class="text">{$stBTN_ACTION}</span>
                        </button>
                        <a href="{$stRUTAS.stk}stk.listar.php?loja_id={$stLOJA_ID}" class="btn btn-dark">
                            <span class="icon text-white-50">
                                <i class="fas fa-undo"></i>
                            </span>
                            <span class="text">Retornar</span>
                        </a>
                    </div>
                    <div>
                        {if $stBTN_ACTION_D != ''}
                            <a href="{$stRUTAS.stk}stk.borrar.php?id={$stID}" class="btn btn-danger" id="borrar"
                                name="{$stBTN_ACTION_D}">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash-alt"> </i>
                                </span>
                                <span class="text">{$stBTN_ACTION_D}</span>
                            </a>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input name="id" type="hidden" value="{$stID}">
    <input name="loja_id" type="hidden" value="{$stLOJA_ID}">
</form>

</div>
<!-- /.container-fluid -->


<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->

<script src="{$stRUTAS.vendor}jquery/jquery.min.js"></script>
<script src="{$stRUTAS.vendor}select2/select2.min.js"></script>
<script>
    $(document).ready(function() {

        $('.select2').select2({
            selectionCssClass: 'border-1 '
        });
        // Capturar el clic en el bot&oacute;n

    });
</script>
{include file="_pie.tpl"}