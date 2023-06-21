CREATE TABLE Users (
    ID int NOT NULL AUTO_INCREMENT,
    Username varchar(255) NOT NULL,
    Password varchar(255) NOT NULL,
    Email varchar(255),
    PRIMARY KEY (ID)
);