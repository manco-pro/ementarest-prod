{include file="template/dir/ementa3/header.tpl"}
{include file="template/dir/ementa3/header_menu.tpl"}


<div class="container" style="margin-top: 5rem; margin-bottom: 5rem;">
    <div class="bg-dark bg-opacity-75 w-100 h-100 px-3 pt-3 pb-1 mb-3 rounded-3 msnisert">
        <p class="fs-6 fw-normal text-white initmsn">{$stMENSAJE_TOP}</p>
    </div>

    <form method="POST" id="myForm" name="myForm" action="{$stACTION}" accept-charset="utf-8">

        <div class="mb-3">
            <label for="nome" class="form-label">{$stCAMPO_NOME}</label>
            <input type="text" class="form-control" id="inputNome" name="inputNome" placeholder="Nome"
                aria-describedby="nomeHelp">
        </div>
        <div class="mb-3">
            <label for="telemovel" class="form-label">{$stCAMPO_TELEFONE}</label>
            <input type="text" class="form-control" id="inputTelemovel" name="inputTelemovel" placeholder="Número telemóvel"
                aria-describedby="telemovelHelp">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">{$stCAMPO_EMAIL}<span class="text-danger"> *</span></label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email"
                aria-describedby="emailHelp" required>
            
        </div>
        <div class="mb-3">
            <label for="textarea" class="form-label">{$stCAMPO_OPINIAO} <span class="text-danger"> *</span></label>
            <textarea class="form-control" name="Textarea" id="Textarea" rows="3" required></textarea>
            
        </div>
        <button type="submit" name="{$stBTN_ACTION}" class="btn btn-dark w-100" >{$stBTN_ACTION}</button>
    </form>

</div>

<!-- Modal MSN ADD Item msnalert-->
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
{include file="ementa3/footer_menu.tpl"}

{include file="ementa3/footer.tpl"}