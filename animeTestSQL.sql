CREATE DATABASE animetest; 

CREATE TABLE usuarios(
id INT(11) PRIMARY KEY AUTO_INCREMENT,
nombreCompleto VARCHAR(100) NOT NULL,
username VARCHAR(100) NOT NULL,
fechaNac DATE NOT NULL,
genero VARCHAR(20) NOT NULL,
mail VARCHAR(100) UNIQUE NOT NULL,
password VARCHAR(100) NOT NULL,
imagen VARCHAR(100) NOT NULL
);

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
VALUES 
('POKEMON'),
('SHINGEKI NO KYOJIN'),
('BANANA FISH'),
('DEATH NOTE'),
('HAIKYUU!');

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