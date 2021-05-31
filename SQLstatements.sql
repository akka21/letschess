DROP DATABASE letschess;

CREATE DATABASE letschess;

USE letschess;

CREATE TABLE schaakvereniging (
    verenigingID INT NOT NULL AUTO_INCREMENT,
    naam VARCHAR(255) NOT NULL,
    telefoonnummer varchar(255),
    PRIMARY KEY(verenigingID)
);

CREATE TABLE speler (
    spelerID INT NOT NULL AUTO_INCREMENT,
    voornaam VARCHAR(255) NOT NULL,
    tussenvoegsel VARCHAR(255),
    achternaam VARCHAR(255) NOT NULL,
    neemtdeel boolean NOT NULL,
    verenigingID INT NOT NULL,
    FOREIGN KEY (verenigingID) REFERENCES schaakvereniging(verenigingID),
    PRIMARY KEY(spelerID)
);

CREATE TABLE toernooi (
    toernooiID INT NOT NULL AUTO_INCREMENT,
    toernooi VARCHAR(255) NOT NULL,
    PRIMARY KEY (toernooiID)
);

CREATE TABLE wedstrijd (
    wedstrijdID INT NOT NULL AUTO_INCREMENT,
    ronde INT NOT NULL,
    speler1ID INT NOT NULL,
    speler2ID INT NOT NULL,
    punten1 INT NOT NULL,
    punten2 INT NOT NULL,
    toernooiID INT NOT NULL,
    winnaarID INT NOT NULL,
    FOREIGN KEY (toernooiID) REFERENCES toernooi(toernooiID),
    FOREIGN KEY (speler1ID) REFERENCES speler(spelerID),
    FOREIGN KEY (speler2ID) REFERENCES speler(spelerID),
    FOREIGN KEY (winnaarID) REFERENCES speler(spelerID),
    PRIMARY KEY(wedstrijdID)
);


