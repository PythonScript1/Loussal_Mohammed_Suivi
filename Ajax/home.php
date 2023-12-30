<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax</title>
</head>
<body>

<main>
<button id="btn">Click me</button>
    <div id="output"></div>
</main>
</body>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
   btn = document.getElementById('btn').addEventListener("click", fetchData);
   output = document.getElementById('output');

   function fetchData(){
    axios.get('data.txt')
    .then((response) => {
        var data = response.data;

        output.innerHTML += "username: " + data.username + "<br/>";
        output.innerHTML += "email:" + data.email + "<br/>";
        output.innerHTML += "password:" + data.password + "<br/>";
        output.innerHTML += "phone:" + data.phone + "<br/>";

    })
    
   }
</script>

</html>