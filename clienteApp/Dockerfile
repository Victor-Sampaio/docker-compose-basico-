FROM node:14

WORKDIR /clienteApp
COPY package.json .
RUN npm install
RUN npm install && npm install --only=dev


CMD npm start
