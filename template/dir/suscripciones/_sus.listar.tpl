{include file="_cabecera.tpl"}
<div class="card shadow ">
    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
        <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
        <a href="{$stRUTAS.sus}sus.crear.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus-circle fa-sm text-white-50"></i> criar nova Subscri&ccedil;&atilde;o</a>
    </div>
    <div class="table-responsive">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="max-width:90px;"></th>
                    <th>Loja</th>
                    <th>Plano</th>
                    <th>Tipo</th>
                    <th>In&iacute;cio da subs.</th>
                    <th>Fin da subs.</th>
                    <th>Act.</th>
                    
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th style="max-width:90px;"></th>
                    <th>Loja</th>
                    <th>Plano</th>
                    <th>Tipo</th>
                    <th>In&iacute;cio da subs.</th>
                    <th>Fin da subs.</th>
                    <th>Act.</th>
                    
                </tr>
            </tfoot>
            <tbody>
                {if $stVALUES != false}
                    {foreach from=$stVALUES key=id item=value}
                        <tr id="Row_{$value.id}" class={if $value.active != "Ativo"}"bg-gray-200 text-gray-900" {/if}>
                            <td>
                                <a href="{$stRUTAS.sus}sus.modificar.php?id={$id}" class="btn-sm btn-primary btn-circle ta"><i
                                        class="fas fa-edit" title="Editar"></i></a>
                            </td>
                            <td>
                                <p class="ta">
                                    <a id="link_{$value.id}" class="{if $value.active != "Ativo"}text-gray-900{/if}"
                                        href="{$stRUTAS.sus}sus.modificar.php?id={$id}">{$value.nombre|truncate:60:'...':true}</a>
                                </p>
                            </td>
                            <td>
                                <p class="ta">{$value.plano}</p>
                            </td>
                            <td>
                                <p class="ta">{$value.type}</p>
                            </td>
                            <td>
                                <p class="ta">{$value.inicio}</p>
                            </td>
                            <td>
                                <p class="ta">{$value.fin}</p>
                            </td>
                            <td>
                                <p class="ta">{$value.active}</p>
                            </td>
                            
                        </tr>
                    {/foreach}
                {/if}
            </tbody>
        </table>
    </div>

    <!-- Page level plugins -->
    <!-- Content Row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
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
    });
</script>

<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->
{include file="_pie.tpl"}