require("dotenv").config();
const express = require("express");
const cors = require("cors");

const app = express();

var corsOptions = {
  origin: "http://localhost:8081"
};

app.use(cors(corsOptions));


app.use(express.json());


app.use(express.urlencoded({ extended: true }));

const db = require("./app/models");

db.sequelize.sync();


app.get("/", (req, res) => {
  res.json({ message: "Welcome to application." });
});

require("./app/routes/cliente.routes")(app);


const PORT = process.env.NODE_DOCKER_PORT || 8080;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}.`);
});
