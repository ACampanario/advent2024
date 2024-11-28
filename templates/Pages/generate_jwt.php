To start node please go to node dir on root directory and exec 'node app.js'
<br/><br/>
<div id="message"></div>

<script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script>
<script type="module">
    const socket = io('https://advent2024.ddev.site:8182/', {
        auth: {
            token: '<?= $token; ?>'
        }
    });
    socket.on('welcome', (message) => {
        document.getElementById('message').innerHTML = message;
        console.log('Connnected!!!' + message)
    });
    socket.on('connect_error', (err) => {
        document.getElementById('message').innerHTML = 'Error connecting to the server';
    });

</script>

