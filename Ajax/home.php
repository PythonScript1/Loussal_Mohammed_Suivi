<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax</title>
</head>

<body>

    <main>
        <button id="btn">Data JSON</button>
        <!-- <div id="output"></div> -->

        <table>
            <thead>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Phone</th>

            </thead>

            <tbody id="table">

            </tbody>
        </table>

    </main>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- exercice 3-2 -->
<script>
    $(document).ready(function() {
        $("#btn").click(function() {
            $.ajax({
                url: 'data.json',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    displayData(data);
                }
            });
        });

        function displayData(data) {
            var tableBody = $("#table");
            tableBody.empty(); 

            $.each(data, function(index, user) {
                var row = $("<tr>");
                row.append($("<td>").text(user.username));
                row.append($("<td>").text(user.email));
                row.append($("<td>").text(user.password));
                row.append($("<td>").text(user.phone));
                tableBody.append(row);
            });
        }
    });
</script>


<!-- exercice 3-1 -->
<!-- <script>
    $(document).ready(function(){
        $("#btn").click(function(){
            $.ajax({
                url:'data.txt',
                type: 'GET',
                success: function(data){
                    $("#output").html(data);
                }
            })
        })

    })
</script> -->

<!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
<!-- exercice2 -->
<!-- 
<script>
    btn = document.getElementById('btn').addEventListener("click", fetchData);
    
    function fetchData(){
        axios.get('data.json')
        .then((response) => {
            var data = response.data;
            displayData(data);
        })
    }

    function displayData(data){
        var table = document.getElementById('table');

        table.innerHTML = '';
        for(var user in data){
            var row = table.insertRow();
            var userData = data[user];

            var col1 = row.insertCell(0);
            var col2 = row.insertCell(1);
            var col3 = row.insertCell(2);
            var col4 = row.insertCell(3);

            col1.innerHTML = userData.username ;
            col2.innerHTML = userData.email ;
            col3.innerHTML = userData.password ;
            col4.innerHTML = userData.phone ;
        }

    }
</script>
 -->

<!-- exercice1 -->
<!-- <script>
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
</script> -->

</html>