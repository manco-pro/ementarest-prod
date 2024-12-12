
//Icone menu 
let changeIcon = function (icon) {
  icon.classList.toggle('fa-angle-up');
}
changeIcon = (icon) => icon.classList.toggle('fa-angle-up');

let changeIconFixo = function (iconFixo) {
  iconFixo.classList.toggle('fa-angle-up');
}
changeIconFixo = (iconFixo) => iconFixo.classList.toggle('fa-angle-up');


//Pega URL, Titulo página e cor do botão menu bars
$(document).ready(function () {

  //var protocolo = window.location.protocol;
  //var host = window.location.host;
  var pagina = window.location.pathname;
  //var url_atual = window.location.href;
  var servurl = $("#nserver").text();
  var url_menu = servurl;


  //Titulo da página e cor menu footer
  switch (pagina) {
    case url_menu + "termos.php": //Termos
      titulo = $("p.titulo-page").text('Termos e condições');
      break;
    case url_menu + "menu.php": //Menu
      titulo = $("p.titulo-page").text('Menu');
      menuFooter = $("i.fa-clipboard-check").addClass('icon-page-ativo');
      break;
    case url_menu + "bebidas.php": //Bebidas
      titulo = $("p.titulo-page").text('Bebidas');
      menuFooter = $("i.fa-wine-bottle").addClass('icon-page-ativo');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='menu.php'><i class='fa-solid fa-arrow-left-long fs-5 me-2 text-dark'></i></a>");
      break;
    case url_menu + "pedidos.php": //Pedidos
      titulo = $("p.titulo-page").text('Pedidos');
      menuFooter = $("i.fa-basket-shopping").addClass('icon-page-ativo');
      break;
    case url_menu + "opiniao.php": //Opiniao
      titulo = $("p.titulo-page").text('A sua opinião');
      menuFooter = $("i.fa-comments").addClass('icon-page-ativo');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='menu.php'><i class='fa-solid fa-arrow-left-long fs-5 me-2 text-dark'></i></a>");
      break;
    case url_menu + "eventos.php": //Eventos
      titulo = $("p.titulo-page").text('Eventos');
      menuFooter = $("i.fa-calendar-days").addClass('icon-page-ativo');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='menu.php'><i class='fa-solid fa-arrow-left-long fs-5 me-2 text-dark'></i></a>");
      break;
    case url_menu + "sugestoes.php": //Sugestoes
      titulo = $("p.titulo-page").text('Sugestões');
      menuFooter = $("i.fa-utensils").addClass('icon-page-ativo');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='menu.php'><i class='fa-solid fa-arrow-left-long fs-5 me-2 text-dark'></i></a>");
      break;
    //Couvert Page
    case url_menu + "couvert.php":
      titulo = $("p.titulo-page").text('Lista');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='menu.php'><i class='fa-solid fa-arrow-left-long fs-5 text-dark me-2'></i></a>");
      break;
    //Aperitivo Page
    case url_menu + "aperitivos.php":
      titulo = $("p.titulo-page").text('Lista');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='bebidas.php'><i class='fa-solid fa-arrow-left-long fs-5 me-2 text-dark'></i></a>");
      break;
    case url_menu + "index.php":
      titulo = $("p.titulo-page").text('');
  }

  if (pagina !== "/index.php") {
    $("i.fa-bars").removeClass("text-light");
    $("i.fa-bars").addClass("text-dark");

    $("nav.nav-t").removeClass("bg-black bg-opacity-10");
    $("nav.nav-t").addClass("bg-gray");

  } else {
    console.log("Url Divergente!");
  }

  /*Alerta add*/
  $("div.alertm").click(function () {
    $("div.addalertprod").removeClass('d-none');

    $("button.close-cl").ready(function () {
      setTimeout(function () {
        $("div.addalertprod").addClass('d-none');
      }, 121218000);
    });

  });

  $("button.close-cl").click(function () {
    $("div.addalertprod").addClass('d-none');
  });

  /*Alerta add no modal*/
  $("div.alertemodal").click(function () {
    $("div.mmalert").removeClass('d-none');

    $("button.fechaemmodal").ready(function () {
      setTimeout(function () {
        $("div.mmalert").addClass('d-none');
      }, 5000);
    });

  });

  $("button.fechaemmodal").click(function () {
    $("div.mmalert").addClass('d-none');
  });

  /* Mennu idiomas */
  $("div#btn-translate").click(function () {
    $("div.menu-translate").removeClass('d-none');
  });

  /* Fecha o menu de idiomas */
  $("i.close-translate-btn").click(function () {
    $("div.menu-translate").addClass('d-none');
  });

  //$('#modalazeite').modal('show');

  //if ($(window).width() >= 767) {
  //  $("img.sl1").attr("src", "./assets3/images/evento-destaque-01-720.jpg");
  //  $("img.sl2").attr("src", "./assets3/images/evento-destaque-02-720.jpg");
  //  $("img.sl3").attr("src", "./assets3/images/evento-destaque-03-760.jpg");
  //} else {
  //  $("img.sl1").attr("src", "./assets3/images/evento-destaque-01.jpg");
  //  $("img.sl2").attr("src", "./assets3/images/evento-destaque-02.jpg");
  //  $("img.sl3").attr("src", "./assets3/images/evento-destaque-03.jpg");
  //}

  /* Begin Menu */

  var header = document.getElementById("btnul");
  var btns = header.getElementsByClassName("item-botao");
  for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("mouseover", function () {
      var current = document.getElementsByClassName("active");
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
    });
  }

    /* btn hover Tripadvisor */
    $("img#instagrambtn").mouseenter(function(){
      $("img#instagrambtn").attr("src", "./assets2/images/icon/instagram-hover.png");
    });
  
    $("img#instagrambtn").mouseleave(function(){
      $("img#instagrambtn").attr("src", "./assets2/images/icon/instagram.png");
    });
  
    /* btn hover Tripadvisor */
    $("img#tripadvisor").mouseenter(function(){
      $("img#tripadvisor").attr("src", "./assets2/images/icon/tripadvisor-hover.png");
    });
  
    $("img#tripadvisor").mouseleave(function(){
      $("img#tripadvisor").attr("src", "./assets2/images/icon/tripadvisor.png");
    });
  
    /* btn hover Google-maps */
    $("img#google-maps").mouseenter(function(){
    
      $("img#google-maps").attr("src", "./assets2/images/icon/google-maps-hover.png");
    });
  
    $("img#google-maps").mouseleave(function(){
      $("img#google-maps").attr("src", "./assets2/images/icon/google-maps.png");
    });

});