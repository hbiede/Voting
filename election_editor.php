<?php
$_REQUEST['title'] = 'Election Editor';
include("php/header.php");
?>

<h1>Election Editor</h1>

<?php if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger text-center" role="alert">'.$_SESSION['error'].'</div>';
} unset($_SESSION['error']);?>


<ul class="election-editor-list">
</ul>

<button class="btn btn-primary" onclick="addPosition();">Add Position</button>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script>
    function addPosition() {
        let pos = "";
        do {
            pos = window.prompt("Position Title:")
        } while (pos.trim() === "");

        let ul = document.createElement("ul");
        ul.className = "election-editor-list";
        ul.innerHTML = '<li><div name="' + pos + '"class="alert alert-secondary" role="form">' + pos + '<button type="button" class="close" aria-label="Add" onclick="addCandidate(this.parent);"></button></div></li>';

        let list = $('.election-editor-list');
        list[0].appendChild(ul);
        list.sortable({
            connectWith: '.connected',
            update: function (event, ui) {
                pushUpdates();
            }
        });
        ul.disableSelection();
    }

    function addCandidate(parent) {
        let name = "";
        do {
            name = window.prompt("Position Title:")
        } while (name.trim() === "");

        let ul;
        if (parent.getElementsByTagName("ul")) {
            ul = parent.getElementsByTagName("ul")[0];
        } else {
            ul = document.createElement("ul");
            ul.className = "election-editor-inner-list";
        }
        ul.innerHTML = '<li><div class="alert alert-secondary" role="form">' + name + '</div></li>';
        parent.appendChild(ul);

        let uls = $('.election-editor-inner-list');
        uls.sortable({
            connectWith: '.connected',
            update: function (event, ui) {
                pushUpdates();
            }
        });
        uls.disableSelection();
    }

    function pushUpdates() {
        let positionData = $('.election-editor-list').children();
        let array = [];
        positionData.forEach(function (data) {
            array.push(data.firstChild.name);
        })

        $.ajax({
            data: {positionList: JSON.stringify(array)},
            type: 'POST',
            url: 'php/pushPositions.php'
        });


        let candidateData = $('.election-editor-inner-list');
        if (Array.isArray(candidateData)) {
            candidateData.forEach(function(data) {
                pushCandidates(data);
            });
        } else {
            pushCandidates(candidateData);
        }
    }

    function pushCandidates(data) {
        let array = [];
        data.children().forEach(function (child) {
            array.push(child.innerHTML);
        });
        array.unshift(data.name);
        $.ajax({
            data: {candidateList: JSON.stringify(array)},
            type: 'POST',
            url: 'php/pushCandidates.php'
        });
    }
</script>

<?php include("php/footer.php");?>

