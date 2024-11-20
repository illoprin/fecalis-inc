function set_status(id, value) {
	const request = {
		request_type: 'set_status',
		id, value
	};
	post_data('/server/admin.php', request, () => {
	}, 
	(response) => {
		if (response.status == 0) {
			redirect('/app/admin?mode=order');
		}
	})
}

function remove_product(id) {
	const request = {
		request_type: 'remove_product',
		id
	};
	post_data('/server/admin.php', request, () => {
	}, (response) => {
		if (response.status == 0) {
			redirect('/app/admin?mode=product');
		}
	})
}

function add_product() {
	const form_elements = document.forms.np.elements;
	const form_fields = {
		img_src: form_elements.product_img.files[0],
		title: form_elements.title.value,
		vendor: form_elements.vendor.value,
		description: form_elements.description.value,
		price: Number(form_elements.price.value),
		category_id: Number(form_elements.category_id.value)
	};
	hasEmpty = false;
	for (const [key, value] of Object.entries(form_elements))
		hasEmpty = !value ? true : hasEmpty;
	if (!hasEmpty) {
		const form_data = new FormData();

		for (const [key, value] of Object.entries(form_fields)) {
			form_data.append(key, value);
		}

		fetch('/server/action/add_product.php', {
			method: 'POST',
			body: form_data
		})
		.then(response => response.json())
		.then(data => {
			console.log(data);
			// Close modal window
			$('#new_product_modal').modal('hide');
		})
		.catch(error => {
			alert(error.message);
		});
	}

}