<!DOCTYPE>
<html lang="ru">
<head>
    <title>Sky Net</title>
</head>
<body>

<h2>Hello! This test for <a href="https://sknt.ru/job/backend/">https://sknt.ru/job/backend/</a></h2>

<p>
    Route parameters:
    <label>user_id: <input type="text" value="1" id="user_id"></label>
    <label>service_id: <input type="text" value="1" id="service_id"></label>
</p>
<hr>

<p>
    <span>GET /users/{user_id}/services/{service_id}/tarifs</span><br>
    <button id="endpointGet">Test GET</button>
</p>
<hr>

<p>
    <span>PUT /users/{user_id}/services/{service_id}/tarif</span><br>
    <label>tarif_id: <input type="text" value="1" id="tarif_id"></label>
    <button id="endpointPut">Test PUT</button>
</p>
<hr>

<pre id="responseContainer" class="code"></pre>

<script>
    endpointGet.onclick = function () {
        fetch(`/users/${user_id.value}/services/${service_id.value}/tarifs`)
            .then(resp => resp.text())
            .then(resp => {
                responseContainer.innerText = resp;
            })
    }
    endpointPut.onclick = function () {
        fetch(`/users/${user_id.value}/services/${service_id.value}/tarif`, {
                method: 'PUT',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({tarif_id: tarif_id.value})
            })
            .then(resp => resp.text())
            .then(resp => {
                responseContainer.innerText = resp;
            })
    }
</script>

<style>
    .code {
        font-family: monospace;
        display: inline-block;
        background: #e8ffc9;
        color: #3e6d00;
        border: solid 1px #3e6d00;
        padding: 4px 4px;
        border-radius: 4px;
        margin-bottom: 4px;
    }
    input {
        width: 100px;
    }
</style>

</body>
</html>