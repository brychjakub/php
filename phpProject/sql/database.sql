CREATE TABLE reservations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(255) NOT NULL,
  lastname VARCHAR(255) NOT NULL,
  childBirthDate DATE NOT NULL,
  childHomeStreetAdress VARCHAR(255) NOT NULL,
  childHomeAdressNumber VARCHAR(255) NOT NULL,
  legalRepresentativeFirstname VARCHAR(255) NOT NULL,
  legalRepresentativeSurname VARCHAR(255) NOT NULL,
  legalRepresentativeEmail VARCHAR(255) NOT NULL,
  legalRepresentativePhone VARCHAR(255) NOT NULL
);
