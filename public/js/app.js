$(document).ready(function () {
    $("#back-top a").click(function () {
        $("body,html").animate(
            {
                scrollTop: 0,
            },
            800
        );
        return false;
    });

    //

    $("#deleteProjectModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var route = button.data("route"); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find("#confirmDelete").prop("href", route);
    });

    // Make active tab persist on page refresh
    $('span[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        // console.log($(e.target).attr('id'));
        localStorage.setItem("activeTab", $(e.target).attr("id"));
    });
    var activeTab = localStorage.getItem("activeTab");
    if (activeTab) {
        $(`#${activeTab}`).tab("show");
    }
});
