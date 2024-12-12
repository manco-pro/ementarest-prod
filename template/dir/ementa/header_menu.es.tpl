<header class="fixed-top">
    <div class="container-fluid position-absolute align-middle pt-menu-geral w-100" style="z-index:9;">
        <p class="titulo-page text-center fw-bold">{$stTITULO_PAGINA}</p>
    </div>
    <nav class="navbar navbar-light bg-black bg-opacity-10 nav-t">
        <div class="container-fluid ps-4 pe-3 pt-1 pb-1">
            <button class="btn btl-cl d-none newbtnnav"
                style="border-top-width: 0px; border-top-style: solid;border-bottom-width: 0px;border-bottom-style: solid;border-right-width: 0px;border-right-style: solid;border-left-width: 0px;border-left-style: solid;padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px; background-color: transparent; z-index:999"></button>
            {if $stTITULO_PAGINA == '' || $stTITULO_PAGINA == 'Menu' }
                <button class="btn btl-cl btnclnew" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft"
                    aria-controls="offcanvasLeft" aria-expanded="false" aria-label="Toggle navigation"
                    style="border-top-width: 0px; border-top-style: solid;border-bottom-width: 0px;border-bottom-style: solid;border-right-width: 0px;border-right-style: solid;border-left-width: 0px;border-left-style: solid;padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px; background-color: transparent; z-index:999">
                    <!--<i class="fa-solid fa-bars" onclick="changeIcon(this)"></i>-->
                    <i class="fa-solid fa-bars text-light"></i>
                </button>
            {else}
                <button class="btn btl-cl newbtnnav"
                    style="border-top-width: 0px; border-top-style: solid;border-bottom-width: 0px;border-bottom-style: solid;border-right-width: 0px;border-right-style: solid;border-left-width: 0px;border-left-style: solid;padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px; background-color: transparent; z-index:999">
                    <a href="{$stRUTAS.ementa}menu.php"><i class="fa-solid fa-arrow-left-long fs-5 text-dark"></i></a>
                </button>
            {/if}

            <!-- Menu Idiomas -->
            <div class="dropdown" style="z-index:999">
                <a class="navbar-brand" data-bs-toggle="dropdown" aria-expanded="false" href="#" role="button">
                    <img src="{$stRUTAS.assets}images/icon/{$stLANG}.png" alt="Idiomas"
                        class="float-end me-2 logo-nav-cl">
                </a>
                <ul class="dropdown-menu pb-2" style="width: 100px; margin-left:60px; margin-top:10px">
                    <li><a class="dropdown-item"
                            href="{$stRUTAS.ementa}start.php?lang=pt"><span>Portugu&ecirc;s</span><img
                                src="{$stRUTAS.assets}images/icon/pt.png" alt="" class="w-25 ms-2 float-end"></a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{$stRUTAS.ementa}start.php?lang=es"><span>Espa&ntilde;ol</span><img
                                src="{$stRUTAS.assets}images/icon/es.png" alt="" class="w-25 ms-2 float-end"></a>
                    </li>
                    <li><a class="dropdown-item" href="{$stRUTAS.ementa}start.php?lang=en"><span>English</span><img
                                src="{$stRUTAS.assets}images/icon/en.png" alt="" class="w-25 ms-2 float-end"></a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{$stRUTAS.ementa}start.php?lang=fr"><span>Fran&ccedil;ais</span><img
                                src="{$stRUTAS.assets}images/icon/fr.png" alt="" class="w-25 ms-2 float-end"></a>
                    </li>
                    <li><a class="dropdown-item" href="{$stRUTAS.ementa}start.php?lang=de"><span>Deutsch</span><img
                                src="{$stRUTAS.assets}images/icon/de.png" alt="" class="w-25 ms-2 float-end"></a>
                    </li>
                </ul>
            </div>

            <div class="offcanvas offcanvas-start offcanvas-width-cl d-flex flex-column flex-shrink-0 p-4 bg-dark"
                tabindex="-1" id="offcanvasLeft" aria-labelledby="offcanvasLeftLabel">

                <div class="offcanvas-header">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 mt-3 me-2"
                        data-bs-dismiss="offcanvas" aria-label="Close" style="z-index:9999;"></button>
                </div>

                <a href="#" class="d-flex align-items-center mb-2 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <img src="{$stRUTAS.logos}{$stLOGO}" alt="Logo"
                        class="img-logo-p-cl mt-3 ms-3 position-absolute top-0 start-0">
                    <div class="img-logo-p-cl mt-3 position-absolute top-0 start-0 w-100" style="margin-left: 28%;">
                        <p class="fs-6 m-0 p-0 text-white">{$stNOMBRE_RESTO}</p>
                        <p class="m-0 p-0 text-white" style="font-size: 12px;">{$stMORADA}, Portugal</p>
                    </div>
                </a>
                <!-- Menu left scrolling -->
                <hr class="border-light">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item mt-0">
                        <a href="{$stRUTAS.ementa}index.php"
                            class="{if $stACTIVA eq 'Index'}nav-link bg-warning text-dark fw-bold active{else}nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0{/if}"
                            aria-current="page">
                            <i class="fa-solid fa-house fs-5 pe-none me-2"></i>
                            In&iacute;cio
                        </a>
                    </li>
                    <hr class="bg-light">
                    <li class="mt-0">
                        <a href="{$stRUTAS.ementa}menu.php"
                            class="{if $stACTIVA eq 'Menu'}nav-link bg-warning text-dark fw-bold active{else}nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0{/if}"
                            aria-current="page">
                            <!--<i class="fa-solid fa-utensils fs-4 pe-none me-2"></i>-->
                            <img src="{$stRUTAS.assets}images/icon/{if $stACTIVA eq 'Menu'}menu1.png{else}menu-w.png{/if}"
                                alt="" width="17px" class="icon-cl icon-cl-effect me-2 mImg" style="margin-top: -6px;">
                            Menu
                        </a>
                    </li>
                    <hr class="bg-light">
                    <li class="mt-0">
                        <a href="{$stRUTAS.ementa}bebidas.php"
                            class="{if $stACTIVA eq 'Bebidas'}nav-link bg-warning text-dark fw-bold active{else}nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0{/if}"
                            aria-current="page">
                            <i class="fa-solid fa-wine-bottle pe-none fs-4 me-2"></i>
                            Bebidas
                        </a>
                    </li>
                    <hr class="bg-light">
                    <li class="mt-0">
                        <a href="{$stRUTAS.ementa}cart.php"
                            class="{if $stACTIVA eq 'Cart'}nav-link bg-warning text-dark fw-bold active{else}nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0{/if}"
                            aria-current="page">
                            <i class="fa-solid fa-cart-shopping pe-none fs-4 me-2"></i>
                            Carrito
                        </a>
                    </li>
                    {*<hr class="bg-light">
                    <li class="mt-0">
                        <a href="{$stRUTAS.ementa}eventos.php"
                            class="{if $stACTIVA eq 'Eventos'}nav-link bg-warning text-dark fw-bold active{else}nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0{/if}"
                            aria-current="page">
                            <i class="fa-solid fa-calendar-days fs-4 pe-none me-2"></i>
                            Eventos
                        </a>
                    </li>*}
                    <hr class="bg-light">
                    <li class="mt-0">
                        <a href="{$stRUTAS.ementa}sugestoes.php"
                            class="{if $stACTIVA eq 'Sugestoes'}nav-link bg-warning text-dark fw-bold active{else}nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0{/if}"
                            aria-current="page">
                            <i class="fa-solid fa-utensils fs-4 pe-none me-2"></i>
                            Sugerencias
                        </a>
                    </li>
                    <hr class="bg-light">
                    <li class="mt-0">
                        <a href="{$stRUTAS.ementa}opiniao.php"
                            class="{if $stACTIVA eq 'Opiniao'}nav-link bg-warning text-dark fw-bold active{else}nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0{/if}"
                            aria-current="page">
                            <i class="fa-solid fa-comments fs-4 pe-none me-2"></i>
                            Su opini&oacute;n
                        </a>
                    </li>
                    <hr class="bg-light">
                </ul>
                <!-- Siga-nos -->
                <ul class="m-0 p-0">
                    <li class="text-center">
                        <p class="fs-6 text-warning ">S&iacute;ganos:</p>
                        <a href="{$stFACEBOOK}"  target="_blank"
                            class="nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0 p-0">
                            <i class="fa-brands fa-facebook fs-2 p-0 me-2"></i>
                        </a>
                        <a href="{$stINSTAGRAM}"  target="_blank"
                            class="nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0 p-0">
                            <i class="fa-brands fa-instagram fs-3 p-0 ms-0"></i>
                        </a>
                        <p class="text-size-cl-m-f mt-3 text-center"><a href="{$stRUTAS.ementa}termos.html"
                                class="link-warning">T&eacute;rminos y condiciones</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>