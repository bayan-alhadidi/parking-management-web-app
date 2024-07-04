//
// Toggle the side navigation
window.addEventListener("DOMContentLoaded", (event) => {
  const sidebarToggle = document.body.querySelector("#sidebarToggle");
  if (sidebarToggle) {
    sidebarToggle.addEventListener("click", (event) => {
      event.preventDefault();
      document.body.classList.toggle("sb-sidenav-toggled");
      localStorage.setItem(
        "sb|sidebar-toggle",
        document.body.classList.contains("sb-sidenav-toggled")
      );
    });
  }
});

//
// ONbarding Page Videos Carousel
const slides = document.querySelectorAll(".carousel-slide");
if (slides.length != 0) {
  let currentSlide = 0;
  setInterval(() => {
    slides[currentSlide].classList.remove("active");
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].classList.add("active");
  }, 7000);
}

//
// Animate The Hero Content In The HomePage Page On Loading.
var title = document.getElementById("hero-title");
var discription = document.getElementById("hero-discription");
var button = document.getElementById("hero-button");
if (title)
  window.addEventListener("load", () => {
    title.style.transform = "translateY(0)";
    discription.style.transform = "translateY(0)";
    button.style.transform = "translateY(0)";
    title.style.opacity = "1";
    discription.style.opacity = "1";
    button.style.opacity = "1";
  });

//
// Toggle The Login/SignUp State
var heroContent = document.getElementsByClassName("hero-content")[0];
var overlay = document.getElementById("overlay");
var loginButton = document.getElementById("primary");
var loginLink = document.getElementsByClassName("go-to-login")[0];
var signupButton = document.getElementById("secondery");
var signupLink = document.getElementsByClassName("go-to-signup")[0];
var loginForm = document.getElementsByClassName("login-form")[0];
var signupForm = document.getElementsByClassName("signup-form")[0];

// Function to show the overlay and forms
function showOverlayAndForms(formToShow) {
  overlay.style.display = "block";
  if (formToShow === "login") {
    showLoginForm();
  } else if (formToShow === "signup") {
    showSignupForm();
  }
}
// Function to check for overlay parameter and show forms if needed
function checkOverlayParameter() {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get("overlay") === "login") {
    showOverlayAndForms("login");
  } else if (urlParams.get("overlay") === "signup") {
    showOverlayAndForms("signup");
  }
}
if (heroContent) {
  function showLoginForm() {
    window.history.replaceState({}, document.title, "?overlay=login");
    heroContent.style.display = "none";
    signupForm.style.transform = "translate(-50%,-200%)";
    loginForm.style.transform = "translate(-50%,-50%)";
  }
  function showSignupForm() {
    window.history.replaceState({}, document.title, "?overlay=signup");
    heroContent.style.display = "none";
    loginForm.style.transform = "translate(-50%,-200%)";
    signupForm.style.transform = "translate(-50%,-50%)";
  }
  loginButton.addEventListener("click", showLoginForm);
  loginLink.addEventListener("click", showLoginForm);
  signupButton.addEventListener("click", showSignupForm);
  signupLink.addEventListener("click", showSignupForm);

   // Check for overlay parameter when the page loads
   checkOverlayParameter();
}

//
// Hide The Login And Sign UP Forms From Screen
if (heroContent) {
  var closeButtons = document.querySelectorAll(".close");
  console.log(closeButtons);
  closeButtons.forEach((button) => {
    button.addEventListener("click", () => {
      window.history.replaceState({}, document.title, "/");
      loginForm.style.transform = "translate(-50%,-200%)";
      signupForm.style.transform = "translate(-50%,-200%)";
      heroContent.style.display = "block";
    });
  });
   // Check for overlay parameter when the page loads
   checkOverlayParameter();
}

//
// Check For The Correct Order Of Date Input Fields Values
var dateInputs = document.querySelectorAll('input[type="date"]');
var date2Box = document.getElementById("date2Box");
var date1 = dateInputs[0];
var date2 = dateInputs[1];
var showError, errorText;
if (date2) {
  date1.addEventListener("blur", showHint);
  date2.addEventListener("blur", showHint);
  date2.addEventListener("blur", showHint);
  date1.addEventListener("focus", hideHint);
  date2.addEventListener("focus", hideHint);
}
function hintMessage() {
  if (date1.value && date2.value && date1.value >= date2.value)
    return "The selected dates cannot be equal, nor in a reversed order";
  else if (!date1.value && date2.value)
    return "Select date for the first field";
  else if (date1.value && !date2.value)
    return "Select date for the seconde field";
}
function showHint() {
  errorText = hintMessage();
  if (errorText != undefined) {
    showError = document.createElement("p");
    showError.style.cssText = "text-align:center;color:red";
    showError.append(errorText);
    date2Box.after(showError);
  }
}
function hideHint() {
  if (showError) {
    showError.remove();
  }
}

//
// Take The Selected Value In The DropDown List As A Reference In The Search Tag Field
var tagsList = document.getElementById("matchTag");
var tagInput = document.getElementById("matchTagInput");
var tagInputLabel = document.querySelector('label[name="tagPlaceHolder"]');
if (tagsList)
  tagsList.addEventListener("change", () => {
    var placeHolderValue;
    for (let i = 0; i < tagsList.options.length; i++) {
      if (tagsList.options[i].selected)
        placeHolderValue = tagsList.options[i].textContent;
    }
    tagInputLabel.textContent = `Enter value to ${placeHolderValue}`;
  });


document.getElementById('vehicleType').addEventListener('change', function() {
  var selectedValue = this.value;
  var elementToToggle1 = document.getElementById('elementToToggle1');
  var elementToToggle2 = document.getElementById('elementToToggle2');
  var elementToToggle3 = document.getElementById('elementToToggle3');
  
  // Toggle the display property based on the selected value
  if (selectedValue === 'car') {
    elementToToggle1.style.display = 'block'; // Show the element
    elementToToggle2.style.display = 'none'; // Hide the element
    elementToToggle3.style.display = 'none';  // Hide the element
  } else if (selectedValue === 'van') {
    elementToToggle1.style.display = 'none'; // Hide the element
    elementToToggle2.style.display = 'block'; // Show the element
    elementToToggle3.style.display = 'none';  // Hide the element
  }else {
    elementToToggle1.style.display = 'none'; // Hide the element
    elementToToggle2.style.display = 'none'; // Hide the element
    elementToToggle3.style.display = 'block'; // Show the element
  }
});
// Function to fetch the parking slip HTML content and print it
function printParkingSlip(id) {
  fetch('/print-slip/'+ id)
        .then(response => response.text())
        .then(html => {
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(html);
            printWindow.document.close();
            printWindow.onload = function() {
                printWindow.print();
                printWindow.close();
            };
        });
}

function confirmDelete(userId) {
  const confirmation = confirm("Are you sure you want to delete this employee?");
  if (confirmation) {
      window.location.href = `/delete-employee/${userId}`;
  }
}

function confirmDeleteSlot(slotId) {
  const confirmation = confirm("Are you sure you want to delete this slot?");
  if (confirmation) {
      window.location.href = `/delete-slot/${slotId}`;
  }
}