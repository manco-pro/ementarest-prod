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
            <div class="col-lg-2">
                <h6 class="m-0 font-weight-bold text-primary">{$stSUBTITLE}{$stCOLECCION}</h6>
                <b>Stock: {$stCANTIDAD}</b>
                <div class="card-body py-3">
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="cantidad">Stock a Mov.</label>
                                <input type="text" class="form-control" id="movimiento" name="movimiento"
                                    value="{$stMOVIMIENTO}" required>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="comentario">Coment&aacute;rio</label>
                                <input type="text" class="form-control" id="comentario" name="comentario"
                                    value="{$stCOMENTARIO}" placeholder="Insira a Coment&aacute;rio">

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
        <hr>
        <br>
        <div>
            <div class="row">
                <div class="col-lg-2">
                    <h6 class="m-0 font-weight-bold text-primary">Hist&oacute;rico do produto</h6>
                </div>
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="table-responsive card-body border-left-secondary">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Qta.</th>
                                        <th>Usu&aacute;rio</th>
                                        <th>Comentario</th>
                                        <th style="max-width:50px;">Apagar</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Qta.</th>
                                        <th>Usu&aacute;rio</th>
                                        <th>Comentario</th>
                                        <th style="max-width:50px;">Apagar</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    {if $stVALUES != false}
                                        {foreach from=$stVALUES key=id item=value}
                                            <tr id="Row_{$value.id}">
                                                <td>
                                                    <p style="margin: 0.5rem 0 0 0 !important;">{$value.date}</p>
                                                </td>
                                                <td>
                                                    <p style="margin: 0.5rem 0 0 0 !important;">{$value.cantidad}</p>
                                                </td>
                                                <td>
                                                    <p style="margin: 0.5rem 0 0 0 !important;">
                                                        {$value.nombre|truncate:70:'...':true}</p>
                                                </td>
                                                <td>
                                                    <p style="margin: 0.5rem 0 0 0 !important;">{$value.comentario}</p>
                                                </td>
                                                <td>
                                                    <a href="{$stRUTAS.stk}stk.borrar_detalle.php?id={$value.id}&loja_id={$stLOJA_ID}"
                                                        id="borrar{$value.id}" class="btn btn-danger  btn-circle">
                                                        <i class="fas fa-trash-alt" title="Eliminar"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        {/foreach}
                                    {/if}
                                </tbody>
                            </table>
                        </div>
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
<script src="{$stRUTAS.vendor}datatables/jquery.dataTables.min.js"></script>
<script src="{$stRUTAS.vendor}datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [1, "asc"]
            ],
"stateSave": true
        });
    });
</script>
{include file="_pie.tpl"}