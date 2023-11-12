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
hash INT(10) NOT NULL,
activo VARCHAR(10) NOT NULL,
latitud VARCHAR(35) NOT NULL,
longitud VARCHAR(35) NOT NULL,
pais VARCHAR(60) NOT NULL,
ciudad VARCHAR(60) NOT NULL,
nivelUsuario INT (10) NOT NULL,
preguntasRecibidas INT(10) NOT NULL,
preguntasAcertadas INT(10) NOT NULL,
FOREIGN KEY(rol) REFERENCES roles(id));

CREATE TABLE categorias(
id INT(11)  PRIMARY KEY AUTO_INCREMENT,
categoria VARCHAR(100));

CREATE TABLE preguntas(id INT(11) PRIMARY KEY AUTO_INCREMENT,
  pregunta varchar(200) NOT NULL,
  utilizada tinyint(1) NOT NULL,
  id_categoria int(11) NOT NULL,
  nivelPregunta int(10) NOT NULL,
  cantidadEntregada int(10) NOT NULL,
  cantidadAcertada int(10) NOT NULL,
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

CREATE TABLE preguntas_reportadas(
id int(11) PRIMARY KEY AUTO_INCREMENT,
id_pregunta INT(11) NOT NULL,
mail VARCHAR(100) NOT NULL,
pregunta_reportada VARCHAR(200) NOT NULL,
FOREIGN KEY(id_pregunta) REFERENCES preguntas(id),
FOREIGN KEY(mail) REFERENCES usuarios(mail));

INSERT INTO roles(id,rol)
VALUES 
("1","Administrador"),
("2","Editor"),
("3","Jugador");
/*SE AGREGAN LOS CAMPOS HASH Y ACTIVO*/
INSERT INTO usuarios (nombreCompleto, username, fechaNac,genero, mail, password,rol, imagen, hash, activo)
VALUES ("Usuario Administrador", "Admin1","2002-02-22","Femenino","admin@gmail.com", "SuperContraseñaSecreta", "1", "admin.jpg", "113344", "SI"),
("Usuario Editor", "Editor1","2002-02-22","Masculino","editor@gmail.com", "SuperContraseñaSecreta", "2", "admin.jpg", "123456", "SI");

INSERT INTO categorias (categoria)
VALUES 
('POKEMON'),
('SHINGEKI_NO_KYOJIN'),
('BANANA_FISH'),
('DEATH_NOTE'),
('HAIKYUU');

INSERT INTO preguntas (pregunta,utilizada,id_categoria, nivelPregunta, cantidadEntregada, cantidadAcertada)
VALUES 
('Rhyhorn es tipo...', 0, 1, 5, 0, 0),
('¿Cuantos perros legendarios hay?', 0, 1, 5, 0, 0),
('¿Cuál es el tipo inicial de Pokémon de Ash en la serie de anime?', 0, 1, 5, 0, 0),
('¿Quién es el Profesor Pokémon que da a los entrenadores su primer Pokémon?', 0, 1, 5, 0, 0),
('¿Cuál es el Pokémon legendario que tiene el poder del tiempo?', 0, 1, 5, 0, 0),
('¿Qué tipo de Pokémon es Charizard?', 0, 1, 5, 0, 0),
('¿Cuál es el Pokémon inicial de tipo agua en la región de Kanto?', 0, 1, 5, 0, 0),
('¿Cuál es el Pokémon que evoluciona de Magikarp?', 0, 1, 5, 0, 0),
('¿Quién es el villano principal en el mundo de Pokémon?', 0, 1, 5, 0, 0),
('¿Cuál es el nombre del equipo maligno en la región de Sinnoh?', 0, 1, 5, 0, 0),
('¿Cuál es el legendario que representa la luna en Pokémon Sol y Luna?', 0, 1, 5, 0, 0),
('¿Cuál es el Pokémon inicial de tipo planta en la región de Galar?', 0, 1, 5, 0, 0),
('Nombre de la revista en donde se publica el manga de SNK', 0, 2, 5, 0, 0),
('¿Cuál es el nombre de la primera esposa de Grisha Jaeger?', 0, 2, 5, 0, 0),
('¿Quiénes son los personajes principales?', 0, 2, 5, 0, 0),
('¿Cuál es la trama principal de la serie?', 0, 2, 5, 0, 0),
('¿Dónde se desarrolla la historia de Attack on Titan?', 0, 2, 5, 0, 0),
('¿Qué son los Titanes en el mundo de Attack on Titan?', 0, 2, 5, 0, 0),
('¿Cuál es el objetivo de la Legión de Reconocimiento?', 0, 2, 5, 0, 0),
('¿Qué es el muro más externo en la serie?', 0, 2, 5, 0, 0),
('¿Quién es Eren Yeager y cuál es su papel en la historia?', 0, 2, 5, 0, 0),
('¿Qué son los titanes cambiantes?', 0, 2, 5, 0, 0),
('¿Quiénes son los antagonistas principales en Attack on Titan?', 0, 2, 5, 0, 0),
('¿Cuál es el significado de la frase "¡Soy tu enemigo!"?', 0, 2, 5, 0, 0),
('¿Quién es el protagonista principal de "Banana Fish"?', 0, 3, 5, 0, 0),
('¿Qué es "Banana Fish" en la serie?', 0, 3, 5, 0, 0),
('¿Dónde tiene lugar principalmente la historia de "Banana Fish"?', 0, 3, 5, 0, 0),
('¿Quién es el líder de la pandilla de Ash en "Banana Fish"?', 0, 3, 5, 0, 0),
('¿Qué tipo de arma es "Banana Fish" en la serie?', 0, 3, 5, 0, 0),
('¿Quién es el hermano mayor de Ash en "Banana Fish"?', 0, 3, 5, 0, 0),
('¿Quién es el fotógrafo que ayuda a Ash y Eiji en "Banana Fish"?', 0, 3, 5, 0, 0),
('¿Cuál es el objetivo principal de Ash en "Banana Fish"?', 0, 3, 5, 0, 0),
('¿Qué significado tiene "Banana Fish" como nombre?', 0, 3, 5, 0, 0),
('¿Quién es el villano principal en "Banana Fish"?', 0, 3, 5, 0, 0),
('¿Quienes son los autores de Death Note?', 0, 4, 5, 0, 0),
('¿Cual es la primera víctima en la cual Light prueba la Death Note?', 0, 4, 5, 0, 0),
('¿Cuál es el nombre completo del protagonista de "Death Note"?', 0, 4, 5, 0, 0),
('¿Cuál es el nombre del shinigami que deja caer el Death Note al mundo humano?', 0, 4, 5, 0, 0),
('¿Qué es necesario para que el Death Note tenga efecto en una persona?', 0, 4, 5, 0, 0),
('¿Quién se hace conocido como "L" en la serie "Death Note"?', 0, 4, 5, 0, 0),
('¿Cómo mueren las personas cuyos nombres se escriben en el Death Note?', 0, 4, 5, 0, 0),
('¿Quién es el rival principal de Light en su intento por atraparlo?', 0, 4, 5, 0, 0),
('¿Qué es lo que lleva consigo un shinigami?', 0, 4, 5, 0, 0),
('¿Cómo se llama el cuaderno que Misa Amane usa en "Death Note"?', 0, 4, 5, 0, 0),
('¿Qué es lo que debe hacer un usuario de Death Note para evitar ir al infierno después de morir?', 0, 4, 5, 0, 0),
('¿Qué se requiere para que alguien sea un legítimo usuario del Death Note?', 0, 4, 5, 0, 0),
('¿Contra que equipo debuto Yamaguchi con su saque?', 0, 5, 5, 0, 0),
('¿Quién es el protagonista principal de "Haikyuu!"?', 0, 5, 5, 0, 0),
('¿Cuál es la posición de juego de Hinata en el equipo de voleibol?', 0, 5, 5, 0, 0),
('¿Cuál es la escuela secundaria de Kageyama?', 0, 5, 5, 0, 0),
('¿Quién es el capitán del equipo Karasuno?', 0, 5, 5, 0, 0),
('¿Cuál es el apodo de Karasuno High School?', 0, 5, 5, 0, 0),
('¿Qué escuela es conocida por su equipo con uniformes negros?', 0, 5, 5, 0, 0),
('¿Quién es el entrenador del equipo Karasuno?', 0, 5, 5, 0, 0),
('¿Cuál es el segundo nombre de Shoyo Hinata?', 0, 5, 5, 0, 0),
('¿En qué año Hinata comienza la preparatoria?', 0, 5, 5, 0, 0),
('¿Cuál es el título de la canción de apertura de la primera temporada de "Haikyuu!"?', 0, 5, 5, 0, 0);



INSERT INTO respuestas (id_pregunta,respuesta,esCorrecta)
VALUES 
(1,'Tierra/Roca',0),
(1,'Tierra',0),
(1,'Roca',1),
(1,'Acero',0),
(2,'3 Perros',1),
(2,'5 Perros',0),
(2,'1 Perro',0),
(2,'7 Perros',0),
(3, 'Pikachu', 1),
(3, 'Bulbasaur', 0),
(3, 'Charmander', 0),
(3, 'Squirtle', 0),
(4, 'Profesor Oak', 1),
(4, 'Profesor Elm', 0),
(4, 'Profesor Birch', 0),
(4, 'Profesor Kukui', 0),
(5, 'Dialga', 1),
(5, 'Palkia', 0),
(5, 'Giratina', 0),
(5, 'Arceus', 0),
(6, 'Fuego / Volador', 1),
(6, 'Fuego / Dragón', 0),
(6, 'Fuego', 0),
(6, 'Volador', 0),
(7, 'Squirtle', 1),
(7, 'Totodile', 0),
(7, 'Mudkip', 0),
(7, 'Piplup', 0),
(8, 'Gyarados', 1),
(8, 'Lapras', 0),
(8, 'Milotic', 0),
(8, 'Golduck', 0),
(9, 'Giovanni', 1),
(9, 'Archie', 0),
(9, 'Cyrus', 0),
(9, 'Lysandre', 0),
(10, 'Equipo Galaxia', 1),
(10, 'Equipo Magma', 0),
(10, 'Equipo Aqua', 0),
(10, 'Equipo Plasma', 0),
(11, 'Lunala', 1),
(11, 'Solgaleo', 0),
(11, 'Necrozma', 0),
(11, 'Cosmoem', 0),
(12, 'Grookey', 1),
(12, 'Scorbunny', 0),
(12, 'Sobble', 0),
(12, 'Bulbasaur', 0),
(13,'Weekly Shonen Jump',0),
(13,'Shonen Magazine',0),
(13,'Weekly Manga Time',0),
(13,'Bessatsu Shonen Magazine',1),
(14,'Carla Jaeger',0),
(14,'Dina Fritz',1),
(14,'Frieda Reiss',0),
(14,'Faye Jaeger',0),
(15, 'Eren, Mikasa, Armin', 1),
(15, 'Levi, Historia, Sasha', 0),
(15, 'Jean, Connie, Marco', 0),
(15, 'Erwin, Hange, Zeke', 0),
(16, 'Humanidad vs. Titanes', 1),
(16, 'Exploración de mundos desconocidos', 0),
(16, 'Conspiración política en el interior de los muros', 0),
(16, 'Lucha de clanes en una aldea aislada', 0),
(17, 'Dentro de los muros de Paradis Island', 0),
(17, 'En un continente desconocido', 0),
(17, 'En un mundo postapocalíptico', 0),
(17, 'En un mundo amurallado conocido como Paradis Island', 1),
(18, 'Criaturas gigantes', 1),
(18, 'Aliens humanoides', 0),
(18, 'Zombies', 0),
(18, 'Robots asesinos', 0),
(19, 'Explorar fuera de los muros y proteger a la humanidad', 1),
(19, 'Reconstruir los muros', 0),
(19, 'Eliminar a los civiles', 0),
(19, 'Negociar con los Titanes', 0),
(20, 'El muro más externo en la serie se llama "Maria."', 1),
(20, 'El muro más externo en la serie se llama "Rose."', 0),
(20, 'El muro más externo en la serie se llama "Sina."', 0),
(20, 'El muro más externo en la serie se llama "Trost."', 0),
(21, 'Eren Yeager es el protagonista principal', 1),
(21, 'Mikasa Ackerman es el antagonista principal', 0),
(21, 'Armin Arlert es el líder de los Titanes', 0),
(21, 'Levi Ackerman es el personaje principal', 0),
(22, 'Humanos que pueden transformarse en Titanes', 1),
(22, 'Titanes gigantes que pueden volar', 0),
(22, 'Titanes que pueden hablar', 0),
(22, 'Titanes que se disfrazan de humanos', 0),
(23, 'Los Marleyanos', 1),
(23, 'Los Eldianos', 0),
(23, 'Los Alienígenas', 0),
(23, 'Los Gigantes', 0),
(24, 'Revelación de un secreto oscuro', 1),
(24, 'Saludo amistoso', 0),
(24, 'Introducción de un nuevo personaje', 0),
(24, 'Declaración de amor', 0),
(25, 'Eiji Okumura', 0),
(25, 'Ash Lynx', 1),
(25, 'Shorter Wong', 0),
(25, 'Yut-Lung', 0),
(26, 'Una droga experimental', 1),
(26, 'Una organización criminal', 0),
(26, 'Un tesoro escondido', 0),
(26, 'Una leyenda urbana', 0),
(27, 'Nueva York', 1),
(27, 'Los Ángeles', 0),
(27, 'Tokio', 0),
(27, 'Londres', 0),
(28, 'Max Lobo', 0),
(28, 'Shorter Wong', 1),
(28, 'Arthur', 0),
(28, 'Dino Golzine', 0),
(29, 'Un cuchillo envenenado', 1),
(29, 'Un arma de fuego', 0),
(29, 'Una bomba química', 0),
(29, 'Una pistola de aire comprimido', 0),
(30, 'Griffin Callenreese', 1),
(30, 'Skip', 0),
(30, 'Bones', 0),
(30, 'Charlie Dickinson', 0),
(31, 'Yut-Lung', 0),
(31, 'Shorter Wong', 0),
(31, 'Max Lobo', 0),
(31, 'Shunichi Ibe', 1),
(32, 'Vengar la muerte de su hermano', 0),
(32, 'Destruir la organización Golzine', 1),
(32, 'Encontrar a su verdadero padre', 0),
(32, 'Ser el líder de una banda', 0),
(33, 'Una referencia a una canción', 1),
(33, 'El apodo de un personaje', 0),
(33, 'Una contraseña secreta', 0),
(33, 'El nombre de una operación militar', 0),
(34, 'Dino Golzine', 1),
(34, 'Eiji Okumura', 0),
(34, 'Blanca', 0),
(34, 'Shorter Wong', 0),
(35,'Shuichi Mogi y Taro Mido',0),
(35,'Tsugumi Ohba y Takeshi Obata',1),
(35,'Hiroiko Araki y Satori Edo',0),
(35,'Akira Toriyama y Masashi Kishimoto',0),
(36,'Un bully',0),
(36,'Un motociclista abusador',0),
(36,'Un agresor durante una toma de rehenes',1),
(36,'Un politico corrupto',0),
(37, 'Light Yagami', 1),
(37, 'L Lawliet', 0),
(37, 'Near Nate River', 0),
(37, 'Misa Amane', 0),
(38, 'Rem', 0),
(38, 'Ryuk', 1),
(38, 'Sidoh', 0),
(38, 'Midora', 0),
(39, 'Ver la cara de la persona', 0),
(39, 'Conocer el nombre real y ver el rostro', 1),
(39, 'Saber el nombre completo', 0),
(39, 'Tener una fotografía de la persona', 0),
(40, 'Light Yagami', 0),
(40, 'Misa Amane', 0),
(40, 'Near Nate River', 0),
(40, 'L Lawliet', 1),
(41, 'Infarto al corazón', 0),
(41, 'Ataque de pánico', 0),
(41, 'Suicidio', 0),
(41, 'Cualquier forma de muerte', 1),
(42, 'Near Nate River', 0),
(42, 'Mello', 0),
(42, 'L Lawliet', 1),
(42, 'Ryuk', 0),
(43, 'Un Death Note', 1),
(43, 'Un arma', 0),
(43, 'Un libro', 0),
(43, 'Un reloj', 0),
(44, 'Death Diary', 0),
(44, 'Soul Notebook', 0),
(44, 'Shinigami Notebook', 0),
(44, 'Death Note', 1),
(45, 'No usar el Death Note durante 2 días', 0),
(45, 'Escribir al menos 100 nombres falsos', 0),
(45, 'Arrepentirse justo antes de morir', 0),
(45, 'Quemar el Death Note', 1),
(46, 'Hacer un pacto con un shinigami', 1),
(46, 'Tener una voluntad fuerte', 0),
(46, 'Ser un asesino', 0),
(46, 'Nada, cualquiera puede usarlo', 0),
(47,'Johzenji',0),
(47,'Seirin',0),
(47,'Aobajosai',1),
(47,'Date Tech',0),
(48, 'Shoyo Hinata', 1),
(48, 'Tobio Kageyama', 0),
(48, 'Kei Tsukishima', 0),
(48, 'Daichi Sawamura', 0),
(49, 'Central', 0),
(49, 'Libero', 0),
(49, 'Levantador', 0),
(49, 'Acomodador', 1),
(50, 'Aoba Johsai', 0),
(50, 'Nekoma', 0),
(50, 'Fukurodani', 0),
(50, 'Shiratorizawa', 1),
(51, 'Koshi Sugawara', 1),
(51, 'Ryunosuke Tanaka', 0),
(51, 'Asahi Azumane', 0),
(51, 'Kei Tsukishima', 0),
(52, 'Águilas', 0),
(52, 'Cuervos', 1),
(52, 'Tigres', 0),
(52, 'Leones', 0),
(53, 'Aoba Johsai', 0),
(53, 'Date Tech', 1),
(53, 'Shiratorizawa', 0),
(53, 'Nekoma', 0),
(54, 'Keishin Ukai', 1),
(54, 'Ikkei Ukai', 0),
(54, 'Yasufumi Nekomata', 0),
(54, 'Ittetsu Takeda', 0),
(55, 'Ryuunosuke', 0),
(55, 'Tobio', 0),
(55, 'Daichi', 0),
(55, 'Shoyo', 1),
(56, 'Segundo año', 0),
(56, 'Tercer año', 0),
(56, 'Primer año', 1),
(56, 'Cuarto año', 0),
(57, 'Imagination', 1),
(57, 'Fly High', 0),
(57, 'Hikari Are', 0),
(57, 'Ah Yeah!!', 0);






































