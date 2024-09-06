$(document).ready(function () {
    
    $("form").submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        
        // Collect form data
        var formData = {
            name: $("#Username").val(),
            email: $("#Email").val(),
            message: $("#message").val(),
        };
        
        // Clear previous error messages
        $("#msg-err").html("");

        // AJAX request
        $.ajax({
            type: "POST",
            url: "../Controller/contactUsValidations.php",
            data: formData,
            dataType: "json",
            encode: true,
        })
        .done(function (data) {
            if (!data.success) {
                if (data.errors.message) {
                    $("#msg-err").html(data.errors.message);
                }
            } else {
                // Display success message and clear the form
                $("form").html('<div class="alert alert-success">' + data.message + '</div>');
            }
        })
        .fail(function () {
            // Display error if request fails
            $("form").html('<div class="alert alert-danger">Could not reach server, please try again later.</div>');
        });
    });
    console.log("Contact Form Script Loaded");
});
