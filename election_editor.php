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
<button class="btn btn-primary" onclick="pushUpdates();">Save</button>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script>
    function addPosition() {
        let pos = "";
        do {
            pos = window.prompt("Position Title:")
        } while (pos && pos.trim() === "");

        let li = document.createElement("li");
        li.className = "position-list"
        li.innerHTML = '<div class="alert alert-secondary" role="form">' + pos + '<button type="button" class="close" aria-label="Add" onclick="addCandidate(this.parentNode.parentNode);">&plus;</button><button type="button" class="close" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><ul class="election-editor-inner-list"></ul>';

        let list = $('.election-editor-list');
        list[0].appendChild(li);
        list.sortable();
        list.disableSelection();
    }

    function addCandidate(parent) {
        let name = "";
        do {
            name = window.prompt("Candidate Name:")
        } while (name && name.trim() === "");

        let ul;
        if (parent.getElementsByTagName("ul")) {
            ul = parent.getElementsByTagName("ul")[0];
        } else {
            ul = document.createElement("ul");
            ul.className = "election-editor-inner-list";
        }
        ul.innerHTML += '<li><div class="alert alert-secondary" role="form">' + name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></li>';
        parent.appendChild(ul);

        let uls = $('.election-editor-inner-list');
        uls.sortable();
        uls.disableSelection();
    }

    function pushUpdates() {
        let positionData = $('.election-editor-list').children();
        let array = [];
        positionData.toArray().forEach(function (data) {
            array.push(data.innerText.split(/\r?\n/)[0]);
        })

        $.ajax({
            data: {positionList: JSON.stringify(array)},
            type: 'POST',
            url: 'php/pushPositions.php'
        });


        let candidateData = $('.election-editor-inner-list');
        if (candidateData.length > 0) {
            candidateData.toArray().forEach(function(data) {
            	console.log("C1: " + data);
                pushCandidates(data);
            });
        }
    }

    function pushCandidates(data) {
    	if (data.innerText && data.innerText !== "") {
    		let array = [];
    		
    		for (let i = 0; i < data.children.length; i++) {
    			array.push(data.children[i].innerText.split(/\r?\n/)[0]); //split on new lines accounting for Windows
    		}
			array.unshift(data.parentNode.firstChild.innerText.split(/\r?\n/)[0]);
			console.log(array);
			$.ajax({
				data: {candidateList: JSON.stringify(array)},
				type: 'POST',
				url: 'php/pushCandidates.php',
				success: function(data) {
					window.alert("C" + data);
				}
			});
			console.log(array);
		}
	}
</script>

<?php include("php/footer.php");?>

