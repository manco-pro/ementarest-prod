<body>

    <div class="container-fluid fixed-top menu-translate d-none translate-menu"
        style="width: 100%; height: 100vh; z-index: 9999;">

        <div class="container">
            <div class="row">
                <div class="col-12 p-4">
                    <i class="fa-solid fa-xmark fs-1 float-end close-translate-btn" style="cursor: pointer;"></i>
                </div>
            </div>
            <div class="container">
                <h2 class="fs-5">{$stMENSAJE_BIEN_TRAD}</h2>
                <p class="fs-6">{$stMENSAJE_BIEN_TRAD2}</p>
                <hr>
            </div>
            <div class="row pt-3 d-flex align-items-start justify-content-center justify-content-lg-center">

                <div class="col-12 col-sm-12 col-lg-6 my-4 padding-translate w-100" style="margin: 0 auto;">
                    <a href="{$CURRENT_PAGE}?lang=pt{if $GET != ''}{$GET}{/if}"
                        class="d-flex justify-content-start left-ajuste">
                        <img src="{$stRUTAS.assets3}images/icon/portugal.png" alt="Português" width="28"
                            class="item me-2 p-0 me-lg-2">
                        <span class="text-center pt-1">Português</span>
                    </a>
                </div>

                <div class="col-12 col-sm-12 col-lg-6 my-4 padding-translate w-100" style="margin: 0 auto;">
                    <a href="{$CURRENT_PAGE}?lang=es{if $GET != ''}{$GET}{/if}"
                        class="d-flex justify-content-start left-ajuste">
                        <img src="{$stRUTAS.assets3}images/icon/espanha.png" alt="Español" width="28"
                            class="item me-2 p-0 me-lg-2">
                        <span class="text-center pt-1">Español</span>
                    </a>
                </div>

                <div class="col-12 col-sm-12 col-lg-6 my-4 padding-translate w-100" style="margin: 0 auto;">
                    <a href="{$CURRENT_PAGE}?lang=en{if $GET != ''}{$GET}{/if}"
                        class="d-flex justify-content-start left-ajuste">
                        <img src="{$stRUTAS.assets3}images/icon/reino-unido.png" alt="English" width="28"
                            class="item me-2 p-0 me-lg-2">
                        <span class="text-center pt-1">English</span>
                    </a>
                </div>

                <div class="col-12 col-sm-12 col-lg-6 my-4 padding-translate w-100" style="margin: 0 auto;">
                    <a href="{$CURRENT_PAGE}?lang=fr{if $GET != ''}{$GET}{/if}"
                        class="d-flex justify-content-start left-ajuste">
                        <img src="{$stRUTAS.assets3}images/icon/franca.png" alt="Français" width="28"
                            class="item me-2 p-0 me-lg-2">
                        <span class="text-center pt-1">Français</span>
                    </a>
                </div>

                <div class="col-12 col-sm-12 col-lg-6 my-4 padding-translate w-100" style="margin: 0 auto;">
                    <a href="{$CURRENT_PAGE}?lang=de{if $GET != ''}{$GET}{/if}"
                        class="d-flex justify-content-start left-ajuste">
                        <img src="{$stRUTAS.assets3}images/icon/alemao.png" alt="Deutsch" width="28"
                            class="item me-2 p-0 me-lg-2">
                        <span class="text-center pt-1">Deutsch</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <header class="fixed-top">

        <div class="container-fluid position-absolute align-middle pt-menu-geral">
            <p class="titulo-page text-white text-center fw-normal"
                style="z-index: 1; position: relative; margin-top: 3px"></p>
        </div>

        <nav class="navbar">
            <div class="container">

                <!-- Menu Logo -->
                <a href="{$stRUTAS.ementa}index.php">
                    <img src="{$stRUTAS.logos}{$stLOGO}" alt="" class="rounded-circle float-start"
                        style="width: 2.2rem">
                </a>

                <!-- Menu Idiomas -->
                <div style="z-index:999">
                    <button class="btn btl-cl d-none newbtnnav"
                        style="border-top-width: 1px; border-top-style: solid;border-bottom-width: 0px;border-bottom-style: solid;border-right-width: 0px;border-right-style: solid;border-left-width: 0px;border-left-style: solid;padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px; background-color: transparent;"></button>
                    <div id="btn-translate" class="d-inline-flex">
                        <a href="#" role="button">
                            <!--<i class="fa-solid fa-globe fs-4 p-0 text-white" title="Idiomas"></i>-->
                            <img src="{$stRUTAS.assets}images/icon/{$stLANG}.png" alt="{$stLANG}" width="22"
                                class="mx-2 p-0" style="margin-top: -3px">
                            <!--<span class="fs-6 fw-normal m-0 p-0 text-white">PT</span>-->
                        </a>
                    </div>

                    <!-- Menu bars -->
                    <button class="btn px-0 py-0 btnclnew" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasLeft" aria-controls="offcanvasLeft" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars text-black fs-5"></i>
                    </button>
                </div>

                <!-- Menu lateral right -->
                <div class="offcanvas offcanvas-end offcanvas-width-cl d-flex flex-column flex-shrink-0 p-5 bg-menu-lateral w-auto"
                    tabindex="-1" id="offcanvasLeft" aria-labelledby="offcanvasLeftLabel"
                    style="visibility: visible; z-index: 9999;" aria-modal="true" role="dialog">

                    <div class="offcanvas-header m-0 p-0">
                        <button type="button"
                            class="btn-close btn-close-black position-absolute top-0 end-0 mt-2 me-2 focus-none"
                            data-bs-dismiss="offcanvas" aria-label="Close" style="z-index:9999;"></button>
                    </div>
                    <div class="d-flex justify-content-center align-content-center">
                        <a href="{$stRUTAS.ementa}index.php">
                            <img src="{$stRUTAS.logos}{$stLOGO}" class="rounded-circle size-img-cl"
                                alt="{$stNOMBRE_RESTO}">
                        </a>
                    </div>
                    <div>
                        <h3 class="m-0 pt-1 text-center f-ml-h3">{$stNOMBRE_RESTO}</h3>
                        <p class="m-0 p-0 text-center f-ml-p">{$stMORADA}</p>
                        <hr class="bg-dark my-2 py-0">
                    </div>

                    <!-- Menu left scrolling -->
                    <div class="d-flex justify-content-center overflow-auto">
                        <ul class="nav nav-pills flex-column mb-auto largura" id="btnul">

                            <li class="nav-item my-1">
                                <a href="{$stRUTAS.ementa}index.php"
                                    class="nav-link text-dark fw-normal item-botao active" aria-current="page">
                                    <i class="fa-solid fa-house text-dark fs-5 pe-none me-2"></i>
                                    <span class="menu-i">{$stINICIO}</span>
                                </a>
                            </li>

                            <li class="nav-item my-1">
                                <a href="{$stRUTAS.ementa}menu.php" class="nav-link text-dark fw-normal item-botao"
                                    aria-current="page">
                                    <i class="fa-solid fa-clipboard-check fs-5 pe-none me-2 text-dark"></i>
                                    <span class="menu-m">{$stMENU}</span>
                                </a>
                            </li>

                            <li class="nav-item my-1">
                                <a href="{$stRUTAS.ementa}cart.php" class="nav-link text-dark fw-normal item-botao"
                                    aria-current="page">
                                    <i class="fa-solid fa-basket-shopping fs-5 pe-none me-2 text-dark"></i>
                                    <span class="menu-p">{$stCART}</span>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{$stRUTAS.ementa}eventos.php" class="nav-link text-dark fw-normal item-botao" aria-current="page">
                                    <i class="fa-solid fa-calendar-days fs-5 fs-5 pe-none me-2 text-dark"></i>
                                    <span class="menu-e">{$stEVENTOS}</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{$stRUTAS.ementa}sugestoes.php" class="nav-link text-dark fw-normal item-botao"
                                    aria-current="page">
                                    <i class="fa-solid fa-utensils fs-5 pe-none me-2 text-dark"></i>
                                    <span class="menu-s">{$stSUGESTOES}</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{$stRUTAS.ementa}opiniao.php" class="nav-link text-dark fw-normal item-botao"
                                    aria-current="page">
                                    <i class="fa-solid fa-comments fs-5 pe-none me-2 text-dark"></i>
                                    <span class="menu-o">{$stOPINIAO}</span>
                                </a>
                            </li>
                        </ul>

                    </div>

                    <!-- Siga-nos -->
                    <div class="container">
                        <hr class="bg-dark">
                        <div class="d-flex justify-content-center">
                            {if isset($stFACEBOOK)}
                                <a href="{$stFACEBOOK}"
                                    class="nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0 p-0">
                                    <i class="fa-brands fa-facebook fs-2 p-0 me-2 color-primary rede-s-hover"></i>
                                </a>
                            {/if}
                            {if isset($stINSTAGRAM)}
                                <a href="{$stINSTAGRAM}"
                                    class="nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0 p-0">
                                    <img id="instagrambtn" src="{$stRUTAS.assets2}images/icon/instagram.png" alt=""
                                        width="32" class="me-2">
                                </a>
                            {/if}
                            {if isset($stGOOGLEMAPS)}
                                <a href="{$stGOOGLEMAPS}"
                                    class="nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0 p-0">
                                    <img id="google-maps" src="{$stRUTAS.assets2}images/icon/google-maps.png" alt=""
                                        width="32" class="me-2">
                                </a>
                            {/if}
                            {if isset($stTRIPADVISOR)}
                                <a href="{$stTRIPADVISOR}"
                                    class="nav-link link-light btn btn-toggle d-inline-flex align-items-center rounded border-0 p-0">
                                    <img id="tripadvisor" src="{$stRUTAS.assets2}images/icon/tripadvisor.png" alt=""
                                        width="32" class="me-2">
                                </a>
                            {/if}
                        </div>
                    </div>

                </div>
            </div>
        </nav>

</header>