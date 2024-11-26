const db = require("../models");
const Cliente = db.cliente;
const Op = db.Sequelize.Op;

// Create and Save a new Cliente
exports.create = (req, res) => {
  // Validate request
  if (!req.body.nome) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
    return;
  }

  // Create a Cliente
  const cliente = {
    nome: req.body.nome,
    sobrenome: req.body.sobrenome,
    cpf: req.body.cpf,
    idade: req.body.idade

  };

  // Save Cliente in the database
  Cliente.create(cliente)
    .then(data => {
      res.send(data);
    })
    .catch(err => {
      res.status(500).send({
        message:
          err.message || "Some error occurred while creating the Cliente."
      });
    });
};

// Retrieve all Clientes from the database.
exports.findAll = (req, res) => {
  const title = req.query.title;
  var condition = title ? { title: { [Op.like]: `%${title}%` } } : null;

  Cliente.findAll({ where: condition })
    .then(data => {
      res.send(data);
    })
    .catch(err => {
      res.status(500).send({
        message:
          err.message || "Some error occurred while retrieving Clientes."
      });
    });
};

// Find a single Cliente with an id
exports.findOne = (req, res) => {
  const id = req.params.id;

  Cliente.findByPk(id)
    .then(data => {
      res.send(data);
    })
    .catch(err => {
      res.status(500).send({
        message: "Error retrieving Cliente with id=" + id
      });
    });
};

// Update a Cliente by the id in the request
exports.update = (req, res) => {
  const id = req.params.id;

  Cliente.update(req.body, {
    where: { id: id }
  })
    .then(num => {
      if (num == 1) {
        res.send({
          message: "Cliente was updated successfully."
        });
      } else {
        res.send({
          message: `Cannot update Cliente with id=${id}. Maybe Cliente was not found or req.body is empty!`
        });
      }
    })
    .catch(err => {
      res.status(500).send({
        message: "Error updating Cliente with id=" + id
      });
    });
};

// Delete a Cliente with the specified id in the request
exports.delete = (req, res) => {
  const id = req.params.id;

  Cliente.destroy({
    where: { id: id }
  })
    .then(num => {
      if (num == 1) {
        res.send({
          message: "Cliente was deleted successfully!"
        });
      } else {
        res.send({
          message: `Cannot delete Cliente with id=${id}. Maybe Cliente was not found!`
        });
      }
    })
    .catch(err => {
      res.status(500).send({
        message: "Could not delete Cliente with id=" + id
      });
    });
};

// Delete all Clientes from the database.
exports.deleteAll = (req, res) => {
  Cliente.destroy({
    where: {},
    truncate: false
  })
    .then(nums => {
      res.send({ message: `${nums} Clientes were deleted successfully!` });
    })
    .catch(err => {
      res.status(500).send({
        message:
          err.message || "Some error occurred while removing all Clientes."
      });
    });
};

// find all published Cliente
exports.findAllPublished = (req, res) => {
  Cliente.findAll({ where: { published: true } })
    .then(data => {
      res.send(data);
    })
    .catch(err => {
      res.status(500).send({
        message:
          err.message || "Some error occurred while retrieving Clientes."
      });
    });
};
