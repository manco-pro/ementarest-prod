{include file="_cabecera.tpl"}
<div class="card shadow">
    <form method="POST" name="lojas_select" id="lojas_select" action="{$stACTION}" accept-charset="utf-8">

        {if ($stSUPER_ADMIN == 'S')}

            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                <div class="col-lg-4">
                    <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
                    <select class="form-control" id="lojasSelect" name="loja_id">
                        {$stLOJAS_SELECT}
                    </select>
                </div>
                <div>
                    {if $stLOJA_ID !=-1}
                        <a href="{$stRUTAS.qr}qr.listar.php?pdf={$stLOJA_ID}"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-plus-circle fa-sm text-white-50"></i> Descarga QR's</a>
                    {/if}
                </div>
            </div>
        {else}
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
                <a href="{$stRUTAS.mes}mes.listar.php?pdf={$stLOJA_ID}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus-circle fa-sm text-white-50"></i> Descarga QR's</a>
            </div>
        {/if}
    </form>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Mesas</button>
            <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">QR's</button>
        </div>
    </nav>
    <div class="tab-content mt-4" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="row" id="mesas">
                <div id="result">
                    <div class="table-responsive">
                        <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Mesa</th>
                                    <th>Act.</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Mesa</th>
                                    <th>Act.</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                {foreach from=$stVALUES key=id item=value}
                                    <tr id="Row_{$value.id}"
                                        class="{if $value.enabled != 'S'}bg-gray-200 text-gray-900{/if}">
                                        <td>
                                            <p class="ta">{$value.identificador}</p>
                                        </td>
                                        <td>
                                            <div class="checkbox-wrapper-14 ta ">
                                                <input id="Check_{$id}" type="checkbox" class="switch"{if $value.enabled == 'S'}checked{/if}>
                                                <label id="Lab_{$id}" for="Check_{$id}">{if $value.enabled == 'S'}Ativo{else}Inat.{/if}</label>
                                            </div>
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="row" id="dashboard_final">
                <div id="result_final"></div>
                <div class="row">
                    {foreach from=$stQR_VALUES key=id item=value}
                        <div class="col-xl-2 col-md-4 mb-4">
                            <div class="card shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            {$value}
                                        </div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <img src="{$stRUTAS.qrs}{$stLOJA_ID}/{$value}">
                                        <a href="{$stRUTAS.qrs}{$stLOJA_ID}/{$value}" download>Descargar archivo</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>    

<!-- Page level plugins -->
<script src="{$stRUTAS.vendor}jquery/jquery.js"></script>
<script src="{$stRUTAS.vendor}datatables/jquery.dataTables.min.js"></script>
<script src="{$stRUTAS.vendor}datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [1, "asc"]
            ],
            "stateSave": true
        });

        $('#lojasSelect').change(function() {
            $('#lojas_select').submit();
        });

        $('.switch').change(function() {
            var id = $(this).attr('id').split('_')[1];
            var isChecked = $(this).is(':checked');
            var valueToSend = isChecked ? 'S' : 'N';

            $.ajax({
                url: '{$stRUTAS.mes}mes.listar.php',
                type: 'POST',
                data: {
                    Cid: id,
                    Cvalue: valueToSend
                },
                success: function(response) {
                    if (response == 'ok') {
                        if (isChecked) {
                            $('#Row_' + id).removeClass('bg-gray-200 text-gray-900');
                            $('#Lab_' + id).text('Ativo');
                        } else {
                            $('#Row_' + id).addClass('bg-gray-200 text-gray-900');
                            $('#Lab_' + id).text('Inat.');
                        }
                    } else {
                        alert('Error al actualizar el estado de la mesa');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error al enviar la solicitud AJAX');
                    console.log('Estado: ' + status);
                    console.log('Error: ' + error);
                }
            });
        });
    });
</script>

<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
{include file="_pie.tpl"}