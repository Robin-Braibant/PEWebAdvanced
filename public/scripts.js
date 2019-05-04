
(function() {
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    });
})();

function setMealToDelete(button) {
    const mealIdToDelete = button.id;
    $('#meal-id-input').val(mealIdToDelete);
}
