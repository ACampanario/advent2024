<script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script>
<script type="module">
    const socket = io('https://advent2024.ddev.site:8182/', {
        auth: {
            token: '<?= $token; ?>'
        }
    });
    socket.on('welcome', (message) => {
        console.log('Connnected!!!' + message)
    });
</script>

