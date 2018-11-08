CREATE OR REPLACE FUNCTION valid_car_plate()
RETURNS TRIGGER AS $$
DECLARE car_plate NUMERIC;
BEGIN
    IF substring(NEW.plate_number, 0, 3) NOT LIKE '[a-zA-Z][a-zA-Z][a-zA-Z]' THEN
        RETURN NULL;
	END IF;
    IF substring(NEW.plate_number, )
END; $$
LANGUAGE PLPGSQL;
	
CREATE TRIGGER check_car_plate
BEFORE INSERT OR UPDATE
ON car
FOR EACH ROW
EXECUTE PROCEDURE valid_car_plate(); 