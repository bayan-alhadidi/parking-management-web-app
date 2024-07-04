//
// Toggle The Show/Hide State For Login Password Input Field
var showIcon = document.getElementById("showIcon");
var hideIcon = document.getElementById("hideIcon");
var loginInputPassword = document.getElementById("loginInputPassword");

hideIcon.addEventListener("click", toggleLoginPassword);
showIcon.addEventListener("click", toggleLoginPassword);

function toggleLoginPassword() {
  if (loginInputPassword.getAttribute("type") == "password") {
    loginInputPassword.setAttribute("type", "text");
    hideIcon.style.display = "none";
    showIcon.style.display = "inline-block";
  } else {
    loginInputPassword.setAttribute("type", "password");
    hideIcon.style.display = "inline-block";
    showIcon.style.display = "none";
  }
}

//
// Toggle The Show/Hide State For Sign UP Password Input Field
var showIconConfirm = document.getElementById("showIconConfirm");
var hideIconConfirm = document.getElementById("hideIconConfirm");
var signupInputPassword = document.getElementById("signupInputPassword");
var inputPasswordConfirm = document.getElementById("inputPasswordConfirm");

hideIconConfirm.addEventListener("click", toggleSignUpPassword);
showIconConfirm.addEventListener("click", toggleSignUpPassword);

function toggleSignUpPassword() {
  if (inputPasswordConfirm.getAttribute("type") == "password") {
    signupInputPassword.setAttribute("type", "text");
    inputPasswordConfirm.setAttribute("type", "text");
    hideIconConfirm.style.display = "none";
    showIconConfirm.style.display = "inline-block";
  } else {
    signupInputPassword.setAttribute("type", "password");
    inputPasswordConfirm.setAttribute("type", "password");
    hideIconConfirm.style.display = "inline-block";
    showIconConfirm.style.display = "none";
  }
}

//
// The Regular Expressions To Detect Errors IN Input Fields
var NameRegEx = /^[a-zA-Z]{3,}[ ][a-zA-Z]{3,}$/g;
var EmailRegEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
var PasswordRegEx = /^.{8,15}$/g;

// Tooltips To Inform Users If Their Personal Data Aren't Correct
var inputElement = document.querySelectorAll(".needChecking");
inputElement.forEach((e) => {
  var tip = document.createElement("div");
  tip.setAttribute("class", "tip");
  var tooltipStyle = document.createElement("style");
  tooltipStyle.textContent =
    ".tip{margin-top:4px;font-size:14px;text-align:center}";
  var attribute = e.getAttribute("type");
  var errorShowed = false;

  e.addEventListener("blur", () => {
    if (e != inputPasswordConfirm) {
      if (
        (attribute == "text" &&
          e.value != e.value.match(NameRegEx) &&
          e.value != "") ||
        (attribute == "email" &&
          e.value != e.value.match(EmailRegEx) &&
          e.value != "") ||
        (attribute == "password" &&
          e.value != e.value.match(PasswordRegEx) &&
          e.value != "")
      ) {
        tip.textContent = `Invalid ${attribute} (please modify your ${attribute})`;
        e.after(tip);
        document.head.appendChild(tooltipStyle);
        tip.style.color = "red";
        e.style.cssText = "outline:auto;outline-color:red";
        errorShowed = true;
      } else if (
        (attribute == "text" && e.value == e.value.match(NameRegEx)) ||
        (attribute == "email" && e.value == e.value.match(EmailRegEx)) ||
        (attribute == "password" && e.value == e.value.match(PasswordRegEx))
      ) {
        tip.textContent = `valid ${attribute} (👍)`;
        e.after(tip);
        document.head.appendChild(tooltipStyle);
        tip.style.color = "#1af262";
        errorShowed = false;
      }
    }
    // Check The Matching Of The Password Confirming Field And The First Password Field
    else {
      if (e.value != signupInputPassword.value) {
        tip.textContent = `doesn't match the previous one`;
        e.after(tip);
        document.head.appendChild(tooltipStyle);
        tip.style.color = "red";
        e.style.cssText = "outline:auto;outline-color:red";
        errorShowed = true;
      } else if (e.value == signupInputPassword.value && e.value != "") {
        tip.textContent = `Matched ${attribute} (👍)`;
        e.after(tip);
        document.head.appendChild(tooltipStyle);
        tip.style.color = "#1af262";
        errorShowed = false;
      }
    }
  });
  e.addEventListener("focus", () => {
    if (errorShowed) tip.remove();
    e.style.outline = "none";
  });
});
