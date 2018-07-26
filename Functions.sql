DELIMITER //

#1
DROP FUNCTION IF EXISTS autobio//
CREATE FUNCTION autobio(site VARCHAR(30),id INT)
	RETURNS VARCHAR(200)
BEGIN
	DECLARE ab VARCHAR(200) DEFAULT "";
	DECLARE a INT DEFAULT 0;
	SELECT checkAccount(id,site) INTO a;
	IF a = 1 THEN
	SELECT socialMedia.bio INTO ab FROM socialMedia,userAcc,users
		WHERE userAcc.accId=socialMedia.accId AND 
			userAcc.userId=users.userId AND
			socialMedia.site=site AND
			users.userId = id;
	ELSE SELECT bio INTO ab FROM users WHERE userId=id;
	END IF;
	RETURN ab;
END//

#2
DROP FUNCTION IF EXISTS fetchName//
CREATE FUNCTION fetchName(site VARCHAR(30),id INT)
	RETURNS VARCHAR(100)
BEGIN
	DECLARE name VARCHAR(100);
	SELECT socialMedia.firstName INTO name FROM socialMedia,userAcc WHERE socialMedia.accId=userAcc.accId AND socialMedia.site=site AND userAcc.userId=id;
	RETURN name;
END//

#3
DROP FUNCTION IF EXISTS fetchId//
CREATE FUNCTION fetchId(id INT, site VARCHAR(30))
	RETURNS INT
BEGIN
	DECLARE acId INT DEFAULT 0;
	SELECT socialMedia.accId into acId
		FROM users,userAcc,socialMedia
		WHERE users.userId=userAcc.userId AND userAcc.accId=socialMedia.accId AND
			users.userId=id AND socialMedia.site=site;
	RETURN acId;
END//

#4
DROP FUNCTION IF EXISTS checkAccount//
CREATE FUNCTION checkAccount(id INT, site VARCHAR(30))
	RETURNS INT
BEGIN
	DECLARE flag INT;
	DECLARE temp INT DEFAULT 0;
	SET temp=fetchId(id,site);
	IF temp = 0 THEN SET flag=0;	
	ELSE SET flag=1;
	END IF;
	RETURN flag;
END//

DELIMITER ;
