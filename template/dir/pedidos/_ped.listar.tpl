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
                        <a href="{$stRUTAS.ped}ped.crear.php?loja_id={$stLOJA_ID}"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo Pedido</a>
                    {/if}
                </div>
            </div>
        {else}
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
                <a href="{$stRUTAS.ped}ped.crear.php?loja_id={$stLOJA_ID}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo Pedido</a>
            </div>
        {/if}
    </form>
    <div class="table-responsive">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th></th>
                    <th>Pedido n&deg;</th>
                    <th>Data/hora de in&iacute;cio </th>
                    <th>Mesa</th>
                    <th>Gerado por</th>
                    <th>Estado</th>
                    <th>Montante</th>
                    <th></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Pedido n&deg;</th>
                    <th>Data/hora de in&iacute;cio </th>
                    <th>Mesa</th>
                    <th>Gerado por</th>
                    <th>Estado</th>
                    <th>Montante</th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
                {if $stVALUES != false}
                    {foreach from=$stVALUES key=id item=value}
                        <tr>
                            <td>
                                <a href="{$stRUTAS.ped}ped.modificar.php?id={$id}" class="btn-sm btn-primary btn-circle ta">
                                    <i class="fa fa-edit" title="Editar"></i>
                                </a>
                            </td>
                            <td>
                                <p class="ta">{$id}</p>
                            </td>
                            <td>
                                <p class="ta">{$value.hora_inicio}</p>
                            </td>
                            <td>
                                <p class="ta">{$value.mesa}</p>
                            </td>
                            <td>
                                <p class="ta">{$value.empleado}</p>
                            </td>
                            <td>
                                <p class="ta">{$value.estado}</p>
                            </td>
                            <td>
                                <p class="ta">{$value.total} &euro;</p>
                            </td>
                            <td>
                                <a href="{$stRUTAS.ped}ped.borrar.php?id={$id}" id="borrar{$id}"
                                    class="btn-sm btn-danger btn-circle ta">
                                    <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </td>
                        </tr>
                    {/foreach}
                {/if}
            </tbody>
        </table>
    </div>

    <!-- Page level plugins -->
    <script src="{$stRUTAS.vendor}jquery/jquery.js"></script>
    <script src="{$stRUTAS.vendor}datatables/jquery.dataTables.min.js"></script>
    <script src="{$stRUTAS.vendor}datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [
                    [2, "DESC"]
                ],
                "stateSave": true
            });
        });
        $(document).ready(function() {
            $('select#lojasSelect').on('change', function() {
                $('form#lojas_select').submit();
            });



            $(document).on('click', "a[id^='borrar']", function(event) {
                // Prevenir el comportamiento predeterminado del enlace
                event.preventDefault();

                // Obtener la URL del enlace
                var url = $(this).attr("href");

                // Mostrar cuadro de diálogo de confirmación
                if (confirm(
                        "O pedido ser\u00E1 removido permanentemente. Tem certeza de que deseja continuar?"
                    )) {
                    // Si el usuario acepta, redirigir a la URL del enlace
                    window.location.href = url;
                } else {
                    // Si el usuario cancela, no hacer nada
                    return false;
                }
            });
        });
    </script>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
{include file="_pie.tpl"}