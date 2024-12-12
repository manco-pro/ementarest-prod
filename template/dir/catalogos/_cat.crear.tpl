{include file="_cabecera.tpl"}

<script src="{$stRUTAS.vendor}/cropperjs/cropper.min.js"></script>
<link rel="stylesheet" href="{$stRUTAS.vendor}/cropperjs/cropper.min.css">

<div class="container-fluid">
    <style>
        /* Estilo para el elemento seleccionado */
        .selected {
            background-color: #224abe;
            color: #ffffff;
            cursor: pointer;
        }

        /* Estilo para la lista de idiomas */
        #idiomas {
            list-style: none;
            padding: 0;
            display: flex;
        }

        /* Estilo para cada elemento de la lista de idiomas */
        #idiomas li {
            margin-right: 5px;
            /* Espaciado entre elementos, ajusta seg&uacute;n sea necesario */
            cursor: pointer;
        }
    </style>
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
                    <p class='mb-0 small'>Insira o nome da categoria.</p>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="">
                            <ul class="" id="idiomas">
                                <li class="btn btn-primary  btn-circle btn-sm selected" data-idioma="pt">PT</li>
                                <li class="btn btn-primary btn-circle btn-sm" data-idioma="en">EN</li>
                                <li class="btn btn-primary btn-circle btn-sm" data-idioma="fr">FR</li>
                                <li class="btn btn-primary btn-circle btn-sm" data-idioma="es">ES</li>
                                <li class="btn btn-primary btn-circle btn-sm" data-idioma="De">DE</li>
                            </ul>
                            <div class="form-group" id="campoPt">
                                <label for="textoPt">Nome em portugu&ecirc;s:</label>
                                <input type="text" class="form-control" id="textoPt" name="nombre_pt"
                                    value="{$stNOMBRE_PT}">
                            </div>
                            <div class="form-group" id="campoEn" style="display: none;">
                                <label for="textoEn">Nome em ingl&ecirc;s:</label>
                                <input type="text" class="form-control" id="textoEn" name="nombre_en"
                                    value="{$stNOMBRE_EN}">
                            </div>
                            <div class="form-group" id="campoFr" style="display: none;">
                                <label for="textoFr">Nome em franc&ecirc;s:</label>
                                <input type="text" class="form-control" id="textoFr" name="nombre_fr"
                                    value="{$stNOMBRE_FR}">
                            </div>
                            <div class="form-group" id="campoEs" style="display: none;">
                                <label for="textoEs">Nome em Espanhol</label>
                                <input type="text" class="form-control" id="textoEs" name="nombre_es"
                                    value="{$stNOMBRE_ES}">
                            </div>
                            <div class="form-group" id="campoDe" style="display: none;">
                                <label for="textoDe">Nome em Alem&atilde;o</label>
                                <input type="text" class="form-control" id="textoDe" name="nombre_de"
                                    value="{$stNOMBRE_DE}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Outras Informa&ccedil;&otilde;es</h6>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nivel">Categoria</label>
                                <select class="form-control" id="nivelSelect" name="nivelSelect"
                                    {if $stNIVEL_BLOCK }disabled{/if}>
                                    {$stNIVELS}
                                </select>
                            </div>
                            <!-- <div class="form-group col-md-6">
                                <label for="templateSelect">Template</label>
                                <select class="form-control" id="templateSelect" name="templateSelect">
                                    {$stTEMPLATES}
                                </select>
                            </div>-->
                        </div><!--
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="horaInactivo">Hor&aacute;rio de In&iacute;cio:</label>
                                <input type="time" class="form-control" id="horaInicio" name="hora_desde" step="1800"
                                    value="{$stHORA_DESDE}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="horaFin">Hor&aacute;rio de T&eacute;rmino:</label>
                                <input type="time" class="form-control" id="horaFin" name="hora_hasta" step="1800"
                                    value="{$stHORA_HASTA}">
                            </div>
                        </div>-->
                        <div class="form-group col-md-2">
                            <label for="enabled">Habilitado</label>
                            <input type="checkbox" name="enabled" id="enabled" {$stENABLED}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body">
                    <h6 class="m-0 font-weight-bold text-primary">Imagens</h6>
                    <p class="mb-0 small">Adicione uma fotografia para facilitar a escolha dos seus clientes. a
                        fotografia n&atilde;o pode exceder 1Mb de tamanho.</p>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-group">
                            <div class="form-group">
                                <a href="javascript:void(0)" id="botonArchivo" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-file-image"></i>
                                    </span>
                                    <span class="text">Adicionar foto</span>
                                </a>
                                <input type="file" name='imagen' class="form-control-file" name="inputImage"
                                    id="inputImage" value="{$stIMAGEN}" accept="image/*" style="display: none">
                            </div>
                            <div class="form-group">
                                <img id="imageB" src="{if ($stIMAGEN != '')}{$stRUTAS.images_cat}{$stIMAGEN}{/if}"
                                    alt="" style="max-width: 720px; max-height: auto;">
                                <input id="imageBdata" name="imageB" type="hidden" value="">
                                <input id="imageMdata" name="imageM" type="hidden" value="">
                                <input id="imageSdata" name="imageS" type="hidden" value="">
                            </div>
                        </div>
                        <div class="form-group" id="CropperDiv" style="display:none">
                            <a href="javascript:void(0)" id="guardar" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="far fa-save"></i>
                                </span>
                                <span class="text">Concluir a edi&ccedil;&atilde;o</span>
                            </a>
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
                        <a href="{$stRUTAS.cat}cat.listar.php?loja_id={$stLOJA_ID}" class="btn btn-dark">
                            <span class="icon text-white-50">
                                <i class="fas fa-undo"></i>
                            </span>
                            <span class="text">Retornar</span>
                        </a>
                    </div>
                    <div>
                        {if $stBTN_ACTION_D != ''}
                            <a href="{$stRUTAS.cat}cat.borrar.php?id={$stID}&loja_id={$stLOJA_ID}" class="btn btn-danger"
                                id="borrar" name="{$stBTN_ACTION_D}">
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
        <input name="loja_id" type="hidden" value="{$stLOJA_ID}">
    </form>
</div>
<!-- /.container-fluid -->



</div>




<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->

<script src="{$stRUTAS.vendor}jquery/jquery.min.js"></script>
{literal}<script>
        $(document).ready(function() {
            var $imageB = $('#imageB');
            var $imageBdata = $('#imageBdata');
            var $imageMdata = $('#imageMdata');
            var $imageSdata = $('#imageSdata');
            var cropper;
            $('#botonArchivo').on('click', function() {
                // Simular clic en el input file oculto
                $('#inputImage').click();
            });
            $('#inputImage').on('change', function(event) {
                var files = event.target.files;
                var reader = new FileReader();

                if (files && files.length > 0) {
                    reader.onload = function() {
                        $imageB.attr('src', reader.result);

                        // Destruir el cropper si ya existe
                        if (cropper) {
                            cropper.destroy();
                        }

                        // Crear un nuevo cropper
                        cropper = new Cropper($imageB[0], {
                            zoomable: true,
                            zoomOnWheel: true,
                            zoomOnTouch: true,
                            movable: true,
                            rotatable: true,
                            viewMode: 3,
                            aspectRatio: 16 /
                            9, // Puedes ajustar esto seg&uacute;n tus necesidades
                        });
                        $('#CropperDiv').show();
                    };

                    reader.readAsDataURL(files[0]);
                }
            });

            // Configuraci&oacute;n de los botones
            $('#guardar').on('click', function() {
                // Obtener la imagen editada en base64
                var editedImageB = cropper.getCroppedCanvas({maxWidth: 1920, maxHeight: 1024}).toDataURL();
                var editedImageM = cropper.getCroppedCanvas({maxWidth: 1024, maxHeight: 720}).toDataURL();
                var editedImageS = cropper.getCroppedCanvas({maxWidth: 720, maxHeight: 480}).toDataURL();
                // Aqu&iacute; puedes enviar la imagen a tu servidor o hacer cualquier otra acci&oacute;n
                // Por ejemplo, puedes crear un nuevo elemento de imagen para mostrar la imagen editada
                //var editedImageElement = document.createElement('img');
                //editedImageElement.src = editedImage;
                //document.body.appendChild(editedImageElement);
                $imageB.attr('src', editedImageB);
                $imageBdata.attr('value', editedImageB);
                $imageMdata.attr('value', editedImageM);
                $imageSdata.attr('value', editedImageS);
                //$imageB.attr('style', 'max-height: 640px');
                $imageB.show();

                $('#CropperDiv').hide();
                cropper.destroy();
            });
        });
    </script>
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
            // Manejar clics en los elementos de lista de idiomas
            $('#idiomas li').click(function() {
                // Remover la clase 'selected' de todos los elementos
                $('#idiomas li').removeClass('selected');

                // A&ntilde;adir la clase 'selected' al elemento clicado
                $(this).addClass('selected');

                // Ocultar todos los campos de texto
                $('#campoPt, #campoFr, #campoEn, #campoEs, #campoDe').hide();

                // Mostrar el campo de texto correspondiente al idioma seleccionado
                var selectedIdioma = $(this).data('idioma');
                $('#campo' + selectedIdioma.charAt(0).toUpperCase() + selectedIdioma.slice(1)).show();
            });
        });
    </script>
    <script>
        // Asegurarse de que los minutos solo pueden ser "00" o "30"
        $('input[type="time"]').on('change', function() {
            var value = $(this).val().split(':');
            var hours = parseInt(value[0]);
            var minutes = parseInt(value[1]);

            // Redondear a la hora m&aacute;s cercana en intervalos de 30 minutos
            var roundedMinutes = Math.round(minutes / 30) * 30;
            if (roundedMinutes === 60) {
                // Ajustar la hora si los minutos se redondean a 60
                hours++;
                roundedMinutes = 0;
            }

            // Formatear el nuevo valor y actualizar el input
            var formattedHours = (hours < 10 ? '0' : '') + hours;
            var formattedMinutes = (roundedMinutes < 10 ? '0' : '') + roundedMinutes;
            $(this).val(formattedHours + ':' + formattedMinutes);
        });
</script>{/literal}
{include file="_pie.tpl"}