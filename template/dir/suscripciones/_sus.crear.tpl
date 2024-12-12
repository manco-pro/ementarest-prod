{include file="_cabecera.tpl"}

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h4 mb-4 text-gray-800">{$stTITLE}</h1>

    {if ($stMENSAJE != '')}
        <h1 id="mensaje" class="h4 text-gray-900 mb-4 border-bottom-success">{$stMENSAJE}</h1>
    {/if}
    {if ($stERROR != '')}
        <h1 class="h4 text-gray-900 mb-4 border-bottom-danger">{$stERROR}</h1>
    {/if}
    <form method="POST" action="{$stACTION}" accept-charset="utf-8">
        <!-- Content Row -->
        <div class="row ">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{$stSUBTITLE}</h6>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="lojasSelect">Lojas</label>
                                <select class="form-control " id="lojasSelect" name="lojasSelect"
                                    {if isset($stLOJAS_DISABLED)}{$stLOJAS_DISABLED}{/if}>
                                    {$stLOJAS}
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="planosSelect">Planos</label>
                                <select class="form-control " id="planosSelect" name="planosSelect">
                                    {$stPLANOS}
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="typeSelect">tipo de subscri&ccedil;&atilde;o</label>
                                <select class="form-control " id="typeSelect" name="typeSelect">
                                    {$stTIPOS}
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inicio">In&iacute;cio da subscri&ccedil;&atilde;o</label>
                                <input type="date" class="form-control" name="inicio" id="inicio" value="{$stINICIO}"
                                    required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fin">Fin da subscri&ccedil;&atilde;o</label>
                                <input type="date" class="form-control inhabilitado" readonly name="fin" id="fin"
                                    value="{$stFIN}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="enabled">Suspenso</label>
                                <input type="checkbox" name="suspendido" id="suspendido" {$stSUSPENDIDO}>
                            </div>
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
                    <div><button type="submit" class="btn btn-primary" id="buttonForm" name="{$stBTN_ACTION}">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"> </i>
                            </span>
                            <span class="text">{$stBTN_ACTION}</span>
                        </button>
                        <a href="{$stRUTAS.sus}sus.listar.php" class="btn btn-dark">
                            <span class="icon text-white-50">
                                <i class="fas fa-undo"></i>
                            </span>
                            <span class="text">Retornar</span>
                        </a>
                    </div>
                    <div>
                        {if $stBTN_ACTION_D != ''}
                            <a href="{$stRUTAS.sus}sus.borrar.php?id={$stID}" class="btn btn-danger" id="borrar"
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
        <input name="id" type="hidden" value="{$stID|default:''}">
        <input name="loja_id" type="hidden" value="{$stLOJA_ID|default:''}">
    </form>
</div>
<!-- /.container-fluid -->

</div>

<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->

<script src="{$stRUTAS.vendor}jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $("#borrar").click(function(event) {
            event.preventDefault();
            var url = $(this).attr("href");
            if (confirm(
                    "O cat\u00E1logo e os produtos a ele associados ser\u00E3o exclu\u00EDdos permanentemente. Voc\u00EA tem certeza que quer continuar?"
                )) {
                window.location.href = url;
            } else {
                return false;
            }
        });
        $(document).ready(function() {
            $('#logo').change(function() {
                validarImagen(this);
            });

            $('#inicio').change(function() {
                SetFechaFin();
            });
            $('#typeSelect').change(function() {
                SetFechaFin();
            });

        });

        function SetFechaFin() {

            var inicio = $('#inicio').val();
            var type = $('#typeSelect').val();
            var fecha = new Date(inicio);
            var fin = new Date(inicio);
            if (type == 'M') {
                fin.setMonth(fecha.getMonth() + 1);
            } else {
                fin.setFullYear(fecha.getFullYear() + 1);
            }
            $('#fin').val(fin.toISOString().slice(0, 10));

        }

    });
</script>

{include file="_pie.tpl"}