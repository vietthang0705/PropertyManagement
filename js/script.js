function removeImgThumb(elementId, currentLoc, imgParam) {
	//alert(elementId);
	var childElement = document.getElementById(elementId);

	// pop up
	childElement.parentNode.removeChild(childElement);

	window.location = currentLoc + '&delete=' + imgParam;
	//alert(currentLoc + '&itemdel=' + elementId[2]);
	return false;
}

function removeProperty(propId) {
	window.location = 'index.php?action=confirmDelete&prop=' + propId;
	return false;
}

function returnProperty() {
	window.location = 'index.php?action=view';
	return false;
}

function removeFeature(elementId, featId) {
	var childElement = document.getElementById(elementId);

	childElement.parentNode.removeChild(childElement);

	window.location = 'features.php?action=delete&delFeature=' + featId;
	return false;
}

function removeType(elementId, typeId) {
	var childElement = document.getElementById(elementId);

	childElement.parentNode.removeChild(childElement);

	window.location = 'types.php?action=delete&delType=' + typeId;
	return false;
}

function toggleEditClient(clientId) {
	var id = 'edit-' + clientId;
	var element = document.getElementById(id);
	element.style.display = element.style.display == 'none' ? '' : 'none';
}

function toggleAddClient() {
	var tmp = document.getElementsByClassName('add-client');
	var element = tmp[0];

	element.style.display = element.style.display == 'none' ? '' : 'none';
}

function confirmDelClient(clientId) {
	var modal = document.getElementById('confirm-delete');
	modal.style.display = "block";

	var yesBtn = document.getElementById('yes');
	var noBtn = document.getElementById('no');

	noBtn.onclick = function() {
		modal.style.display = "none";
	}

	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

	yesBtn.onclick = function() {
		window.location = 'clients.php?action=delete&delete=' + clientId;
	}
}

function resetBorder(element) {
	element.style.border = "1px solid #CCCCCC";
}

function verifyAddFields(form) {
	var modal = document.getElementById('warn-input');
	var btn = document.getElementById('confirm');

	btn.onclick = function() {
		modal.style.display = "none";
	}

	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

	var submit = true;

	if (form.street.value == "") {
		form.street.style.border = "1px solid red";
		submit = false;
	}
	if (form.suburb.value == "") {
		form.suburb.style.border = "1px solid red";
		submit = false;
	}
	if (form.state.value == "") {
		form.state.style.border = "1px solid red";
		submit = false;
	}
	if (form.postcode.value == "") {
		form.postcode.style.border = "1px solid red";
		submit = false;
	}

	if (submit == false) {
		modal.style.display = "block";
	}
	return submit;
}

window.onload = function() {
	if (document.getElementById('email-msg')) {
		var modal = document.getElementById('email-msg');
		modal.style.display = "block";

		var btn = document.getElementById('okay');
		btn.onclick = function() {
			modal.style.display = "none";
		}

		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	}

	if (document.getElementById('file')) {
		var input = document.getElementById('file');
		input.addEventListener('change', function() {
			var fullPath = input.value;
			var startIndex = (fullPath.indexOf('\\') >= 0? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
			var filename = fullPath.substring(startIndex);
			if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
				filename = filename.substring(1);
			}

			var label = input.nextElementSibling;
			label.innerHTML = filename;
		});
	}

	if (document.getElementsByClassName('add-client')) {
		var tmp = document.getElementsByClassName('add-client');
		var form = tmp[0];

		//form.style.display = 'none';
	}
};
