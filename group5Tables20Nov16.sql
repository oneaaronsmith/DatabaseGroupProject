Drop table if exists Customer;
Drop table if exists Reservation;
Drop table if exists Flights;
Drop table if exists Equipment;
Drop table if exists Attendant;
Drop table if exists Pilot;
Drop table if exists Crew;
Drop table if exists Administrator;
Drop table if exists Employee;
Drop table if exists Changelog;

CREATE TABLE Employee(
    employee_ID int NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(20),
    last_name VARCHAR(20),
    email_address VARCHAR(340),
    username VARCHAR(50),
    password VARCHAR(100),
    role varchar(15),
    PRIMARY KEY (employee_ID)
);

CREATE TABLE Administrator(
    employee_ID int NOT NULL,
    PRIMARY KEY (employee_ID),
    FOREIGN KEY (employee_ID) REFERENCES Employee (employee_ID) ON DELETE CASCADE
);

CREATE TABLE Crew(
    employee_ID int NOT NULL,
    crew_ID int NOT NULL UNIQUE,
    flight_number int NOT NULL,
    PRIMARY KEY (crew_ID)
);

CREATE TABLE Pilot(
    employee_ID int NOT NULL,
    certifications VARCHAR(100),
    rank VARCHAR(50),
    total_hours int,
    crew_ID int,
    PRIMARY KEY (employee_ID),
    FOREIGN KEY (employee_ID) REFERENCES Employee (employee_ID) ON DELETE CASCADE,
    FOREIGN KEY (crew_ID) REFERENCES Crew (crew_ID)
);

CREATE TABLE Attendant(
    employee_ID int NOT NULL,
    rank VARCHAR(50),
    crew_ID int,
    PRIMARY KEY (employee_ID),
    FOREIGN KEY (employee_ID) REFERENCES Employee (employee_ID) ON DELETE CASCADE,
    FOREIGN KEY (crew_ID) REFERENCES Crew (crew_ID)
);

CREATE TABLE Equipment(
    registration_ID int NOT NULL,
    capacity int,
    num_of_attendants int,
    num_of_pilots int,
    type VARCHAR(50),
    flight_number int NOT NULL,
    PRIMARY KEY(registration_ID)
);

CREATE TABLE Flights(
    flight_number int NOT NULL,
    departure_city VARCHAR(50),
    arrival_city VARCHAR(50),
    flight_date DATE,
    flight_time TIME,
    terminal int,
    crew_ID int NOT NULL,
    registration_ID int,
    PRIMARY KEY (flight_number),
    FOREIGN KEY (crew_ID) REFERENCES Crew (crew_ID),
    FOREIGN KEY (registration_ID) REFERENCES Equipment (registration_ID)
);

CREATE TABLE Reservation(
    reservation_ID int,
    price int,
    seat VARCHAR(5),
    flight_number int NOT NULL,
    customer_ID int NOT NULL,
    PRIMARY KEY (reservation_ID),
    FOREIGN KEY (flight_number) REFERENCES Flights (flight_number) ON DELETE CASCADE
);

CREATE TABLE Customer(
    customer_ID int NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    num_bags int,
    age int,
    reservation_ID int,
    PRIMARY KEY (customer_ID),
    UNIQUE (customer_ID),
    FOREIGN KEY (reservation_ID) REFERENCES Reservation (reservation_ID)
);

CREATE TABLE Changelog(
	log_ID int AUTO_INCREMENT PRIMARY KEY,
	employee_ID int,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
	ip_address VARCHAR(50),
	explanation VARCHAR(200),
    time_stamp VARCHAR(200)
);
