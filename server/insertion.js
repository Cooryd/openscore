var parts = window.location.href.split("content/");
doi = parts[1].split("v")[0];


function insertAfter(newNode, referenceNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
};
// example
var newEl = document.createElement('div');
newEl.innerHTML = '<iframe style="width:100%" src="https://rateapaper.nfshost.com/?doi='+doi+'"></iframe>';

var ref = document.querySelector('div.pane-biorxiv-art-tools');

insertAfter(newEl, ref);