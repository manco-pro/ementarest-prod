
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

  //Titulo da página e cor menu footer
  switch (pagina) {
    case "/restaurant-template-tow/termos.html":
      titulo = $("p.titulo-page").text('Termos e condições');
      break;
    case "/restaurant-template-tow/menu.html":
      titulo = $("p.titulo-page").text('Menu');
      menuFooter = $("i.fa-clipboard").addClass('icon-page-ativo');
      break;
    case "/restaurant-template-tow/restaurante.html":
      titulo = $("p.titulo-page").text('Restaurante');
      menuFooter = $("i.fa-store").addClass('icon-page-ativo');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='menu.html'><i class='fa-solid fa-arrow-left-long fs-5 text-white'></i></a>");
      break;
    case "/restaurant-template-tow/bebidas.html":
      titulo = $("p.titulo-page").text('Bebidas');
      menuFooter = $("i.fa-wine-bottle").addClass('icon-page-ativo');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='menu.html'><i class='fa-solid fa-arrow-left-long fs-5 text-white'></i></a>");
      break;
    case "/restaurant-template-tow/cart.html":
      titulo = $("p.titulo-page").text('My Cart');
      menuFooter = $("i.fa-basket-shopping").addClass('icon-page-ativo');
      break;
    case "/restaurant-template-tow/opiniao.html":
      titulo = $("p.titulo-page").text('A sua opinião');
      menuFooter = $("i.fa-comments").addClass('icon-page-ativo');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='menu.html'><i class='fa-solid fa-arrow-left-long fs-5 text-white'></i></a>");
      break;
    case "/restaurant-template-tow/eventos.html":
      titulo = $("p.titulo-page").text('Eventos');
      menuFooter = $("i.fa-calendar-days").addClass('icon-page-ativo');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='menu.html'><i class='fa-solid fa-arrow-left-long fs-5 text-white'></i></a>");
      break;
    case "/restaurant-template-tow/sugestoes.html":
      titulo = $("p.titulo-page").text('Sugestões');
      menuFooter = $("i.fa-cheese").addClass('icon-page-ativo');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='menu.html'><i class='fa-solid fa-arrow-left-long fs-5 text-white'></i></a>");
      break;
    case "/restaurant-template-tow/bebidas.html":
      titulo = $("p.titulo-page").text('Bebidas');
      menuFooter = $("i.fa-wine-bottle").addClass('icon-page-ativo');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='menu.html'><i class='fa-solid fa-arrow-left-long fs-5 text-white'></i></a>");
      break;
    //Couvert Page
    case "/restaurant-template-tow/couvert.html":
      titulo = $("p.titulo-page").text('Couvert');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='restaurante.html'><i class='fa-solid fa-arrow-left-long fs-5 text-white'></i></a>");
      break;
    //Aperitivo Page
    case "/restaurant-template-tow/aperitivos.html":
      titulo = $("p.titulo-page").text('Aperitivo');
      btnNavbar = $("button.btnclnew").remove();
      bnewnav = $("button.newbtnnav").removeClass('d-none');
      btnL = $("button.newbtnnav").html("<a href='restaurante.html'><i class='fa-solid fa-arrow-left-long fs-5 text-white'></i></a>");
      break;
    case "/restaurant-template-tow/index.html":
      titulo = $("p.titulo-page").text('');
  }

  if (pagina !== "/index.html") {
    $("i.fa-bars").removeClass("text-light");
    $("i.fa-bars").addClass("text-dark");

    $("nav.nav-t").removeClass("bg-black bg-opacity-10");
    $("nav.nav-t").addClass("bg-gray");

  } else {
    //console.log("Url Divergente!");
  }

  /*Alerta add*/
  $("div.alertm").click(function () {
    $("div.addalertprod").removeClass('d-none');

    $("button.close-cl").ready(function () {
      setTimeout(function () {
        $("div.addalertprod").addClass('d-none');
      }, 3000);
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