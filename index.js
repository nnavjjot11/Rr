document.addEventListener('DOMContentLoaded', function() {
    let toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        // ... additional options
    ];

    // Initialize Quill for the 'Add Product' form
    if (document.getElementById('editor')) {
        let addQuill = new Quill('#editor', {
            modules: { toolbar: toolbarOptions },
            theme: 'snow'
        });

        let addForm = document.querySelector('.add-products form');
        addForm.onsubmit = function() {
            document.getElementById('hidden-detail').value = addQuill.root.innerHTML;
        };
    }

    // Initialize Quill for the 'Update Product' form
    if (document.getElementById('update_editor')) {
        let updateQuill = new Quill('#update_editor', {
            modules: { toolbar: toolbarOptions },
            theme: 'snow'
        });

        let updateForm = document.querySelector('.update-container form');
        updateForm.onsubmit = function() {
            document.getElementById('update_hidden-detail').value = updateQuill.root.innerHTML;
        };

        // Additional check to ensure Quill is populated after it's fully initialized
        setTimeout(function() {
            let updateEditorContent = document.getElementById('update_editor').innerHTML;
            updateQuill.root.innerHTML = updateEditorContent;
        }, 100);
    }
});





