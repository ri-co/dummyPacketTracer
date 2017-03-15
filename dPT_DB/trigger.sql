
delimiter //

CREATE TRIGGER check_device 
BEFORE INSERT ON dummyPT_data.devices
FOR EACH ROW
BEGIN
IF ((NEW.dtype != 'HOST') && 
	(NEW.ipaddr IS NOT NULL || 
    NEW.netmask IS NOT NULL || 
    NEW.dgateway IS NOT NULL))
THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'The device is uncompatible with data inserted';
END IF;
END;//

delimiter ;

