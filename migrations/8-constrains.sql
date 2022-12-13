ALTER TABLE `desksharing_dev`.`users`
ADD CONSTRAINT fk_users_role
    FOREIGN KEY (role_id)
        REFERENCES `desksharing_dev`.`roles`(id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;

ALTER TABLE `desksharing_dev`.`bookings`
    ADD CONSTRAINT fk_booking_user
    FOREIGN KEY (user_id)
        REFERENCES `desksharing_dev`.`users`(id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;

