CREATE TABLE devices (

	id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project VARCHAR(20) NOT NULL,
    dtype ENUM('HUB', 'ROUTER', 'HOST') NOT NULL,
    ipaddr INT UNSIGNED UNIQUE,
    netmask INT UNSIGNED,
    dgateway INT UNSIGNED,
    FOREIGN KEY (project) REFERENCES projects(pname)
    ON DELETE CASCADE ON UPDATE CASCADE,
    CHECK(dtype != 'HOST' AND ipaddr IS NULL AND netmask IS NULL AND dgateway IS NULL)
);