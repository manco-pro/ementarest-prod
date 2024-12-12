{include file="_cabecera.tpl"}

<script src="{$stRUTAS.vendor}/cropperjs/cropper.min.js"></script>
<link rel="stylesheet" href="{$stRUTAS.vendor}/cropperjs/cropper.min.css">
<link rel="stylesheet" href="{$stRUTAS.vendor}select2/select2.min.css">
<script src="{$stRUTAS.js}ckeditor.js"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->

<div class="container-fluid">
    <style>
        .idiomas-lista .selected {
            background-color: #3F72AF !important;
            color: #ffffff !important;
            cursor: pointer;
        }

        /* Estilo para la lista de idiomas */
        .idiomas-lista {
            list-style: none;
            padding: 0;
            display: flex;
        }

        /* Estilo para cada elemento de la lista de idiomas */
        .idiomas-lista li {
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
    <form method="POST" id="miFormulario" action="{$stACTION}" accept-charset="utf-8">
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{$stSUBTITLE}</h6>
                    <p class='mb-0 small' style="text-align: justify">Insira o nome e a descri&ccedil;&atilde;o do
                        produto. Os idiomas que n&atilde;o forem informados ser&atilde;o exibidos em portugu&ecirc;s
                    </p>
                </div>
                <div class="card-body">

                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="">
                            <ul class="idiomas-lista" id="idiomas">
                                <li class="btn btn-primary btn-circle btn-sm selected" data-idioma="pt">PT</li>
                                <li class="btn btn-primary btn-circle btn-sm" data-idioma="en">EN</li>
                                <li class="btn btn-primary btn-circle btn-sm" data-idioma="fr">FR</li>
                                <li class="btn btn-primary btn-circle btn-sm" data-idioma="es">ES</li>
                                <li class="btn btn-primary btn-circle btn-sm" data-idioma="de">DE</li>
                            </ul>
                            <div id="campoPt">
                                <div class="form-group">
                                    <label for="textoPt">Nome em portugu&ecirc;s:</label>
                                    <input type="text" class="form-control" id="textoPt" name="nombre_pt"
                                        value="{$stNOMBRE_PT}">
                                </div>
                                <div class="form-group">
                                    <label for="textareaPt">Descri&ccedil;&atilde;o em portugu&ecirc;s:</label>
                                    <textarea name="editor_pt" id="editor_pt">{$stDESCRIPCION_PT}</textarea>
                                </div>
                            </div>
                            <div id="campoFr" style="display: none;">
                                <div class="form-group">
                                    <label for="textoFr">Nome em franc&ecirc;s:</label>
                                    <input type="text" class="form-control" id="textoFr" name="nombre_fr"
                                        value="{$stNOMBRE_FR}">
                                </div>
                                <div class="form-group">
                                    <label for="textareaFr">Descri&ccedil;&atilde;o em Franc&ecirc;s:</label>
                                    <textarea name="editor_fr" id="editor_fr">{$stDESCRIPCION_FR}</textarea>
                                </div>
                            </div>
                            <div id="campoEn" style="display: none;">
                                <div class="form-group">
                                    <label for="textoEn">Nome em ingl&ecirc;s:</label>
                                    <input type="text" class="form-control" id="textoEn" name="nombre_en"
                                        value="{$stNOMBRE_EN}">
                                </div>
                                <div class="form-group">
                                    <label for="textareaEn">Descri&ccedil;&atilde;o em Ingl&ecirc;s:</label>
                                    <textarea name="editor_en" id="editor_en">{$stDESCRIPCION_EN}</textarea>
                                </div>
                            </div>
                            <div id="campoEs" style="display: none;">
                                <div class="form-group">
                                    <label for="textoEs">Nome em Espanhol:</label>
                                    <input type="text" class="form-control" id="textoEs" name="nombre_es"
                                        value="{$stNOMBRE_ES}">
                                </div>
                                <div class="form-group">
                                    <label for="textareaEs">Descri&ccedil;&atilde;o em Espanhol:</label>
                                    <textarea name="editor_es" id="editor_es">{$stDESCRIPCION_ES}</textarea>
                                </div>
                            </div>
                            <div id="campoDe" style="display: none;">
                                <div class="form-group">
                                    <label for="textoDe">Nome em Alem&atilde;o:</label>
                                    <input type="text" class="form-control" id="textoDe" name="nombre_de"
                                        value="{$stNOMBRE_DE}">
                                </div>
                                <div class="form-group">
                                    <label for="textareaDe">Descri&ccedil;&atilde;o em Alem&atilde;o:</label>
                                    <textarea name="editor_de" id="editor_de">{$stDESCRIPCION_DE}</textarea>
                                </div>
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
                    <span class="mb-0 small" style="text-align: justify">Defina o pre&ccedil;o, a unidade de medida e
                        seo produto est&aacute; dispon&iacute;vel para venda. </span>
                    <span class="mb-0 small" style="text-align: justify">Selecione a ordem em que deseja que os produtos 
                    sugeridos apare&ccedil;am no menu.</span>
                </div>
                <div class="card-body"></div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="catalogoSelect">Cat&aacute;logo</label>
                                <select class="form-control" id="catalogoSelect" name="catalogoSelect">
                                    {$stCATALOGO_SELECT}
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="unidad">Unidade</label>
                                <select class="form-control" id="unidad" name="unidadSelect">
                                    <option value=1 {if $stUNIDAD == 1} selected{/if}>Dose</option>
                                    <option value=2 {if $stUNIDAD == 2} selected{/if}>Peso</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="precio">Pre&ccedil;o:</label>
                                <input type="text" class="form-control" id="precio" name="precio" value="{$stPRECIO}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="enabled">Habilitado</label>
                                <input type="checkbox" name="enabled" id="enabled" {$stENABLED}>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="destacado">adicionar &agrave;s sugest&otilde;es</label>
                                <input type="checkbox" name="destacado" id="destacado" {$stDESTACADO}>

                            </div>
                            <div class="form-group col-md-2">
                                <label for="Orden">Ordem</label>
                                <select class="form-control" id="ordenSelect" name="ordenSelect">
                                    {foreach from=$stORDEN item=value key=key}
                                        <option value="{$key}" {if $value == $stORDEN_COL}Selected{/if}>{$value}</option>
                                    {/foreach}

                               </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="card-body">
                    <h6 class="m-0 font-weight-bold text-primary">Imagens</h6>
                    <p class="mb-0 small" style="text-align: justify">
                        Adicione uma fotografia para facilitar a escolha dos seus clientes. a
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
                                    id="inputImage" value="" accept="image/*" style="display: none">
                            </div>
                            <div class="form-group">
                                <img id="imageB" src="{if ($stIMAGEN != '')}{$stRUTAS.images_col}{$stIMAGEN}{/if}"
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
                <div class="card-body">
                    <h6 class="m-0 font-weight-bold text-primary">Sugest&otilde;es</h6>
                    <p class="mb-0 small" style="text-align: justify">Sugira aos seus clientes bebidas para acompanhar
                        este produto. M&aacute;ximo 3. </p>
                    <p class="mb-0 small" style="text-align: justify">clique nas sugest&otilde;es inseridas para
                        exclu&iacute;-las </p>
                </div>
                <div class="card-body">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body border-left-secondary">
                        <h6 class="m-0 font-weight-bold text-primary">Bebidas para sugerir</h6>
                        <br>
                        <div class="d-sm-flex align-items-center justify-content-between mb-3">
                            <div class="form-group col-md-9">
                                <select class="form-control select2" id="ColSelect" name="ColSelect">
                                    {$stCOLECCIONES}
                                </select>
                            </div>
                            <div class="form-group col-md-3 ">
                                <a href="javascript:void(0)" id="adicionar" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span class="text">Adicionar</span>
                                </a>
                            </div>
                        </div>
                        <div class="idiomas-lista" id="listaCol">
                            <input type="hidden" id="idsColSelect" name="idsColSelect">
                            {foreach from=$stSUG_COL_ID item=coleccion key=key}
                                <li>
                                    <div class="Sugerencia eliminar d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                                        data-id="{$coleccion.id}">
                                        <div class="texto"><span>{$coleccion.nombre_pt}</span></div>
                                    </div>
                                </li>
                            {/foreach}
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
                        <a href="{$stRUTAS.col}col.listar.php?loja_id={$stLOJA_ID}" class="btn btn-dark">
                            <span class="icon text-white-50">
                                <i class="fas fa-undo"></i>
                            </span>
                            <span class="text">Retornar</span>
                        </a>
                    </div>
                    <div>
                        {if $stBTN_ACTION_D != ''}
                            <a href="{$stRUTAS.col}col.borrar.php?id={$stID}" class="btn btn-danger" id="borrar"
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
</div>
<input type="hidden" id="valoresSeleccionadosInput" name="valoresSeleccionados">
<input name="id" type="hidden" value="{$stID}">
<input name="loja_id" type="hidden" value="{$stLOJA_ID}">
</form>

</div>
<!-- /.container-fluid -->


<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->

<script src="{$stRUTAS.vendor}jquery/jquery.min.js"></script>
<script src="{$stRUTAS.vendor}select2/select2.min.js"></script>

{literal}
    <script>
        $(document).ready(function() {
            $("#borrar").click(function(event) {
                event.preventDefault();
                var url = $(this).attr("href");
                if (confirm(
                        "O produto ser\u00E1 removido permanentemente. Tem certeza de que deseja continuar?"
                    )) {
                    window.location.href = url;
                } else {
                    return false;
                }
            });
            $("#adicionar").click(function() {

                var cantidadDivs = $('.Sugerencia').length;
                if (cantidadDivs === 3) {
                    alert('Excedeu o n\u00FAmero m\u00E1ximo de sugest\u00F5es');
                    return false;
                }

                var valorSeleccionado = $('#ColSelect').val();
                var IdsCol = $('#idsColSelect').val();
                var ArrayIdsCol = IdsCol.split(',');
                if (jQuery.inArray(valorSeleccionado, ArrayIdsCol) !== -1) {
                    alert("o item j\u00E1 foi adicionado.");
                    return false;
                }
                if (valorSeleccionado && valorSeleccionado !== -1) {
                    var texto = $('#ColSelect option:selected').text();
                    if (texto != "Produtos") {
                        $('#listaCol').append(
                            '<li><div class="Sugerencia eliminar d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-id="' +
                            valorSeleccionado + '">' +
                            '<div class="texto"><span>' + texto +
                            '</span></div></div></li>'
                        );
                        actualizarInputHidden();
                    } else {
                        alert("Por favor Selecione um produto.");
                    }
                }
            });

            $('#listaCol').on('click', '.eliminar', function() {
                var $pedido = $(this).closest('.Sugerencia');
                // Si solo hay un elemento, elimina el pedido completo
                $pedido.remove();
                actualizarInputHidden();
            });
            actualizarInputHidden();

            function actualizarInputHidden() {
                var elementosSeleccionados = [];
                $('#listaCol .Sugerencia').each(function() {

                    var id = $(this).attr('data-id');

                    elementosSeleccionados.push(id);
                });
                $('#idsColSelect').val(elementosSeleccionados.join(','));
            }
        });
        $(document).ready(function() {

            $('.select2').select2({
                selectionCssClass: 'border-1 '
            });
            // Capturar el clic en el bot&oacute;n
            $("#buttonForm").click(function() {
                var test = '';
                // Iterar sobre los checkboxes con ID que comienza con "ING" y que est&aacute;n marcados
                $(':checkbox:checked[id^="ING"]').each(function() {
                    test = test + $(this).val() + ',';
                });
                test = test.slice(0, -1);
                $("#valoresSeleccionadosInput").val(test);

                //var contenido = tinymce.get('textareaPt').getContent();
                //$('#descripcion_pt_h').val(contenido);
                //var contenido = tinymce.get('textareaFr').getContent();
                //$('#descripcion_fr_h').val(contenido);
                //var contenido = tinymce.get('textareaEn').getContent();
                //$('#descripcion_en_h').val(contenido);
                //var contenido = tinymce.get('textareaEs').getContent();
                //$('#descripcion_es_h').val(contenido);
                //var contenido = tinymce.get('textareaDe').getContent();
                //$('#descripcion_de_h').val(contenido);
            });
        });

        function seleccionarImagen(img) {
            img.classList.toggle("selected");
        }

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
                var editedImageB = cropper.getCroppedCanvas({maxWidth: 1080, maxHeight: 720}).toDataURL();
                var editedImageM = cropper.getCroppedCanvas({maxWidth: 720, maxHeight: 480}).toDataURL();
                var editedImageS = cropper.getCroppedCanvas({maxWidth: 320, maxHeight: 180}).toDataURL();
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
        $(document).ready(function() {
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
                $('#campo' + selectedIdioma.charAt(0).toUpperCase() + selectedIdioma.slice(1)).focus();

            });
        });
    </script>
{/literal}
<script>
    ClassicEditor
        .create(document.querySelector('#editor_pt'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#editor_fr'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#editor_en'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#editor_es'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#editor_de'))
        .catch(error => {
            console.error(error);
        });
</script>

{include file="_pie.tpl"}