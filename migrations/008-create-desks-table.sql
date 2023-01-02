CREATE TABLE `desksharing_dev`.`desks` (
    id INT NOT NULL AUTO_INCREMENT,
    code VARCHAR(255) NOT NULL,
    pos_x INT NOT NULL,
    pos_y INT NOT NULL,
    width INT NOT NULL,
    height INT NOT NULL,
    primary key (id)
) ENGINE = InnoDB;
