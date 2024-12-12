{include file="template/dir/ementa2/header.tpl"}

<body style="background: rgba(238, 233, 225, 0.9) url('{$stRUTAS.assets2}images/bg-index-tow.jpeg') repeat;
background-position:top center; background-size: cover; background-blend-mode:overlay; height: 100vh;">
  {include file="template/dir/ementa2/header_menu.tpl"}
  <main>
    <div class="container" style="margin-top: 5rem;">
      <div class="row" style="padding-bottom: 4rem;">
        {foreach from=$stCATALOGOS key=id item=Catalogo}
          <div class="col-12 col-sm-6 col-lg-4 col-xxl-3 px-4 mb-4 icon-cl-effect">
            <div class="card shadow" style="border-radius: 12px;">
              <a href="{$stRUTAS.ementa}{$stRUTA}.php?cat={$Catalogo.id}">
                <div class="position-relative">
                  <div class="badge text-wrap text-black position-absolute top-cl bg-cl-btn"
                    style="right:20px; font-size: 1.1rem; border-radius: 50%; width: 45px; height: 45px; padding: 0.7rem 0.4rem;">
                    <i class="fa-solid fa-arrow-right text-white text-center m-0 p-0" style="font-size: 1.4rem;"></i>
                  </div>
                </div>
                <img src="{$stRUTAS.images_cat}{$Catalogo.imagen}" width="362" height="206.7" class="card-img-top"
                  alt="Couvert" style="border-radius: 12px 12px 0 0;">
              </a>
              <div class="card-body">
                <h6 class="card-title"><strong>{$Catalogo[$A]|default:$Catalogo.nombre_pt }</strong></h6>

              </div>
            </div>
          </div>
        {/foreach}
      </div>
    </div>

  </main>
  {include file="ementa2/footer_menu.tpl"}
  {include file="ementa2/footer.tpl"}

</body>

</html>