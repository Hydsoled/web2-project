function editComment(event) {
    var idd = event.target.id;
    var a = idd.length;
    idd = idd.replace("edit", '');
    var b = idd.length, button = "";
    if (a !== b) {
        button = document.getElementById('edit' + idd);
    } else {
        idd = idd.replace("delete", '');
        b = idd.length;
        if (a !== b) {
            button = document.getElementById('delete' + idd);
        }
    }

    if (button.innerHTML === "Edit") {
        var e = document.getElementById('comment' + idd);
        var d = document.createElement('input');
        console.log(e.innerHTML);
        d.value = e.innerHTML;
        e.parentNode.insertBefore(d, e);
        e.parentNode.removeChild(e);
        d.id = "comment" + idd;
        d.className = "form-control";
        button.innerHTML = "Submit";
    } else if (button.innerHTML === "Submit") {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

            }
        };
        xhttp.open("POST", "/blog/get-comment-post", true);
        var comment = document.getElementById('comment' + idd).value;
        var id = document.getElementById("id" + idd).innerHTML;
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(
            "comment=" + comment + "&id=" + id
        );
        var input = document.getElementById('comment' + idd);
        var div = document.createElement('div');
        div.innerHTML = input.value;
        input.parentNode.insertBefore(div, input);
        input.parentNode.removeChild(input);
        div.id = "comment" + idd;
        button.innerHTML = "Edit";
        alert('changed');
    } else if (button.innerHTML === "Delete") {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var response = xhttp.responseText;
                if (response === 'true'){
                    var com = document.getElementById('com'+id);
                    com.style.display = 'none';
                    alert('comment deleted');
                }
                else {
                    alert("delete failed");
                }
            }
        };
        xhttp.open("POST", "/blog/delete-comment", true);
        var id = document.getElementById("id" + idd).innerHTML;
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(
            "id=" + id
        );
    }

}
var page = document.getElementsByClassName('page-item');
var index = window.location.href;
var index = index[index.length-1];
page[index].style.backgroundColor = 'black';