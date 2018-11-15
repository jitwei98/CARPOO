﻿CREATE OR REPLACE FUNCTION delete_car()
RETURNS TRIGGER AS $$
DECLARE driver_count NUMERIC;
BEGIN
	SELECT COUNT(*) FROM drive WHERE car=OLD.car INTO driver_count;
	IF driver_count > 1 THEN
		RETURN NULL;
	ELSE
		DELETE FROM car WHERE plate_number=OLD.car;
		RETURN OLD;
	END IF;
END; $$
LANGUAGE PLPGSQL;
	
CREATE TRIGGER update_drive
AFTER UPDATE OR DELETE
ON drive
FOR EACH ROW
EXECUTE PROCEDURE delete_car();