CREATE DATABASE animetest; 

CREATE TABLE categorias(
id INT(11)  PRIMARY KEY AUTO_INCREMENT,
categoria VARCHAR(100));

CREATE TABLE preguntas(id INT(11) PRIMARY KEY AUTO_INCREMENT,
  pregunta varchar(200) NOT NULL,
  utilizada tinyint(1) NOT NULL,
  id_categoria int(11) NOT NULL,
FOREIGN KEY(id_categoria) REFERENCES categorias(id));

CREATE TABLE respuestas(
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  id_pregunta int(11) NOT NULL,
  respuesta varchar(200) NOT NULL,
  esCorrecta tinyint(1) NOT NULL,
FOREIGN KEY(id_pregunta) REFERENCES preguntas(id));

INSERT INTO categorias (categoria)
VALUES ('POKEMON');