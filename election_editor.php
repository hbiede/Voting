<?php
$_REQUEST['title'] = 'Election Editor';
include("php/header.php");
?>

<h1>Election Editor</h1>

<ul class="election-editor-list">
    <li>
        <div class="alert alert-secondary text-center" role="form">1</div>
    </li>
    <li>
        <div class="alert alert-secondary text-center" role="form">2</div>
    </li>
    <li id="add">
        <div class="alert alert-secondary text-center" role="form" onclick="addItemAbove(this);">+</div>
    </li>
</ul>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script>
    $( function() {
            $( ".election-editor-list" ).sortable({
                connectWith: '.connected',
                start: function (event, ui) {
                    if (ui.item[0].id === "add") {
                        addItemAbove(ui.item)
                    }
                },
                update: function (event, ui) {
                    //
                }
            })
            $( ".election-editor-list" ).disableSelection();
        }
    );

    function addItemAbove(uiItem) {
        window.alert("add");
    }
</script>

<?php include("php/footer.php");?>

