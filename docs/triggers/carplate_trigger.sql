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

CREATE OR REPLACE FUNCTION isValidCarPlate ()
	RETURNS TRIGGER AS $$
	BEGIN
		IF checkFirstLetter(new.plate_number, 'S') = FALSE THEN
			RETURN NULL;
		END IF;
		IF validChecksumLetter(checksum(new.plate_number)+1, 'AZYXUTSRPMLKJHGEDCB', RIGHT(new.plate_number, 1)) THEN
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
