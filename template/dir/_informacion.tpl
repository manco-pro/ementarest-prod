{include file="_cabecera.tpl"}
<div class="container-fluid">

    <div class="text-center">
        <div class="error mx-auto" data-text="UPS">UPS</div>
        <p class="lead text-gray-800 mb-5"></p>
        <p class="text-gray-500 mb-0">Parece que voc&ecirc; encontrou uma falha na matriz...</p>
        <p class="text-gray-500 mb-0">{$stMESSAGE}</p>

        {* <a href="{$stRUTAS}">&larr; Back to Dashboard</a> *}
    </div>
</div>
<!-- /.container-fluid -->

</div>
<script src="{$stRUTAS.vendor}jquery/jquery.js"></script>
<!-- End of Main Content -->
{include file="_pie.tpl"}