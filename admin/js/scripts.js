ClassicEditor
	.create(document.querySelector('#editor'))
	.catch(error => {
		console.error(error);
	});

const $passwordInput = $('#password-input');

$('#password-checkbox').on('click', function () {
	if ($(this).is(':checked')) {
		$passwordInput.removeClass('hidden');
	} else {
		$passwordInput.addClass('hidden');
	}
});

$(document).ready(function () {
	$('#selectAllBoxes').click(function (e) {
		if (this.checked) {
			$('.checkbox').each(function () {
				this.checked = true;
			});
		} else {
			$('.checkbox').each(function () {
				this.checked = false;
			});
		}
	});
});