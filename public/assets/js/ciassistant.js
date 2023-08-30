//Article elements
const form = document.getElementById('writerForm');
const spinner = document.getElementById('spinner');
const submit = document.getElementById('submit');
const postWrapper = document.getElementById('postWrapper');
const articleContent = document.getElementById('articleContent');
const metaDescription = document.getElementById('metaDescription');
const articleNotifications = document.getElementById('articleNotifications');

//Image explorer elements
const imageExplorer = document.getElementById('imageExplorer');
const imageExplorerForm = document.getElementById('imageExplorerForm');
const imageSpinner = document.getElementById('imageSpinner');
const imageSubmit = document.getElementById('imageSubmit');
const keywords = document.getElementById('keywords');

const imageNotifications = document.getElementById('imageNotifications');


window.addEventListener('load', initAiWriter);

function initAiWriter() {
  form.addEventListener('submit', (event) => {
    event.preventDefault();
    openAi()
  });

  imageExplorerForm.addEventListener('submit', (event) => {
    event.preventDefault();
    imageSearch();
  });
}

function openAi(){
  //reset elements visibility
  clearNotifications(articleNotifications);
  clearNotifications(imageNotifications);

  submit.classList.add('d-none');
  spinner.classList.remove('d-none');
  postWrapper.classList.add('d-none');
  imageExplorer.classList.add('d-none');

  //clear previous data
  articleContent.innerHTML = ''
  metaDescription.innerHTML = ''
  keywords.value = ''

  //create form data and submit to api
  const data = new FormData(form);
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/api/openai', true);
  xhr.onload = function () {
    if (this.status === 200) {

      const response = JSON.parse(this.responseText);
      if (!response.error) {
        try {
          var openai_response = JSON.parse(response.data.message.content);
        } catch (e) {
          articleNotifications.innerHTML = '<p class="text-danger">Response could not be parsed. Check console for more details.</p>'
          console.log(e)
          console.log(response.data.message.content)
          showGenerateButton('Generate');
        }
        articleContent.innerHTML = openai_response.content;
        metaDescription.innerHTML = openai_response.meta_description;
        postWrapper.classList.remove('d-none');


        // show image explorer and fill keywords for image search
        keywords.value = openai_response.keywords;
        imageExplorer.classList.remove('d-none');
      }

      //check if there are any messages in response to show the notification
      if (response.message) {
        var error = response.message;
        articleNotifications.innerHTML = error
      }
    }

    showGenerateButton('Re-generate')
  }
  xhr.send(data);
}




function imageSearch(){
  clearNotifications(imageNotifications);
  
  imageSubmit.classList.add('d-none');
  imageSpinner.classList.remove('d-none');

  const data = new FormData();
  var query = keywords.value;
  query = query.replace(/ /g, '+');
  data.append('query', query);

  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/api/pexels', true);
  xhr.onload = function () {
    if (this.status === 200) {

      const response = JSON.parse(this.responseText);
      if (response.message){
        imageNotifications.innerHTML = response.message;
      }
    }

    imageSubmit.classList.remove('d-none');
    imageSpinner.classList.add('d-none');
  }
  xhr.send(data);

}

function showGenerateButton(str = 'Generate'){
  submit.innerText = str;
  submit.classList.remove('d-none');
  spinner.classList.add('d-none');
}

function clearNotifications(parent_el) {
  parent_el.innerHTML = '';
}

