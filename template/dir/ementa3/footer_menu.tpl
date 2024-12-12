</main> <!-- Fechamento da tag main -->
<footer class="bg-dark fixed-bottom" style="z-index:0">
  <nav class="navbar footer-left-right">
    <div class="container-fluid align-middle ps-4">
      <a class="navbar-brand text-center link-dark" href="{$stRUTAS.ementa}index.php">
        <i class="fa-solid fa-house fs-5 icon-cl icon-cl-effect" title="Home"></i>
      </a>
      <a class="navbar-brand text-center link-dark" href="{$stRUTAS.ementa}menu.php">
        <i class="fa-solid fa-clipboard-check fs-5 icon-cl icon-cl-effect"
          {if $stACTIVA eq 'Menu'}style="color: #ffffff;" {/if} title="Menu"></i>
      </a>
      <a class="navbar-brand text-center link-dark" href="{$stRUTAS.ementa}bebidas.php">
        <i class="fa-solid fa-wine-bottle fs-5 icon-cl icon-cl-effect"
          {if $stACTIVA eq 'Bebidas'}style="color: #ffffff;" {/if} title="Bebidas"></i>
      </a>
      <a class="navbar-brand text-center link-dark" href="{$stRUTAS.ementa}sugestoes.php">
        <i class="fa-solid fa-utensils fs-5 icon-cl icon-cl-effect" {if $stACTIVA eq 'Sugestoes'}style="color: #ffffff;"
          {/if} title="Sugestão"></i>
      </a>
      <a class="navbar-brand text-center link-dark" href="{$stRUTAS.ementa}cart.php">
        <i id="iconoCarrito" class="fa-solid fa-basket-shopping fs-5 icon-cl icon-cl-effect {if $stCARRITOACTIVO== 'S'}fa-beat{else}icon-cl icon-cl-effect{/if} "
          {if $stACTIVA eq 'Cart'}style="color: #ffffff;" {/if} title=""></i>
      </a>
    </div>
  </nav>
</footer>