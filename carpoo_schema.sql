CREATE TABLE car (
	plate_number VARCHAR(8) PRIMARY KEY,
	model VARCHAR(16) NOT NULL,
	color VARCHAR(16) NOT NULL
);

CREATE TABLE app_user (
	phone_number CHAR(8) UNIQUE NOT NULL,
	email VARCHAR(32) PRIMARY KEY,
	name VARCHAR(32) NOT NULL,
	gender CHAR(1) NOT NULL CONSTRAINT gender CHECK (gender = 'M' OR gender = 'F'),
	dob DATE NOT NULL,
	password VARCHAR(64) NOT NULL
);

CREATE TABLE drive (
	driver VARCHAR(32),
	car VARCHAR(8),
	PRIMARY KEY (driver, car),
	FOREIGN KEY (driver) REFERENCES app_user(email),
	FOREIGN KEY (car) REFERENCES car(plate_number)
);

CREATE TABLE offer(
	date_of_ride DATE,
	time_of_ride TIME,
	driver VARCHAR(32),
	origin VARCHAR(64) NOT NULL,
	destination VARCHAR(64) NOT NULL,
	PRIMARY KEY (date_of_ride, time_of_ride, driver),
	FOREIGN KEY (driver) REFERENCES app_user(email)
);

CREATE TABLE bid (
	date_of_ride DATE, 
	time_of_ride TIME, 
	driver VARCHAR(32),
	passenger VARCHAR(32),
	price DECIMAL(19, 4) NOT NULL,
	status VARCHAR(16) NOT NULL 
	CONSTRAINT status CHECK (status = 'pending' OR status = 'successful' OR status = 'unsucessful'),
	PRIMARY KEY (date_of_ride, time_of_ride, driver, passenger),
	FOREIGN KEY (date_of_ride, time_of_ride, driver) REFERENCES offer(date_of_ride, time_of_ride, driver),
	FOREIGN KEY (passenger) REFERENCES app_user(email),
	CHECK(driver <> passenger)
);

	   								if(pg_num_rows($result) == 0) {
	   									echo "No current bids";
		   								echo '</tr>';
		   								echo '</thead';
	   								}
	   								else {
	   									while($row = pg_fetch_assoc($result)) {
	   										
	   									}
	   								}