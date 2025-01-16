// public/js/validation.js

$(document).ready(function () { console.log("ghg");
    // Registration form validation
    $("#registrationForm").validate({
        rules: {
            username: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            username: {
                required: "Please enter your username",
                minlength: "Your username must consist of at least 3 characters"
            },
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please enter your password",
                minlength: "Your password must be at least 6 characters long"
            }
        }
    });

    // Login form validation
    $("#loginForm").validate({
        rules: {
            loginUsername: {
                required: true
            },
            loginPassword: {
                required: true
            }
        },
        messages: {
            loginUsername: {
                required: "Please enter your username"
            },
            loginPassword: {
                required: "Please enter your password"
            }
        }
    });
});
