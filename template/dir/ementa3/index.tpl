{include file="ementa3/header.tpl"}

{include file="ementa3/header_menu.tpl"}
<!-- Esta é a área principal do seu conteúdo. -->
<main>

    <div class="container mt-cl">
        {if $staVALUES!=null}
            <div class="owl-carousel owl-theme">
                {foreach from=$staVALUES item=value key=key}
                    <div class="item p-0 m-0 mb-0 bradius">
                        <img src="{$stRUTAS.images_eve}{$value.imagen}" alt="" class="w-100 m-0 p-0 bradius sl1">
                    </div>
                {/foreach}
            </div>
        {/if}
        <div class="container d-flex flex-column nowrap marg-top-cl" style="border: 0px solid green;">
            <div class="row">
                <div class="col-4 col-sm-4 col-md-4 d-flex justify-content-end p-0 m-0">
                    <a href="{$stRUTAS.ementa}menu.php" style="text-decoration: none;">
                        <div class="card bg-transparent">
                            <div class="card-body pb-1">
                                <img src="{$stRUTAS.assets3}images/icon/menu-principal-tow.png"
                                    class="img-size-cl icon-cl-effect" title="Menu" alt="Menu">
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-4 col-sm-4 col-md-4 d-flex justify-content-center p-0 m-0">
                    <a href="{$stRUTAS.ementa}bebidas.php" style="text-decoration: none;">
                        <div class="card bg-transparent">
                            <div class="card-body pb-1">
                                <img src="{$stRUTAS.assets3}images/icon/menu-principal-tow-tow.png"
                                    class="img-size-cl icon-cl-effect" title="Bebidas" alt="Bebidas">
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-4 col-sm-4 col-md-4 d-flex justify-content-start p-0 m-0">
                    <a href="{$stRUTAS.ementa}sugestoes.php" style="text-decoration: none;">
                        <div class="card bg-transparent">
                            <div class="card-body pb-1">
                                <img src="{$stRUTAS.assets3}images/icon/menu-principal-three.png"
                                    class="img-size-cl icon-cl-effect" title="{$stSUGESTOES}" alt="Sugestões">
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-4 col-sm-4 col-md-4 d-flex justify-content-end p-0 m-0">
                    <a href="{$stRUTAS.ementa}eventos.php" style="text-decoration: none;">
                        <div class="card bg-transparent">
                            <div class="card-body pt-2">
                                <img src="{$stRUTAS.assets3}images/icon/menu-principal-four.png"
                                    class="img-size-cl icon-cl-effect" title="Eventos" alt="Eventos">
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-4 col-sm-4 col-md-4 d-flex justify-content-center p-0 m-0">
                    <a href="{$stRUTAS.ementa}opiniao.php" style="text-decoration: none;">
                        <div class="card bg-transparent">
                            <div class="card-body pt-2">
                                <img src="{$stRUTAS.assets3}images/icon/menu-principal-five.png"
                                    class="img-size-cl icon-cl-effect" title="Opinião" alt="Opinião">
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-4 col-sm-4 col-md-4 d-flex justify-content-start p-0 m-0">
                    <a href="{$stRUTAS.ementa}cart.php" style="text-decoration: none;">
                        <div class="card bg-transparent">
                            <div class="card-body pt-2">
                                <img src="{$stRUTAS.assets3}images/icon/menu-principal-six.png"
                                    class="img-size-cl icon-cl-effect" title="Cart" alt="Cart">
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <!-- btn campainha -->
    {if isset($stMESA)}
        <div class=" d-flex me-3"
            style="z-index: 9999; width: 45px; height: 45px; position: fixed; bottom: 80px; right: 15px ">
            <a href="#" class="rounded-circle bg-danger btn-an" id="Empregado_de_Mesa" style="width: 45px; height: 45px;">
                <img src="{$stRUTAS.images}croupier.png" class="btn-ic" alt="">
            </a>
        </div>
    {/if}
    <!-- Modal MSN ADD Item msnEmplegrado-->
    <div class="modal fade" id="msnEmplegrado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-inline-flex align-items-center" id="exampleModalToggleLabel">
                        <img src="{$stRUTAS.images}croupier.png" class="btn-ic" alt="">
                        <span style="padding: 10px 0 0 10px;">{$stMENSAJE_TITULO_EMPLEADO}</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-secondary alert-dismissible fade show mb-0">
                        <div class="" role="alert" id="nuevoMensaje">
                            <strong>{$stMENSAJE_EMPlEADO_MESA}</strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{$stMENSAJE_BOTON_CANCELAR}</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        id="confirmarBtn">{$stMENSAJE_BOTON_CONFIRMAR}</button>
                </div>
            </div>
        </div>
    </div>
</main> <!-- Fechamento da tag main -->

<footer class="fixed-bottom b-5 mb-cl" style="z-index: 1;">
    <div class="container w-75 bg-dark bg-opacity-10" style="border-radius: 12px">
        <!--<hr class="w-75 my-2" style="margin: 0 auto;">-->
        <p class="text-center text-white text-size-cl-m-f p-2">
            <a href="{$stRUTAS.ementa}termos.html" class="link-dark fw-bold linktermo"
                style="color: #4e1d01; text-decoration: underline; margin-top: -14px">Termos e condições</a>
        <p class="text-center text-dark fw-bold pb-2 px-2" style="font-size: 12px; line-height: 1.5; margin-top: -16px">
            {$stIVA}</p>
        </p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!--<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>
<script src="{$stRUTAS.assets3}js/scripts-cl.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            600: {
                items: 1,
                nav: false
            },
            1000: {
                items: 3,
                nav: false,
                loop: false
            }
        }
    });

    //----------empregado de mesa--------------------------
    $(document).ready(function() {
        $('#Empregado_de_Mesa').on('click', function() {
            // Seleccionar todos los botones cuyo ID comienza con 'add'
            $('#msnEmplegrado').modal('show');

        });
    });

    // Manejar el clic en el botón "Confirmar"
    $("#confirmarBtn").click(function() {
        empregado_mesa();
    });

    function empregado_mesa() {
        $.ajax({
            url: 'call.php', // URL de la página PHP
            method: 'POST', // Método de solicitud (puedes cambiarlo a GET si es necesario)
            data: { id: 'call' }, // Datos a enviar al servidor

            success: function(response) {

                if (response === "ok") {
                    if ("vibrate" in navigator && "Audio" in window) {
                        // Hacer que el dispositivo vibre durante 1000 milisegundos (1 segundo)
                        navigator.vibrate(1000);

                        // Crear un nuevo elemento de audio
                        var audio = new Audio("{$stRUTAS.images}notification.wav"); 

                        // Reproducir el sonido
                        audio.play();
                    } else {
                        console.log(
                            "Lo siento, tu dispositivo no soporta la función de vibración o reproducción de audio."
                        );
                    }
                }
                console.log('Respuesta del servidor:', response);
            },
            error: function(xhr, status, error) {
                // Manejar errores de la solicitud
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    }
</script>