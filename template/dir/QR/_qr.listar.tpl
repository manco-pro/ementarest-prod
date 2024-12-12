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
                            <i class="far fa-file-pdf"></i> criar PDF</a>
                    {/if}
                </div>
            </div>
        {else}
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
                <a href="{$stRUTAS.qr}qr.listar.php?pdf={$stLOJA_ID}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">  
                    <i class="far fa-file-pdf "></i> criar PDF</a>
            </div>
        {/if}
    </form>


    <div class="row">
        {foreach from=$stVALUES key=id item=value}
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
                ]
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