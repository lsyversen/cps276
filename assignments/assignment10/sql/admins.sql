DROP TABLE IF EXISTS `admins`;
CREATE TABLE admins (
    admin_id    int NOT NULL AUTO_INCREMENT,
    admin_name      char(255)   NOT NULL,
    admin_email     char(255)   NOT NULL,
    admin_password  char(255)   NOT NULL,
    admin_status    char(255)   NOT NULL, 
    PRIMARY KEY (admin_id)
)ENGINE=InnoDB;

INSERT INTO admins(admin_name, admin_email, admin_password, admin_status)
VALUES ('Liam Syversen', 'lsyversen@admin.com', '$2y$10$YB3QWJyvqVgP5wkLU9TOdu7DzFsvuIuaAnQ5X4yb9hFSrOVqGS2o2', 'admin');

INSERT INTO admins(admin_name, admin_email, admin_password, admin_status)
VALUES ('Liam Syversen', 'lsyversen@staff.com', '$2y$10$YB3QWJyvqVgP5wkLU9TOdu7DzFsvuIuaAnQ5X4yb9hFSrOVqGS2o2', 'staff');


