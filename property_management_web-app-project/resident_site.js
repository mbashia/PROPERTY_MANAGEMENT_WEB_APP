const paymentForm = document.querySelector('#payment-form');
const requestForm = document.querySelector('#request-form');
const messageSuccess = document.querySelector('#message-success');
const requestSuccess = document.querySelector('#request-success');
const senderId = document.querySelector('#sender-id').value;

paymentForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const message = document.querySelector('#message').value.trim();

  if (!message) {
    showError('Please enter a message.');
  } else {
    showMessageSuccess('Your message has been sent successfully!');
    paymentForm.reset();
    sendFormData('message', message, senderId);
  }
});

requestForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const request = document.querySelector('#request').value.trim();

  if (!request) {
    showError('Please enter a request.');
  } else {
    showRequestSuccess('Your request has been submitted successfully!');
    requestForm.reset();
    sendFormData('request', request, senderId);
  }
});

function sendFormData(type, data, senderId) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'submit-form.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    console.log(this.responseText);
  }
  xhr.send(`type=${type}&data=${data}&sender_id=${senderId}`);
}
