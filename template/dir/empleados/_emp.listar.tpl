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
                        <a href="{$stRUTAS.emp}emp.crear.php?loja_id={$stLOJA_ID}"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo Empregado</a>
                    {/if}
                </div>
            </div>
        {else}
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
                <a href="{$stRUTAS.emp}emp.crear.php?loja_id={$stLOJA_ID}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo Empregado</a>
            </div>
        {/if}
    </form>
    <div class="table-responsive">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th></th>
                    <th>Sobrenome e Nome</th>
                    <th>Email</th>
                    <th>Telem&oacute;vel</th>
                    <th>Apagar<th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Sobrenome e Nome</th>
                    <th>Email</th>
                    <th>Telem&oacute;vel</th>
                    <th>Apagar<th>
                </tr>
            </tfoot>
            <tbody>
                {foreach from=$stVALUES key=id item=value}
                    <tr>
                        <td>
                            <a href="{$stRUTAS.emp}emp.modificar.php?id={$id}" class="btn-sm
                            btn-primary btn-circle ta">
                                <i class="fas fa-user-edit" title="Editar"></i>
                            </a>
                        </td>
                        <td>
                            <p class="ta">{$value.apellido} {$value.nombre|truncate:70:'...':true}</p>
                        </td>
                        <td>
                            <p class="ta">{$value.email|truncate:70:'...':true}</p>
                        </td>
                        <td>
                            <p class="ta">{$value.telefono|truncate:70:'...':true}</p>
                        </td>
                        <td>
                            <a href="{$stRUTAS.emp}emp.borrar.php?id={$id}" class="btn-sm
                            btn-danger btn-circle ta">
                                <i class="fas fa-trash" title="Apagar"></i>
                            </a>
                    </tr>
                {/foreach}
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
                    [1, "asc"]
                ],
                "stateSave": true
            });
        });
        $(document).ready(function() {
            $('select#lojasSelect').on('change', function() {
                $('form#lojas_select').submit();
            });
        });
    </script>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
{include file="_pie.tpl"}