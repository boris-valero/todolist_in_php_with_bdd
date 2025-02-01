function showEditForm(task) {
    var form = document.getElementById('edit-form-' + task);
    if (form.style.display === 'none') {
        form.style.display = 'inline';
    } else {
        form.style.display = 'none';
    }
}
