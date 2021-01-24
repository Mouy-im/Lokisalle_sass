<?php include_once('../inc/init.inc.php');?>
<?php include_once("../inc/haut.inc.php");?>
<?php include_once('../inc/menu.inc.php');?>
<div id="test" class="conteneur py-5">
  <h1>Test</h1>
<!-- Button HTML (to Trigger Modal) -->
<a href="#" class="btn btn-lg btn-primary" data-toggle="modal">Launch Demo Modal</a>
    
<!-- Modal HTML -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you want to save changes to this document before closing?</p>
                <p class="text-secondary"><small>If you don't save, your changes will be lost.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
</div>


<?php include_once('../inc/bas.inc.php');?>