ALTER TABLE `desksharing_dev`.`bookings`
    ADD CONSTRAINT fk_booking_user
    FOREIGN KEY (user_id)
        REFERENCES `desksharing_dev`.`users`(id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;

ALTER TABLE `desksharing_dev`.`bookings`
    ADD CONSTRAINT fk_booking_desk
    FOREIGN KEY (desk_id)
        REFERENCES `desksharing_dev`.`desks`(id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;

ALTER TABLE `desksharing_dev`.`users_roles`
    ADD CONSTRAINT fk_users_roles_user
        FOREIGN KEY (user_id)
            REFERENCES `desksharing_dev`.`users`(id)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;

ALTER TABLE `desksharing_dev`.`users_roles`
    ADD CONSTRAINT fk_users_roles_role
        FOREIGN KEY (role_id)
            REFERENCES `desksharing_dev`.`roles`(id)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;
