CREATE OR REPLACE FUNCTION charIndex (text VARCHAR(8),val INTEGER)
RETURNS CHAR AS 
'BEGIN
	RETURN SUBSTRING(text,val, 1);
END;'
LANGUAGE PLPGSQL;

CREATE OR REPLACE FUNCTION checkFirstLetter(text VARCHAR(8), flag CHAR(1))
RETURNS BOOL AS 
'BEGIN
	IF LEFT(text,1) = flag THEN
		RETURN TRUE;
	ELSE
		RETURN FALSE;
	END IF;
END;'
LANGUAGE PLPGSQL;


CREATE OR REPLACE FUNCTION checksum (text VARCHAR(8))
RETURNS INTEGER AS 
'BEGIN
	text := SUBSTRING(text, 2);
	RETURN MOD (
	       ((ASCII(charIndex(text,1))-64) * 9) + 
	       ((ASCII(charIndex(text,2))-64) * 4) + 
	       (charIndex(text,3)::INTEGER * 5) + 
	       (charIndex(text,4)::INTEGER * 4) + 
	       (charIndex(text,5)::INTEGER * 3) + 
	       (charIndex(text,6)::INTEGER * 2) , 19);
END;'
LANGUAGE PLPGSQL;

CREATE OR REPLACE FUNCTION validChecksumLetter (n INTEGER, checker CHAR(19), letter CHAR(1))
	RETURNS BOOL AS
	' BEGIN
		IF charIndex(checker,n) = letter THEN
			RETURN TRUE;
		ELSE
			RETURN FALSE;
		END IF;
	END;'
	LANGUAGE PLPGSQL;

CREATE OR REPLACE FUNCTION prepare_car_plate(plate VARCHAR(8), regex1 VARCHAR(20), regex2 VARCHAR(20), filler CHAR(5))
	RETURNS VARCHAR AS
	'DECLARE
		front VARCHAR := SUBSTRING(plate FROM regex1);
		back VARCHAR := SUBSTRING(plate FROM regex2);
	BEGIN
		IF CHAR_LENGTH(front) = 2 THEN 
			front := CONCAT(LEFT(filler, 1),front);
		ELSEIF CHAR_LENGTH(front) = 1 THEN
			front := CONCAT(LEFT(filler, 2), front);
		END IF;
		IF CHAR_LENGTH(back) = 4 THEN 
			back := CONCAT(RIGHT(filler, 1),back);
		ELSEIF CHAR_LENGTH(back) = 3 THEN 
			back := CONCAT(RIGHT(filler, 2),back);
		ELSEIF CHAR_LENGTH(back) = 2 THEN
			back := CONCAT(RIGHT(filler, 3), back);
		END IF;
		RETURN CONCAT(front,back);
	END;'
	LANGUAGE PLPGSQL;


CREATE OR REPLACE FUNCTION isValidCarPlate ()
	RETURNS TRIGGER AS $$
	DECLARE plate VARCHAR;
	BEGIN
		plate := prepare_car_plate(new.plate_number, '^.*?(?=[0-9]|$)', '[0-9].*$', 'S@000');
		IF checkFirstLetter(plate, 'S') = FALSE THEN
			RETURN NULL;
		END IF;
		IF validChecksumLetter(checksum(plate)+1, 'AZYXUTSRPMLKJHGEDCB', RIGHT(plate, 1)) THEN
			RETURN NEW;
		ELSE
			RAISE EXCEPTION 'Invalid carplate!';
			RETURN NULL;
		END IF;
	END;
	$$ LANGUAGE PLPGSQL;

CREATE TRIGGER check_car_plate
BEFORE INSERT OR UPDATE
ON car
FOR EACH ROW
EXECUTE PROCEDURE isValidCarPlate(); 
