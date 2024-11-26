module.exports = app => {
  const cliente = require("../controllers/cliente.controller.js");

  var router = require("express").Router();

  // Create a new Tutorial
  router.post("/", cliente.create);

  // Retrieve all cliente
  router.get("/", cliente.findAll);

  // Retrieve all published cliente
  router.get("/published", cliente.findAllPublished);

  // Retrieve a single Tutorial with id
  router.get("/:id", cliente.findOne);

  // Update a Tutorial with id
  router.put("/:id", cliente.update);

  // Delete a Tutorial with id
  router.delete("/:id", cliente.delete);

  // Delete all cliente
  router.delete("/", cliente.deleteAll);

  app.use('/api/', router);
};
