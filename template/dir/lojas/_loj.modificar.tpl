{include file="_cabecera.tpl"}
<link rel="stylesheet" href="{$stRUTAS.vendor}select2/select2.min.css">
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h4 mb-4 text-gray-800">{$stTITLE}</h1>

    {if ($stMENSAJE != '')}
        <h1 id="mensaje" class="h4 text-gray-900 mb-4 border-bottom-success">{$stMENSAJE}</h1>
    {/if}
    {if ($stERROR != '')}
        <h1 class="h4 text-gray-900 mb-4 border-bottom-danger">{$stERROR}</h1>
    {/if}
    <form method="post" action="{$stACTION}" enctype="multipart/form-data" accept-charset="UTF-8">
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{$stSUBTITLE}</h6>
                    <p class='mb-0 small'>Insira o nome da Loja.</p>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-group">
                            <label for="nombre">Nome</label>
                            <input type="text" class="form-control" name="nombre" id="nombre"
                                placeholder="Insira o nome" value="{$stNOMBRE}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">identidade</h6>
                    <p class="mb-0 small" style="text-align: justify">Aqui voc&ecirc; deve preencher as
                        informa&ccedil;&otilde;es que ser&atilde;o utilizadas no Front End.</p>
                </div>
                <div class="card-body">

                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="facebook">Facebook</label>
                                <input type="text" class="form-control" name="facebook" id="facebook"
                                    placeholder="Insira o facebook link" value="{$stFACEBOOK}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="instagram">Instagram</label>
                                <input type="text" class="form-control" name="instagram" id="Instagram"
                                    placeholder="Insira o Instagram link" value="{$stINSTAGRAM}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="googlemaps">googlemaps</label>
                                <input type="text" class="form-control" name="googlemaps" id="googlemaps"
                                    placeholder="Insira o Google Maps link" value="{$stGOOGLEMAPS}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tripadvisor">Trip Advisor</label>
                                <input type="text" class="form-control" name="tripadvisor" id="tripadvisor"
                                    placeholder="Insira o Trip Advisor link" value="{$stTRIPADVISOR}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control" name="logo" id="logo" value="{$stLOGO}">
                                <p class="mb-0 small text-danger" id="ErrorLogo"></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="PlantillaSelect">Plantilla Ementa-Digital</label>
                                <select class="form-control" id="PlantillaSelect" name="plantilla">
                                    {$stPLANTILLAS}
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 d-flex justify-content-center align-items-center">

                                <img id="imagenSeleccionada"
                                    src="{$stRUTAS.logos}{if $stLOGO != ''}{$stLOGO}{else}undraw_photograph.svg{/if}"
                                    alt="Imagen seleccionada" style="max-width:90% ; height: auto;">
                            </div>
                            <div class="form-group col-md-6">
                                <img id="imagenSeleccionadaPlantilla" src="{$stRUTAS.images}Template{$stPLANTILLA}.png"
                                    alt="Imagen seleccionada" style="max-width:90% ; height: auto;">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">informa&ccedil;&otilde;es de faturamento e contato
                    </h6>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="empresa">Empresa</label>
                                <input type="text" class="form-control" name="empresa" id="empresa"
                                    placeholder="Insira o nome do Empresa" value="{$stEMPRESA}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nif">NIF</label>
                                <input type="text" class="form-control" name="nif" id="nif" placeholder="Insira o NIF"
                                    value="{$stNIF}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Endere&ccedil;o</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Insira e-mail" value="{$stEMAIL}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telefono">Telefone</label>
                                <input type="tel" class="form-control" name="telefono" id="telefono"
                                    placeholder="Insira o n&uacute;mero do telefone" value="{$stTELEFONO}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="morada">Morada</label>
                                <input type="text" class="form-control" name="morada" id="morada"
                                    placeholder="Insira o morada" value="{$stMORADA}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="freguesiaSelect">Freguesia</label>
                                <select class="form-control select2" id="freguesiaSelect" name="freguesia">
                                    {$stFREGUESIAS}
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="mesas">N&deg; de mesas</label>
                                <input type="text" class="form-control" name="mesas" id="mesas"
                                    placeholder="Insira n&deg; de mesas" value="{$stMESAS}" required disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="ruta">Ruta Ementa</label>
                                <input type="text" class="form-control" name="ruta_ementa" id="ruta_ementa"
                                    placeholder="path.php" value="{$stRUTA_EMENTA}" required disabled>
                            </div>
                            <div class="form-group col-md-2">
                                <!-- <input type="checkbox" name="enabled" id="enabled" {$stENABLED} disabled> 
                                <label for="enabled">Habilitado</label>-->
                                <input name="id" type="hidden" value="{$stID|default:''}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">informa&ccedil;&otilde;es de subscri&ccedil;&atilde;o
                    </h6>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="table-responsive">
                            <table class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Plano</th>
                                        <th>Tipo</th>
                                        <th>In&iacute;cio da subs.</th>
                                        <th>Fin da subs.</th>
                                        <th>Act.</th>
                                        <th>Dias rest.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {if $stSUSCRIPCION != false}
                                        <tr class={if $stSUSCRIPCION.active != "S"} "bg-gray-200 text-gray-900" {/if}>
                                            <td>
                                                <p style="margin: 0.5rem 0 0 0 !important;">{$stSUSCRIPCION.plano}</p>
                                            </td>
                                            <td>
                                                <p style="margin: 0.5rem 0 0 0 !important;">{$stSUSCRIPCION.type}</p>
                                            </td>
                                            <td>
                                                <p style="margin: 0.5rem 0 0 0 !important;">{$stSUSCRIPCION.inicio}</p>
                                            </td>
                                            <td>
                                                <p style="margin: 0.5rem 0 0 0 !important;">{$stSUSCRIPCION.fin}</p>
                                            </td>
                                            <td>
                                                <p style="margin: 0.5rem 0 0 0 !important;">
                                                    {if $stSUSCRIPCION.active == 'S'}Ativo{else}Inat.{/if}</p>
                                            </td>
                                            <td>
                                                <p style="margin: 0.5rem 0 0 0 !important;">{$stSUSCRIPCION.dias_restantes}
                                                </p>
                                            </td>
                                        </tr>
                                    {/if}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="d-sm-flex align-items-center justify-content-between mb-3 ">
                        <button type="submit" class="btn btn-primary" name="{$stBTN_ACTION}">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"> </i>
                            </span>
                            <span class="text">{$stBTN_ACTION}</span>
                        </button>
                        <a href="{$stRUTAS.admin}contenido.php" class="btn btn-dark">
                            <span class="icon text-white-50">
                                <i class="fas fa-undo"></i>
                            </span>
                            <span class="text">Retornar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Row -->
    </form>
</div>
<!-- /.container-fluid -->


<!-- End of Main Content -->



<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->

<script src="{$stRUTAS.vendor}jquery/jquery.min.js"></script>
<script src="{$stRUTAS.vendor}select2/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            selectionCssClass: 'border-1 '
        });
    });
    $(document).ready(function() {
        $('#logo').change(function() {
            validarImagen(this);
        });
    });
    $(document).ready(function() {
        // A&ntilde;adimos un evento 'change' al select
        $('#PlantillaSelect').change(function() {
            // Obtenemos el valor seleccionado del select
            var idPlantillaSeleccionada = $(this).val();

            // Construimos la ruta de la imagen
            var rutaImagen = '{$stRUTAS.images}Template' + idPlantillaSeleccionada + '.png';

            // Cambiamos la src de la imagen
            $('#imagenSeleccionadaPlantilla').fadeOut(200, function() {
                // Cambiamos la src de la imagen dentro de la funci&oacute;n de callback
                $(this).attr('src', rutaImagen).fadeIn(200);
            });
        });
    });

    function validarImagen(input) {
        if (input.files && input.files[0]) {
            var imagen = input.files[0];
            var reader = new FileReader();

            // Validar el tama&ntilde;o del archivo
            //if (imagen.size > 1048576) { // 1 MB (en bytes)
            //    $('#ErrorLogo').text("A imagem selecionada excede o tamanho m\u00e1ximo permitido de 1 MB.");
            //    return;
            //}

            reader.onload = function(e) {
                var img = new Image();
                img.src = e.target.result;

                // Validar la resoluci&oacute;n de la imagen
                img.onload = function() {
                    //if (img.width > 720 || img.height > 720) {
                    //    $('#ErrorLogo').text(
                    //        "A imagem selecionada excede as dimens\u00f5es m\u00e1ximas permitidas de 720px x 720px."
                    //    );
                    //    return;
                    //}

                    $('#imagenSeleccionada').attr('src', e.target.result);
                    $('#ErrorLogo').text(""); // Limpiar el mensaje de error si la imagen es v&aacute;lida

                }
            }

            reader.readAsDataURL(imagen);
        }
    }
</script>

{include file="_pie.tpl"}