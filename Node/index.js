const express = require("express");
const bodyParser = require("body-parser");
const cors = require("cors");
const { Server } = require("socket.io");
const http = require("http");
const mysql = require("mysql2");

const app = express();
const port = process.env.PORT || 5000;

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
app.use(cors());

var connection = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "password",
    database: "backend_urm",
    port: "3556",
});

connection.connect(function (err) {
    if (err) {
        console.error("error connecting: " + err.stack);
        return;
    }

    console.log("connected with database");
});

const sockets = {};

const server = http.createServer(app);

const io = new Server(server, {
    cors: {
        origin: "http://localhost:5173",
        methods: ["GET", "POST"],
    },
});

io.on("connection", (socket) => {
    if (!sockets[socket.handshake.query.user_id]) {
        sockets[socket.handshake.query.user_id] = [];
    }
    sockets[socket.handshake.query.user_id].push(socket);

    socket.on("connected", () => {
        socket.broadcast.emit("user_connected", socket.handshake.query.user_id);
        connection.query(
            `UPDATE users SET is_online = 1 WHERE id = ${socket.handshake.query.user_id}`,
            (err, res) => {
                if (err) throw err;
                console.log("User Connected", socket.handshake.query.user_id);
            }
        );
    });

    socket.on("receive_message", (data) => {
        const groupId =
            data.sender > data.receiver
                ? data.sender + data.receiver
                : data.receiver + data.sender;
        connection.query(
            `INSERT into chats (groupId,sender_user_id,receiver_user_id,message,created_at,updated_at) values ('${groupId}',${data.sender}, ${data.receiver}, '${data.message}',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)`,
            (err, res) => {
                if (err) throw err;
            }
        );
        socket.broadcast.emit("message_receive", data);
    });

    socket.on("disconnected", () => {
        socket.broadcast.emit(
            "disconnect_user",
            socket.handshake.query.user_id
        );
        for (var index in sockets[socket.handshake.query.user_id]) {
            if (
                socket.id == sockets[socket.handshake.query.user_id][index].id
            ) {
                sockets[socket.handshake.query.user_id].splice(index, 1);
            }
        }
        connection.query(
            `UPDATE users SET is_online = 0 WHERE id = ${socket.handshake.query.user_id}`,
            (err, res) => {
                if (err) throw err;
                console.log(
                    "User Disconnected",
                    socket.handshake.query.user_id
                );
            }
        );
    });
});

app.get("/", (req, res) => {
    res.send("Hello World");
});
server.listen(port, () => {
    console.log(`Server is listening on port ${port}`);
});
