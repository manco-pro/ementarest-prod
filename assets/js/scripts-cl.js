
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

  var protocolo = window.location.protocol;
  var host = window.location.host;
  var pagina = window.location.pathname;
  var url_atual = window.location.href;

  //Titulo da página e cor menu footer
   if (pagina !== "/index.html") {
    $("i.fa-bars").removeClass("text-light");
    $("i.fa-bars").addClass("text-dark");

    $("nav.nav-t").removeClass("bg-black bg-opacity-10");
    $("nav.nav-t").addClass("bg-gray");

  } else {
    console.log("Url Divergente!");
  }

  /*Alerta add*/
  // $("div.alertm").click(function () {
  //   $("div.addalertprod").removeClass('d-none');

  //   $("button.close-cl").ready(function () {
  //     setTimeout(function () {
  //       $("div.addalertprod").addClass('d-none');
  //     }, 3000);
  //   });

  // });

  $("div.alertm").click(function () {
    $("div.addalertprod").removeClass('d-none');

    $("button.close-cl").click(function () {
      $("div.addalertprod").addClass('d-none');
    });

    setTimeout(function () {
      $("div.addalertprod").addClass('d-none');
    }, 3000);
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
      }, 3000);
    });

  });

  $("button.fechaemmodal").click(function () {
    $("div.mmalert").addClass('d-none');
  });


  /*var slider = tns({
    container: '.my-slider',
    controls: false,
    center: true,
    nav: false,
    touch: true,
    items: 6,
    responsive: {
      640: {
        edgePadding: 10,
        gutter: 20,
        items: 6
      },
      700: {
        edgePadding: 30,
        gutter: 20,
        items: 5
      },
      900: {
        edgePadding: 20,
        gutter: 20,
        items: 5
      }
    }
  }); */
});



