CREATE TABLE `cats`
(
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `type` varchar(63) DEFAULT NULL,
    description varchar (255) DEFAULT NULL,
    specials varchar (255) DEFAULT NULL,
    vaccination tinyint(1) DEFAULT 0
);
INSERT INTO cats (id, name, type, description, specials, vaccination) VALUES(null, 'Пушистик', 'thai', 'Prefer fish, not meat', 'Duck allergic', 1),
(null, 'Лева', null, 'Hate doctors', 'Charming blue eyes', 1),
(null, 'Чернышка', null, 'Prefer milk', 'Dark point on the neck', 0);


