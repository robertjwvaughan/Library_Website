DROP TABLE Reservations;
DROP TABLE Books;
DROP TABLE Category;
DROP TABLE User;

CREATE TABLE User(
	Username VARCHAR(30),
	Password VARCHAR(30) NOT NULL,
	FirstName VARCHAR(30) NOT NULL,
	LastName VARCHAR(30) NOT NULL,
	AddressLine1 VARCHAR(25) NOT NULL,
	AddressLine2 VARCHAR(25) NOT NULL,
	City VARCHAR(25) NOT NULL,
	Telephone VARCHAR(10),
	Mobile VARCHAR(10) NOT NULL,
	
	CONSTRAINT User_pk PRIMARY KEY (Username)
);

CREATE TABLE Category(
	CategoryID INT(3),
	CategoryDesc VARCHAR(20) NOT NULL,
	
	CONSTRAINT Category_pk PRIMARY KEY (CategoryID)
);

CREATE TABLE Books(
	ISBN VARCHAR(20),
	BookTitle VARCHAR(40) NOT NULL,
	Author VARCHAR(60) NOT NULL,
	Edition INT(5) NOT NULL,
	Year INT(4) NOT NULL,
	Category INT(3) NOT NULL,
	Reserved VARCHAR(1) NOT NULL,
	
	CONSTRAINT Books_pk PRIMARY KEY (ISBN),
	
	CONSTRAINT Books_Category_fk FOREIGN KEY (Category) REFERENCES Category(CategoryID)
);

CREATE TABLE Reservations(
	ISBN VARCHAR(20),
	Username VARCHAR(30),
	ReserveDate DATE NOT NULL,
	
	CONSTRAINT Reserv_pk PRIMARY KEY (ISBN),
	
	CONSTRAINT Reser_User_fk FOREIGN KEY (Username) REFERENCES User(Username),
	
	CONSTRAINT Reser_Category_fk FOREIGN KEY (ISBN) REFERENCES Books(ISBN)
);


INSERT INTO User VALUES('alanjmckenna', 't1234s', 'Alan', 'McKenna', '38 Cranley Road', 'Fairview', 'Dublin', '9998377', '856625567');
INSERT INTO User VALUES('joecrotty', 'kj7899', 'Joseph', 'Crotty', 'Apt 5 Clyde Road', 'Donnybrook', 'Dublin', '8887889', '876654456');
INSERT INTO User VALUES('tommy100', '123456', 'Tom', 'Behan', '14 Hyde Road', 'Dalkey', 'Dublin', '9983747', '876738782');

INSERT INTO Category VALUES(001, 'Health');
INSERT INTO Category VALUES(002, 'Business');
INSERT INTO Category VALUES(003, 'Biography');
INSERT INTO Category VALUES(004, 'Technology');
INSERT INTO Category VALUES(005, 'Travel');
INSERT INTO Category VALUES(006, 'Self-Help');
INSERT INTO Category VALUES(007, 'Cookery');
INSERT INTO Category VALUES(008, 'Fiction');

INSERT INTO Books VALUES('093-403992', 'Computers in Business', 'Alicia O\'Neill', 3, 1997, 003, 'N');
INSERT INTO Books VALUES('23472-8729', 'Exploring Peru', 'Stephanie Birchi', 4, 2005, 005, 'N');
INSERT INTO Books VALUES('237-34823', 'Business Strategy', 'Joe Peppard', 2, 2002, 002, 'N');
INSERT INTO Books VALUES('23u8-923849', 'A Guide to Nutrition', 'John Thorpe', 2, 1997, 001, 'N');
INSERT INTO Books VALUES('2983-3494', 'Cooking for Children', 'Anabelle Sharpe', 1, 2003, 007, 'N');
INSERT INTO Books VALUES('82n8-308', 'Computers for Idiots', 'Susan O\'Neill', 5, 1998, 004, 'N');
INSERT INTO Books VALUES('9823-23984', 'My Life in Picture', 'Kevin Graham', 8, 2004, 001, 'N');
INSERT INTO Books VALUES('98234-2403-0', 'DaVinci Code', 'Dan Brown', 1, 2003, 008, 'N');
INSERT INTO Books VALUES('98234-029384', 'My Ranch in Texas', 'George Bush', 1, 2005, 001, 'Y');
INSERT INTO Books VALUES('9823-98345', 'How to Cook Italian Food', 'Jamie Oliver', 2, 2005, 007, 'y');
INSERT INTO Books VALUES('9823-98487', 'Optimising Your Business', 'Cleo Blair', 1, 2001, 002, 'N');
INSERT INTO Books VALUES('988745-234', 'Tara Road', 'Maeve Binchy', 4, 2002, 008, 'N');
INSERT INTO Books VALUES('993-004-00', 'My Life in Bits', 'John Smith', 1, 2001, 001, 'N');
INSERT INTO Books VALUES('9987-0039882', 'Shooting History', 'Jon Snow', 1, 2003, 001, 'N');

INSERT INTO Reservations VALUES('9823-23984', 'joecrotty', '2008-10-11');
INSERT INTO Reservations VALUES('9823-98345', 'tommy100', '2008-10-11');
