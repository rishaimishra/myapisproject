<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <style>
      .lds-ring {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
      .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 64px;
        height: 64px;
        margin: 8px;
        border: 8px solid #0d6efd;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #0d6efd transparent transparent transparent;
      }
      .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
      }
      .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
      }
      .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
      }
      @keyframes lds-ring {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }
      th,
      td {
        font-size: 16px;
      }
    </style>
  </head>
  <body class="p-3">
    <div class="card p-3">
      {{-- <button id="btnRepos">Repos</button> --}}
      <h4 class="mb-4">Enter Git Repo Link</h4>
      <input
        type="text"
        id="reposit"
        class="mb-4 form-control"
        placeholder="enter you repo link"
        value="https://github.com/rishaimishra/DoneWithit"
      />
      <button id="btnCommits" class="btn btn-primary">commits</button>
      <div id="divResult"></div>
    </div>

    <div
      class="card mt-4"
      id="repoData"
      style="display: none; overflow-x: auto"
    >
      <table class="table table-striped">
        <thead></thead>
        <tbody></tbody>
      </table>
    </div>
    <div class="lds-ring" style="display: none">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
    <script>
      // const btnRepos = document.getElementById("btnRepos")
      const btnCommits = document.getElementById('btnCommits');
      // btnRepos.addEventListener("click", getRepos)
      btnCommits.addEventListener('click', getCommits);

      async function getRepos() {
        const url = 'https://api.github.com';
        const response = await fetch(url);
        const result = await response.json();

        console.log(result);
      }

      function clear() {
        while (divResult.firstChild)
          divResult.removeChild(divResult.firstChild);
      }

      async function getCommits() {
        clear();
        const inputText = $('#reposit').val();

        if (!inputText.includes('github.com/')) {
          alert('please enter proper git link');
          return;
        }
        $('#repoData').hide();
        $('.lds-ring').show();
        $('#repoData thead').empty();
        $('#repoData tbody').empty();
        console.log(inputText);
        // 'https://github.com/rishaimishra/DoneWithit'

        let userName = inputText.split('github.com/')[1].split('/')[0];
        let repoName = inputText.split('github.com/')[1].split('/')[1];

        const url = `https://api.github.com/repos/${userName}/${repoName}/branches`;
        // const url = `https://api.github.com/repos/${userName}/${repoName}/git/refs/heads/master`;
        const header = {
          Accept: 'application/vnd.github.cloak-preview'
        };
        const response = await fetch(url, {
          method: 'GET',
          headers: header
        });
        const result = await response.json();
        console.log(result);

        result.forEach((item, index) => {
          console.log(item);
          let theadArr = [];
          let tableHead = '';
          let tableBody = '';

          for (let k in item) {
            if (index === 0) {
              theadArr.push(k);
              tableHead += `<th>${k}<th>`;
            }
            // theadArr.forEach(j => {
            if (k === 'commit') {
              tableBody += `<td>${item.commit.url}<td>`;
            } else {
              tableBody += `<td>${item[k]}<td>`;
            }
            // })
          }
          console.log(theadArr);
          $('#repoData thead').append(`<tr>${tableHead}</tr>`);
          $('#repoData tbody').append(`<tr>${tableBody}</tr>`);

          return;
          const anchor = document.createElement('a');
          anchor.href = item.html_url;
          anchor.textContent = item.title;
          divResult.appendChild(anchor);
          divResult.appendChild(document.createElement('br'));
        });
        $('#repoData').show();
        $('.lds-ring').hide();
      }
    </script>
  </body>
</html>
