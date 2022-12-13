CRECREATE TABLE `desksharing_dev`.`users` (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB;ATE TABLE `desksharing_dev`.`roles` (
    id INT NOT NULL AUTO_INCREMENT,
    code VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB;