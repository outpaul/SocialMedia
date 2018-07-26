DELIMITER //

#1
DROP PROCEDURE IF EXISTS addAccount//
CREATE PROCEDURE addAccount(IN usid INT,IN handle VARCHAR(100),IN password VARCHAR(32),IN site VARCHAR(30))
BEGIN
	DECLARE fname VARCHAR(100);
	DECLARE lname VARCHAR(200);
	DECLARE id INT;
	SELECT firstName,lastName INTO fname,lname FROM users WHERE users.userId=usid;
	INSERT INTO socialMedia(site,username,password) VALUES (site,handle,password);
	SELECT accId INTO id FROM socialMedia WHERE socialMedia.username=handle and socialMedia.site=site;	
	UPDATE socialMedia SET firstName=fname,lastName=lname WHERE accId=id;
	INSERT INTO userAcc VALUES (usid,id);
END//

#2
DROP PROCEDURE IF EXISTS deleteAccount//
CREATE PROCEDURE deleteAccount(IN id INT,IN site VARCHAR(30))
BEGIN
	DELETE FROM socialMedia WHERE socialMedia.accId=fetchId(id,site);
END//

#3
DROP PROCEDURE IF EXISTS deleteUser//
CREATE PROCEDURE deleteUser(IN id INT)
BEGIN
	DROP TABLE IF EXISTS accids;
	CREATE TABLE accids(accId INT);
	INSERT INTO accids(accId) SELECT accId FROM userAcc WHERE userId=id;
	DELETE FROM users WHERE users.userId=id;
	DROP TABLE accids;
END//

#4
DROP PROCEDURE IF EXISTS deletePost//
CREATE PROCEDURE deletePost(IN postId INT)
BEGIN
	DELETE FROM accPost WHERE accPost.postId=postId;
END//

#5
DROP PROCEDURE IF EXISTS deleteMsg//
CREATE PROCEDURE deleteMsg(IN msgId INT)
BEGIN
	DELETE FROM accMsg WHERE accMsg.msgId=msgId;
END//

#6
DROP PROCEDURE IF EXISTS interest//
CREATE PROCEDURE interest(IN id INT,IN inid INT)
BEGIN
	DECLARE f INT DEFAULT 0;
	DECLARE acid INT;
	DECLARE fname VARCHAR(100);
	DECLARE lname VARCHAR(200);
	DECLARE type VARCHAR(10);
	DECLARE myCursor CURSOR FOR
		SELECT userAcc.accId,socialMedia.firstName,socialMedia.lastName,socialMedia.type FROM socialMedia,userAcc,users WHERE userAcc.userId=users.userId AND socialMedia.accId=userAcc.accId AND users.userId=inid;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET f=1;

	OPEN myCursor;
	label:LOOP
		FETCH myCursor INTO acid,fname,lname,type;
		IF f=1 THEN
			LEAVE label;
		END IF;
		IF type="business" THEN
			INSERT INTO interests VALUES (id,fname);
			INSERT INTO interests VALUES (id,lname);
		END IF;
	END LOOP label;
	CLOSE myCursor;
END//

#7
DROP PROCEDURE IF EXISTS location//
CREATE PROCEDURE location(IN id INT,IN tag VARCHAR(20),IN city VARCHAR(20),IN state VARCHAR(40),IN country VARCHAR(50))
BEGIN
	IF tag="current" THEN
	UPDATE location SET tag="lived" WHERE tag="current";
	END IF;
	INSERT INTO location VALUES(id,tag,city,state,country);
END//

#8
DROP PROCEDURE IF EXISTS folinterest//
CREATE PROCEDURE folinterest(IN id INT)
BEGIN
	DECLARE f INT DEFAULT 0;
	DECLARE acid INT;
	DECLARE typ VARCHAR(10);
	DECLARE myCursor CURSOR FOR
		SELECT accFol.folId FROM userAcc,users,accFol WHERE userAcc.userId=users.userId AND accFol.accId=userAcc.accId AND users.userId=id;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET f=1;

	OPEN myCursor;
	label:LOOP
		FETCH myCursor INTO acid;
		IF f=1 THEN
			LEAVE label;
		END IF;
		
		SELECT socialMedia.type INTO typ FROM socialMedia WHERE socialMedia.accId=acid;
		IF typ="business" THEN
			INSERT INTO interests(userId,interests) SELECT id,socialMedia.firstName FROM socialMedia WHERE socialMedia.accId=acid;
			INSERT INTO interests(userId,interests) SELECT id,socialMedia.lastName FROM socialMedia WHERE socialMedia.accId=acid;
		END IF;
		
	END LOOP label;
	CLOSE myCursor;
END//

DELIMITER ;
