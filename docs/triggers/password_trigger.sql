CREATE OR REPLACE FUNCTION passwordTooShort()
	RETURNS TRIGGER AS $$
	BEGIN
		raise EXCEPTION 'Password must have at least 8 characters!';
		return null;
	END;
	$$ LANGUAGE plpgsql;

create trigger passwordTooShort
	before insert or UPDATE
	on app_user
	for each ROW
	when (char_length(new.password) < 8)
	EXECUTE PROCEDURE passwordTooShort();