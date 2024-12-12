{include file="_cabecera.tpl"}
<div class="card shadow ">
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
                        <a href="{$stRUTAS.stk}stk.crear.php?loja_id={$stLOJA_ID}"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo stock</a>
                    {/if}
                </div>
            </div>
        {else}
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
                <a href="{$stRUTAS.stk}stk.crear.php?loja_id={$stLOJA_ID}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo stock</a>
            </div>
        {/if}
    </form>
    <div class="table-responsive">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="max-width:50px;"></th>
                    <th>Produto</th>
                    <th>Qtd. Minino</th>
                    <th>Qtd. Dispon&iacute;vel</th>
                    <th>Nivel de Stock (%)</th>
                    <th style="max-width:55px;">Apagar</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Produto</th>
                    <th>Qtd. Minimo</th>
                    <th>Qtd. Dispon&iacute;vel</th>
                    <th>Nivel de Stock (%)</th>
                    <th>Apagar</th>
                </tr>
            </tfoot>
            <tbody>
                {if $stVALUES != false}
                    {foreach from=$stVALUES key=id item=value}
                        <tr id="Row_{$value.id}">
                            <td>
                                <a href="{$stRUTAS.stk}stk.modificar.php?id={$value.id}"
                                    class="btn-sm btn-primary btn-circle ta">
                                    <i class="fas fa-edit" title="Editar"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{$stRUTAS.stk}stk.modificar.php?id={$id}">
                                    <p class="ta">{$value.nombre_pt|truncate:70:'...':true}</p>
                                </a>
                            </td>
                            <td>
                                <p class="ta">{$value.minimo|truncate:70:'...':true}</p>
                            </td>
                            <td>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-6 d-flex justify-content-start">
                                            <p class="text-start aling-middle ta">
                                                {$value.cantidad|truncate:70:'...':true}</p>
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            <a href="{$stRUTAS.stk}stk.stock_detalle.php?id={$id}"
                                                class="btn-sm btn-{$value.color1} btn-circle ta">
                                                <i class="fas fa-eye" title="Consultar"></i>
                                            </a>
                                        </div>
                                    </div>
                            </td>
                            <td>
                                <p class="ta">{$value.porcentaje|truncate:70:'...':true}</p>
                            </td>
                            <td>
                                <a href="{$stRUTAS.stk}stk.borrar.php?id={$value.id}&loja_id={$stLOJA_ID}"
                                    id="borrar{$value.id}" class="btn-sm btn-danger btn-circle ta">
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
        $(document).on('change', 'select#lojasSelect', function() {
            $('form#lojas_select').submit();
        });

        $(document).on('click', "a[id^='borrar']", function(event) {
            event.preventDefault();
            var url = $(this).attr("href");
            if (confirm(
                    "O Controle de Stock e todos os seus detalhes ser\u00E3o exclu\u00EDdos permanentemente. Voc\u00EA tem certeza que quer continuar?"
                )) {
                window.location.href = url;
            } else {
                return false;
            }
        });
        $(document).ready(function() {
            $(document).on('change', '.switch', function() {
                var id = $(this).attr('id').split('_')[1]; // Obtener el ID del checkbox
                var isChecked = $(this).is(
                    ':checked'); // Verificar si el checkbox est&aacute; marcado
                var valueToSend = isChecked ? 'S' :
                    'N'; // Establecer el valor a enviar al servidor

                // Enviar datos al servidor usando AJAX
                $.ajax({
                    url: '{$stRUTAS.cat}cat.listar.php', // URL del script en el servidor
                    type: 'POST',
                    data: {
                        Cid: id,
                        Cvalue: valueToSend
                    }, // Datos a enviar al servidor

                    success: function(response) {
                        // Acciones a realizar si la solicitud se completa exitosamente
                        if (response == 'ok') {
                            if (isChecked) {
                                // Si el checkbox est&aacute; marcado, remover las clases bg-gray-500 y text-gray-100
                                $('#Row_' + id).removeClass(
                                    'bg-gray-500 text-gray-100');
                                $('#Lab_' + id).text('Ativo');
                            } else {
                                // Si el checkbox est&aacute; desmarcado, agregar las clases bg-gray-500 y text-gray-100
                                $('#Row_' + id).addClass(
                                    'bg-gray-500 text-gray-100');
                                $('#Lab_' + id).text('Inat.');
                            }
                        } else {
                            alert(
                                'Error al actualizar el estado del cat&aacute;logo'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        // Acciones a realizar si la solicitud falla
                        console.log('Error al enviar la solicitud AJAX');
                        console.log('Estado: ' + status);
                        console.log('Error: ' + error);
                    }
                });
            });
        });
    });
</script>

<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->
{include file="_pie.tpl"}