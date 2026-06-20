
    // Function to convert text to slug
    function convertToSlug(text) {
        return text
            .toLowerCase()
            .replace(/[^\w ]+/g, '')    // Remove special characters
            .replace(/\s+/g, '-');      // Replace spaces with dashes
    }

    // Event listener for name input field
    document.getElementById('name').addEventListener('input', function () {
        let name = this.value;
        document.getElementById('slug').value = convertToSlug(name);
    });

// Image Preview
    function previewImage(event) {
        var imagePreview = document.getElementById('imagePreview');
        var file = event.target.files[0];
        
        if (file) {
            var reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Show the image preview
            }

            reader.readAsDataURL(file);
        }
    }

    // Bulk Delete

    // Select All Categories
    function selectAll(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('.select-category');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        toggleDeleteButton();
    }

    // Show/Hide Delete Button
    function toggleDeleteButton() {
        const selected = document.querySelectorAll('.select-category:checked').length;
        const deleteButton = document.getElementById('delete-selected-btn');
        deleteButton.style.display = selected > 0 ? 'block' : 'none';
    }

    // Bulk Delete Selected Categories
    function deleteSelectedCategories() {
        if (confirm('Are you sure you want to delete the selected items?')) {
            const selectedIds = [];
            document.querySelectorAll('.select-category:checked').forEach((checkbox) => {
                selectedIds.push(checkbox.getAttribute('data-id'));
            });

            if (selectedIds.length > 0) {
                document.getElementById('category-ids').value = selectedIds.join(',');
                document.getElementById('bulk-delete-form').submit();
            }
        }
    }


   