module.exports = (sequelize, Sequelize) => {
  const cliente = sequelize.define("cliente", {
    nome: {
      type: Sequelize.STRING
    },
    sobrenome: {
      type: Sequelize.STRING
    },
    cpf: {
      type: Sequelize.STRING
    },
    idade: {
      type: Sequelize.STRING
    }
  });

  return cliente;
};
