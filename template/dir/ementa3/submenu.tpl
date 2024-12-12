{include file="template/dir/ementa3/header.tpl"}
{include file="ementa3/header_menu.tpl"}
<!-- Main Menu -->
<div class="container p-4" style="margin-top: 3rem; margin-bottom: 1rem">
    <div class="row">
    {foreach from=$stCATALOGOS key=id item=Catalogo}
        <div class="col-12 col-sm-6 col-lg-4 col-xxl-3 px-2 mb-4 icon-cl-effect">
            <div class="card bg-white bg-opacity-50 shadow p-2" style="border-radius: 16px 16px 16px 16px;">
                <a href="{$stRUTAS.ementa}{$stRUTA}.php?cat={$Catalogo.id}">
                    <div class="position-absolute">
                        <div class="badge text-wrap text-black position-relative top-cl bg-cl-btn"
                            style="right:20px; font-size: 1.1rem; border-radius: 50%; width: 45px; height: 45px; padding: 0.75rem 0.4rem;">
                            <i class="fa-solid fa-arrow-right text-white text-center m-0 p-0"
                                style="font-size: 1.4rem;"></i>
                        </div>
                    </div>
                    <div
                        style="background: rgba(238, 233, 225, 0.2) url('{$stRUTAS.images_cat}{$Catalogo.imagen}') no-repeat; background-position:center center; background-size: cover; background-blend-mode:luminosity; height: 10rem; Border-radius: 16px 16px 32px 16px;">
                    </div>
                </a>
                <div class="card-body py-2">
                    <h6 class="card-title text-bg-dark p-0 m-0" style="margin-top: 10px;">{$Catalogo[$A]|default:$Catalogo.nombre_pt }</h6>
                </div>
            </div>
        </div>
    {/foreach}

    </div>
</div>
<!-- The end main -->
{include file="template/dir/ementa3/footer_menu.tpl"}
{include file="template/dir/ementa3/footer.tpl"}