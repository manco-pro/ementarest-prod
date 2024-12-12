{include file="ementa/header.tpl"}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">

<body>
  {include file="ementa/header_menu.{$stLANG}.tpl"}
  <main>
    <div class="container p-4 p-sm-5 mt-5 mob">
      <div class="row">
        <!--
        <h2 class="col-12 pt-0 pb-0 ps-0 ms-2 fs-6">Categorias</h2>
        <div class="my-slider mt-3 mb-4" style="cursor: pointer">
          <div style="background-color: #eee; border-radius: 20%; width: 50px; height: 50px; margin-left: 23px;">
            <a href="#" class="link-dark" style="text-decoration: none;">
              <img src="{$stRUTAS.assets}images/icon/bolo.png" alt="" class="p-2" style="width: 50px; height: 50px;">
              <p class="fs-6 text-center">Sobre..</p>
            </a>
          </div>
          <div style="background-color: #eee; border-radius: 20%; width: 50px; height: 50px; margin-left: 23px;">
            <a href href="#" class="link-dark" style="text-decoration: none;">
              <img src="{$stRUTAS.assets}images/icon/salada.png" alt="" class="p-2" style="width: 50px; height: 50px;">
              <p class="fs-6 text-center">Veget..</p>
            </a>
          </div>
          <div style="background-color: #eee; border-radius: 20%; width: 50px; height: 50px; margin-left: 23px;">
            <a href="bebidas.html" class="link-dark" style="text-decoration: none;">
              <img src="{$stRUTAS.assets}images/icon/sucos.png" alt="" class="p-2" style="width: 50px; height: 50px;">
              <p class="fs-6 text-center">Bebid..</p>
            </a>
          </div>
          <div style="background-color: #eee; border-radius: 20%; width: 50px; height: 50px; margin-left: 23px;">
            <a href="#" class="link-dark" style="text-decoration: none;">
              <img src="{$stRUTAS.assets}images/icon/sopa.png" alt="" class="p-2" style="width: 50px; height: 50px;">
              <p class="fs-6 text-center">Sopa</p>
            </a>
          </div>
          <div style="background-color: #eee; border-radius: 20%; width: 50px; height: 50px; margin-left: 23px;">
            <a href="#" class="link-dark" style="text-decoration: none;">
              <img src="{$stRUTAS.assets}images/icon/peixe-b.png" alt="" class="p-2" style="width: 50px; height: 50px;">
              <p class="fs-6 text-center">Peixe</p>
            </a>
          </div>
          <div style="background-color: #efefef; border-radius: 20%; width: 50px; height: 50px; margin-left: 23px;">
            <a href="#" class="link-dark" style="text-decoration: none;"></a>
            <img src="{$stRUTAS.assets}images/icon/carne.png" alt="" class="p-2" style="width: 50px; height: 50px;">
            <p class="fs-6 text-center">Carne</p>
            </a>
          </div>
        </div>-->
      </div>
    </div>

    <!-- Cards -->
    <div class="container">
      <div class="row p-0 m-0 mb-5">

        <!-- Card -->
        {foreach from=$stCATALOGOS key=id item=Catalogo}
          <div class="col-12 col-sm-6  ps-0 pe-0 ps-sm-2 pe-sm-2 mb-3">
            <div class="p-3 bg-image w-100 h-100" style="background-image: url('{$stRUTAS.images_cat}{$Catalogo.imagen}'); background-repeat: no-repeat;
               background-position: center center; background-size: cover; text-align: {$Catalogo.end};">
              <a href="{$stRUTAS.ementa}{$stRUTA}.php?cat={$Catalogo.id}" class="link-underline link-underline-opacity-0"
                style="text-decoration: none;">
                <div class="w-100 h-100">
                  <h1 class="pe-1 pe-sm-3 text-white">{$Catalogo[nombre ~ '_' ~ stLANG]|default:$Catalogo.nombre_pt}</h1>
                  <p class="w-50 fs-6 float-end pe-1 pe-sm-3 text-white"><BR><BR><BR><BR><BR><BR></p>
                </div>
              </a>
            </div>
          </div>
        {/foreach}
      </div>
    </div>
  </main>
  {include file="ementa/footer_menu.tpl"}
{include file="ementa/footer.tpl"}

