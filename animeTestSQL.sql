CREATE DATABASE animetest; 

CREATE TABLE roles(
id INT(1) PRIMARY KEY,
rol VARCHAR(30) NOT NULL);

CREATE TABLE usuarios(
id INT(11) PRIMARY KEY AUTO_INCREMENT,
nombreCompleto VARCHAR(100) NOT NULL,
username VARCHAR(100) NOT NULL,
fechaNac DATE NOT NULL,
genero VARCHAR(20) NOT NULL,
mail VARCHAR(100) UNIQUE NOT NULL,
password VARCHAR(100) NOT NULL,
rol INT(1) NOT NULL,
imagen VARCHAR(100) NOT NULL,
FOREIGN KEY(rol) REFERENCES roles(id));

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

CREATE TABLE ranking(
  mail VARCHAR(100) NOT NULL PRIMARY KEY,
  puntajesPorPartida VARCHAR(1024), 
  puntajeTotal int(11),
  FOREIGN KEY(mail) REFERENCES usuarios(mail));

CREATE TABLE sugeridas(
id INT(11) PRIMARY KEY AUTO_INCREMENT,
preguntaSugerida VARCHAR(300) NOT NULL,
respuestaSugeridaA VARCHAR(50) NOT NULL,
respuestaSugeridaB VARCHAR(50) NOT NULL,
respuestaSugeridaC VARCHAR(50) NOT NULL,
respuestaSugeridaD VARCHAR(50) NOT NULL,
id_categoria int(11) NOT NULL,
FOREIGN KEY(id_categoria) REFERENCES categorias(id));


INSERT INTO roles(id,rol)
VALUES 
("1","Administrador"),
("2","Editor"),
("3","Jugador");

INSERT INTO usuarios (nombreCompleto, username, fechaNac,genero, mail, password,rol, imagen)
VALUES 
("Usuario Administrador", "Admin1","2002-02-22","Femenino","admin@gmail.com", "SuperContraseñaSecreta", "1", "admin.jpg"),
("Usuario Editor", "Editor1","2002-02-22","Masculino","editor@gmail.com", "SuperContraseñaSecreta", "2", "admin.jpg");

INSERT INTO categorias (categoria)
VALUES 
('POKEMON'),
('SHINGEKI_NO_KYOJIN'),
('BANANA_FISH'),
('DEATH_NOTE'),
('HAIKYUU');

INSERT INTO preguntas (pregunta,utilizada,id_categoria)
VALUES 
('Rhyhorn es tipo...',0,1),
('¿Cuantos perros legendarios hay?',0,1),
('¿Que es banana fish en la serie?',0,3),
('¿Cual es la primera víctima en la cual Light prueba la Death Note?',0,4),
('¿Quienes son los autores de Death Note?',0,4),
('¿Contra que equipo debuto Yamaguchi con su saque?',0,5),
('Nombre de la revista en donde se publica el manga de SNK',0,2),
('¿Cuál es el nombre de la primera esposa de Grisha Jaeger?',0,2);

INSERT INTO respuestas (id_pregunta,respuesta,esCorrecta)
VALUES 
(1,'Tierra/Roca',0),
(1,'Tierra',0),
(1,'Roca',1),
(1,'Acero',0),
(2,'3',1),
(2,'5',0),
(2,'1',0),
(2,'7',0),
(3,'Una cancion',1),
(3,'Una institucion',0),
(3,'El villano principal',0),
(3,'Una droga',1),
(4,'Un bully',0),
(4,'Un motociclista abusador',0),
(4,'Un agresor durante una toma de rehenes',1),
(4,'Un politico corrupto',0),
(5,'Shuichi Mogi y Taro Mido',0),
(5,'Tsugumi Ohba y Takeshi Obata',1),
(5,'Hiroiko Araki y Satori Edo',0),
(5,'Akira Toriyama y Masashi Kishimoto',0),
(6,'Johzenji',0),
(6,'Seirin',0),
(6,'Aobajosai',1),
(6,'Date Tech',0),
(7,'Weekly Shonen Jump',0),
(7,'Shonen Magazine',0),
(7,'Weekly Manga Time',0),
(7,'Bessatsu Shonen Magazine',1),
(8,'Carla Jaeger',0),
(8,'Dina Fritz',1),
(8,'Frieda Reiss',0),
(8,'Faye Jaeger',0);