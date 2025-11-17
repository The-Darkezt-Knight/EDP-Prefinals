
    //declaring the variables
    const form = document.querySelector("form");
    const pw_wrappers = document.querySelectorAll(".password-wrapper");
    const submit = document.getElementById("submit-btn");
    const terms = document.getElementById("terms");
    const allFields = document.querySelectorAll(".fields");
    const password = document.getElementById("password");
    const confirm = document.getElementById("confirm");
    const pw_notification = document.querySelectorAll(".pw-notification");
    const email = document.getElementById("email");
    const email_notification = document.getElementById("email-notification");

    //toggling the view-password icon
    //fixed the issue where the pw_notification translate downward whenever the password icon is clicked
    pw_wrappers.forEach(wrapper => {
      const icon = wrapper.querySelector(".icon");
      const field = wrapper.querySelector(".fields");
      const pw_notification = wrapper.querySelectorAll(".pw-notification");

      icon.addEventListener("click", (e) => {
        e.preventDefault();
        field.type = (field.type === "password") ? "text" : "password";
        
        pw_notification.forEach(notif => {
            if(field.type  === "text")
            {
                notif.style.transform = "translateY(-25px)";
            }else
            {
                notif.style.transform = "translateY(0)";
            }
        }) 
      });
    });

    //validate the email
    email.addEventListener("input", () => {
      if(!email.value.includes("@")) {
        email_notification.style.display = "block";  // show warning
      }else {
        email_notification.style.display = "none";   // hide warning
      }
    });


    //validating the password
    function validatePasswords() {
      if(password.value === confirm.value || (password.value === "" && confirm.value === "")) {
      confirm.style.outline = "";
      password.style.outline = "";
      pw_notification.forEach(notif => notif.style.display = "none");
      } else {
        confirm.style.outline = "2px solid red";
        password.style.outline = "2px solid red";
        pw_notification.forEach(notif => notif.style.display = "flex");
      }
    }

    password.addEventListener("input", validatePasswords);
    confirm.addEventListener("input", validatePasswords);


    //submitting
    //fixed the issue where client-side js blocks the submission
   submit.addEventListener("click", (e) => {
    let hasError = false;
    let firstEmpty = null;

    allFields.forEach(field => { 
      if (field.value.trim() === "") {
        field.classList.add("empty");
        if (!firstEmpty) firstEmpty = field;
        hasError = true;
      } else {
        field.classList.remove("empty");
      }
    });

    if (firstEmpty) {
      firstEmpty.focus();
      toastr.error("You must fill all the required fields to proceed", "Validation Error");
      e.preventDefault();
      return;
    }

    if (!terms.checked) {
      toastr.error("You must agree to the terms and conditions.", "Validation Error");
      e.preventDefault();
      return;
    }

  });

