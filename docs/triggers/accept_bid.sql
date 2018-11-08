CREATE OR REPLACE FUNCTION reject_other_bids()
RETURNS TRIGGER AS $$
BEGIN
	UPDATE bid SET status = 'unsuccessful' 
	WHERE date_of_ride = OLD.date_of_ride
	AND time_of_ride = OLD.time_of_ride
	AND driver = OLD.driver 
	AND passenger <> OLD.passenger
	AND status = 'pending';
	RETURN NEW;
END; $$
LANGUAGE PLPGSQL;
	
CREATE TRIGGER accept_bid
AFTER UPDATE
ON bid
FOR EACH ROW
EXECUTE PROCEDURE reject_other_bids(); 
