# Generate JWT with CakePHP and Authenticate on NodeJS

### 1.- We add with composer the library https://github.com/lcobucci/jwt

```
composer require "lcobucci/jwt"
```

### 2.- We create the logic to generate the token with the secret phrase

src/Controller/PagesController.php

```
<?php

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

...
...

    public function generateJwt()
    {
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            Key\InMemory::plainText('EBB86CEF-63B0-411E-BA99-55F68E39049C1732552248')		//secret
        );

        $now = FrozenTime::now();
        $token = $configuration->builder()
            ->issuedBy('https://advent.ddev.site')
            ->permittedFor('https://advent.ddev.site/')
            ->identifiedBy('4f1g23a12aa')
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('uid', 'this is an example of generated JWT in CakePHP and decoded on a node app')
            ->getToken($configuration->signer(), $configuration->signingKey())
            ->toString();

        $this->set('token', $token);
    }
?>
```

### 3.- In the view of this function we load socket.io and connect to our server and port.

templates/Pages/generate_jwt.php

```
<script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script>
<script type="module">
    const socket = io('https://advent.ddev.site:8182/', {
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
```

### 4.- We create the node server, for example in: node/app.js

You can check the authentication in the function by using jsonwebtoken.verify for the token received and the secret JWT_SECRET which is the same as the one used when the token was generated.

```
import express from 'express';
import { createServer } from 'http';
import jsonwebtoken from 'jsonwebtoken';
import { Server } from 'socket.io';

const { sign, decode, verify } = jsonwebtoken;

let app = express();

const httpServer = createServer(app);
const io = new Server(httpServer, { cors: { origin: '*' } });

// jwt secret
const JWT_SECRET = 'EBB86CEF-63B0-411E-BA99-55F68E39049C1732552248';

//authentication middleware
io.use(async(socket, next) => {
    // fetch token from handshake auth sent by FE
    const token = socket.handshake.auth.token;
    try {
        // verify jwt token and get user data and save the user data into socket object, to be used further
        socket.decoded = await jsonwebtoken.verify(token, JWT_SECRET);
        console.log(socket.decoded);
        next();
    } catch (e) {
        // if token is invalid, close connection
        console.log('info', `Not Valid authentication! ${e.message} disconnected!`);

        return next(new Error(e.message));
    }
});

io.on('connection',function (socket) {

    console.log('info',`A client with socket id ${socket.id} connected!`);

    // Issue a welcome message to the customer
    socket.emit('welcome', 'Welcome to Node server!!!');
});

httpServer.listen(8180);
console.log('listen...');
```

### 5.- We launch the Node server

```
$> node node/app.js
```

connection on client side: https://imgur.com/JjJdUA7

sample token on server side: https://imgur.com/tvvA7Wt



