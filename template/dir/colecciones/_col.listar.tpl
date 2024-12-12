{include file="_cabecera.tpl"}
<div class="card shadow mb-4">
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
                        <a href="{$stRUTAS.col}col.crear.php?loja_id={$stLOJA_ID}"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo Produto</a>
                    {/if}
                </div>
            </div>
        {else}
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                <h6 class="m-0 font-weight-bold text-primary">{$stTITLE}</h6>
                <a href="{$stRUTAS.col}col.crear.php?loja_id={$stLOJA_ID}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus-circle fa-sm text-white-50"></i> criar novo Produto</a>
            </div>
        {/if}
    </form>
    <div class="table-responsive">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="max-width:90px;"></th>
                    <th>Produto</th>
                    <th>Cat&aacute;logo</th>
                    <th>Pre&ccedil;o</th>
                    <th>Ordem</th>
                    <th>Est.</th>
                    <th style="max-width:90px;">A&ccedil;&otilde;es</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Produto</th>
                    <th>Cat&aacute;logo</th>
                    <th>Pre&ccedil;o</th>
                    <th>Ordem</th>
                    <th>Est.</th>
                    <th>A&ccedil;&otilde;es</th>
                </tr>
            </tfoot>
            <tbody>
                {if $stVALUES != false}
                    {foreach from=$stVALUES key=id item=value}
                        <tr id="Row_{$value.id}" class={if $value.enabled != "S"} "bg-gray-500 text-gray-100" {/if}>
                            <td>
                                <a href="{$stRUTAS.col}col.modificar.php?id={$value.id}"
                                    class="btn-sm btn-primary btn-circle ta">
                                    <i class="fas fa-edit" title="Editar"></i>
                                </a>
                                <img style="max-width: 50px; max-height: auto;" src="{$stRUTAS.images_col}S{$value.imagen}">
                            </td>
                            <td>
                                <p class="ta">
                                    <a
                                        href="{$stRUTAS.col}col.modificar.php?id={$value.id}">{$value.coleccion|truncate:70:'...':true}</a>
                                </p>
                            </td>
                            <td>
                                <p class="ta">{$value.catalogo|truncate:70:'...':true}</p>
                            </td>
                            <td>
                                <p class="ta">{$value.precio|truncate:70:'...':true}</p>
                            </td>
                            <td>
                            <p class="ta">{if $value.orden != 0}{$value.orden}{else}N/A{/if}</p>
                            </td>
                            <td>
                                <div class="checkbox-wrapper-14 ta">
                                    <input id="Check_{$value.id}" type="checkbox" class="switch"
                                        {if $value.enabled == 'S'}checked{/if}>
                                    <label id="Lab_{$value.id}" for="Check_{$value.id}">
                                        {if $value.enabled == 'S'}Ativo{else}Inat.{/if}
                                    </label>
                                </div>
                            </td>
                            <td>
                                <a href="{$stRUTAS.col}col.borrar.php?id={$value.id}" id="borrar{$value.id}"
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

</div>
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

        $(document).on('click', "a[id^='borrar']", function(event) {
            // Prevenir el comportamiento predeterminado del enlace
            event.preventDefault();

            // Obtener la URL del enlace
            var url = $(this).attr("href");

            // Mostrar cuadro de diálogo de confirmación
            if (confirm(
                    "O produto ser\u00E1 removido permanentemente. Tem certeza de que deseja continuar?"
                )) {
                // Si el usuario acepta, redirigir a la URL del enlace
                window.location.href = url;
            } else {
                // Si el usuario cancela, no hacer nada
                return false;
            }
        });

        $(document).on('change', 'select#lojasSelect', function() {
            $('form#lojas_select').submit();
        });
    });

    $(document).ready(function() {

        $(document).on('change', '.switch', function() {
            var id = $(this).attr('id').split('_')[1]; // Obtener el ID del checkbox
            var isChecked = $(this).is(':checked'); // Verificar si el checkbox está marcado
            var valueToSend = isChecked ? 'S' : 'N'; // Establecer el valor a enviar al servidor
            // Enviar datos al servidor usando AJAX
            $.ajax({
                url: '{$stRUTAS.col}col.listar.php', // URL del script en el servidor
                type: 'POST',
                data: {
                    Cid: id,
                    Cvalue: valueToSend
                }, // Datos a enviar al servidor

                success: function(response) {
                    // Acciones a realizar si la solicitud se completa exitosamente
                    if (response === 'ok') {
                        if (isChecked) {
                            // Si el checkbox está marcado, remover las clases bg-gray-500 y text-gray-100
                            $('#Row_' + id).removeClass(
                                'bg-gray-500 text-gray-100');
                            $('#Lab_' + id).text('Ativo');
                        } else {
                            // Si el checkbox está desmarcado, agregar las clases bg-gray-500 y text-gray-100
                            $('#Row_' + id).addClass(
                                'bg-gray-500 text-gray-100');
                            $('#Lab_' + id).text('Inat.');
                        }
                
                        console.log('Estado del producto actualizado correctamente');

                    } else {
                        console.log(response);
                        alert('Error al actualizar el estado del produto');
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
</script>

{include file="_pie.tpl"}