function showForm(formId) {
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active"); 
  }

     function support() {
    // automatically sends email
    window.location.href = "mailto:Yummerssupport@gmail.com";
    }
