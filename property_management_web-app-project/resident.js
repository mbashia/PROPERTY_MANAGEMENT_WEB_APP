// Get the payment and request forms and buttons
const paymentForm = document.getElementById("payment-form");
const requestForm = document.getElementById("request-form");
const makePaymentBtn = document.getElementById("make-payment-btn");
const makeRequestBtn = document.getElementById("make-request-btn");

// Show/hide the payment and request forms
makePaymentBtn.addEventListener("click", function() {
	paymentForm.classList.remove("hidden");
	requestForm.classList.add("hidden");
});

makeRequestBtn.addEventListener("click", function() {
	requestForm.classList.remove("hidden");
	paymentForm.classList.add("hidden");
});

// Submit the payment and request forms
const paymentFormSubmit = document.forms[0];
const requestFormSubmit = document.forms[1];

paymentFormSubmit.addEventListener("submit", function(event) {
	event.preventDefault();
	alert("Payment submitted successfully!");
	paymentForm.reset();
});

requestFormSubmit.addEventListener("submit", function(event) {
	event.preventDefault();
	alert("Request submitted successfully!");
	requestForm.reset();
});

// Toggle the "hidden" class to show/hide the payment and request forms
function toggleHiddenClass(element) {
	element.classList.toggle("hidden");
}
