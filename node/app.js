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

    // Emitir un mensaje de bienvenida al cliente
    socket.emit('welcome', 'Bienvenido al servidor Socket.IO');
});

httpServer.listen(8180);
console.log('listen...');
