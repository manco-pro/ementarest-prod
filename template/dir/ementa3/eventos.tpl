{include file="ementa3/header.tpl"}

{include file="ementa3/header_menu.tpl"}
<!-- Esta é a área principal do seu conteúdo. -->
<main>

    <div class="container" style="margin-top: 4.6rem; margin-bottom: 4rem;">
        <!-- carrousel -->
        {if $staVALUES!=null}
            <div class="fs-6 fw-bold mb-2">{$stMENSAJE}</div>
            <div class="owl-carousel owl-theme">
                {foreach from=$staVALUES item=value key=key}
                    <div class="item p-0 m-0 mb-3">
                        <img src="{$stRUTAS.images_eve}{$value.imagen}" alt="" class="w-100 m-0 p-0 bradius sl1">
                    </div>
                {/foreach}
            </div>
        {/if}
        <div class="row">
        {if $stfVALUES!=null}
            <!-- Separador de eventos -->
            <div class="fs-6 fw-bold mb-2">{$stMENSAJE2}</div>
            
                {foreach from=$stfVALUES item=value key=key}
                    <div class="col-12 col-sm-6">
                        <div class="px-1 pt-sm-4 mb-3 border-r bg-light" style="background-image: url('{$stRUTAS.images_eve}{$value.imagen}'); background-repeat: no-repeat; background-position: center; background-size:cover; height: 50vh">
                            <div class="d-flex justify-content-end pt-cl-info-evento">
                                <a href="#" class="link-underline link-underline-opacity-0" style="text-decoration: none;"
                                    data-bs-toggle="modal" data-bs-target="#modalazeite" data-bs-whatever="@mdo">
                                    <div class="badge text-wrap text-black mt-2 me-1 me-md-3 mb-3 shadow"
                                        style="font-size: 1rem; border-radius: 50%; width: 30px; height: 30px; padding: 0.4rem 0.4rem;">

                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="bg-light mb-4 px-2 py-2 shadow" style="margin-top: -18px;">
                            <div class="row">
                                <div class="col-12 text-end pe-3 fs-6 text-start">{$stMENSAJE_INICIO} : {$value.inicio}</div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            {/if}
            {if $stfVALUES==null && $staVALUES==null }
                <div class="fs-6 fw-bold mb-2"><h3>{$stMENSAJE3}</h3></div>
            {/if}


            <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
            <!--<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>-->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                crossorigin="anonymous">
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
            </script>
{include file="ementa3/footer.tpl"}