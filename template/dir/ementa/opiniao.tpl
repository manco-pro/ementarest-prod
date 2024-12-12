{include file="ementa/header.tpl"}

<body>
  {include file="ementa/header_menu.{$stLANG}.tpl"}
  <main>
    </div>
    <div class="container" style="margin-top: 5rem;">
      <div class="bg-info w-100 h-100 px-3 pt-3 pb-1 mb-3 rounded-3">
        <h3 class="fs-5 fw-bold text-dark">Sua opini&atilde;o importa muito para n&oacute;s!</h3>
        <p class="fs-6 fw-normal text-dark">Deixe-nos saber da sua expari&ecirc;ncia para que possamos melhorar cada vez
          mais seu atendimento.</p>
      </div>
      <form method="POST" id="myForm" name="myForm" action="{$stACTION}" accept-charset="utf-8">
        <div class="mb-3">
          <label for="inputNome" class="form-label">Nome</label>
          <input type="text" name="inputNome" class="form-control" id="inputNome" aria-describedby="nomeHelp">
        </div>
        <div class="mb-3">
          <label for="inputTelemovel" class="form-label">Telemovil</label>
          <input type="text" name="inputTelemovel" class="form-control" id="inputTelemovel" aria-describedby="nomeHelp">
        </div>
        <div class="mb-3">
          <label for="inputEmail" class="form-label">E-mail*</label>
          <input type="email" required name="inputEmail" class="form-control" id="inputEmail"
            aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="Textarea" class="form-label">Sua opini&atilde;o*</label>
          <textarea required class="form-control" name="Textarea" id="Textarea" rows="3"></textarea>
        </div>
        <button type="submit" name="{$stBTN_ACTION}" class="btn btn-dark w-100" data-bs-toggle="modal"
          data-bs-target="#msnform">Enviar</button>
      </form>
    </div>
  </main>
  <!-- Modal MSN ADD Item msnform -->
  <div class="modal fade" id="msnform" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <strong>A Sua opniao foi registrada com sucesso.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  {include file="ementa/footer_menu.tpl"}

{include file="ementa/footer.tpl"}