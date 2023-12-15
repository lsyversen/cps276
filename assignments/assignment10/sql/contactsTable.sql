CREATE TABLE contacts (
    contact_id  int NOT NULL AUTO_INCREMENT,
    contact_name     char(255)   NOT NULL,
    contact_address  char(255)   NOT NULL,
    contact_city     char(255)   NOT NULL,
    contact_state    char(255)   NOT NULL,
    contact_phone    char(255)   NOT NULL,
    contact_email    char(255)   NOT NULL,
    contact_DOB      char(255)   NOT NULL,
    contact_contacts char(255)   NOT NULL,
    contact_age      char(255)   NOT NULL,
    PRIMARY KEY (contact_id)
)ENGINE=InnoDB;