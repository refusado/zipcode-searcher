const BASE_URL = "http://localhost:8080/api";

async function readCep(cep) {
  const data = fetch(`${BASE_URL}?zipcode=${cep}`)
    .then(response => response.json())
    .then(data => data);

  return data;
}

const submitBtn     = document.getElementById('submit-zipcode');
const zipCodeInput  = document.getElementById('zipcode');

submitBtn.addEventListener('click', event => {
  event.preventDefault();

  const zipCode = zipCodeInput.value;
  const content = document.getElementById('content');
    
  if (content.hasChildNodes) {
    [...content.childNodes]
      .forEach(element => content.removeChild(element));
  }

  const dataContaier = document.createElement('div');
  dataContaier.classList.add('card', 'p-3');
  dataContaier.innerHTML = '<span id="loader"></span>';
  
  content.appendChild(dataContaier);

  readCep(zipCode).then(data => {
    dataContaier.innerHTML = '';

    for (const k in data) {
      const value = data[k];
      const key   = k.toUpperCase();

      const dataElement     = document.createElement('p');
      dataElement.innerHTML = `<span class="text-secondary">${key}:</span> ${value}`;

      dataContaier.appendChild(dataElement);
    }
  });
});