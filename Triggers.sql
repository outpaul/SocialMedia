DELIMITER //

#1
DROP TRIGGER IF EXISTS before_delete_socialMedia//
CREATE TRIGGER before_delete_socialMedia 
	BEFORE DELETE ON socialMedia
	FOR EACH ROW
BEGIN
	DELETE FROM userAcc WHERE userAcc.accId=OLD.accId;
	DELETE FROM accPost WHERE accPost.accId=OLD.accId;
	DELETE FROM accMsg WHERE accMsg.accId=OLD.accId;
	DELETE FROM accBlock WHERE accBlock.accId=OLD.accId;
	DELETE FROM accBlock WHERE accBlock.blockId=OLD.accId;
	DELETE FROM accFol WHERE accFol.accId=OLD.accId;
	DELETE FROM accFol WHERE accFol.folId=OLD.accId;
END//

#2
DROP TRIGGER IF EXISTS before_delete_messages//
CREATE TRIGGER before_delete_messages BEFORE DELETE
	ON messages
	FOR EACH ROW
BEGIN
	DELETE FROM accMsg WHERE accMsg.msgId=OLD.msgId;
END//

#3
DROP TRIGGER IF EXISTS before_delete_users//
CREATE TRIGGER before_delete_users BEFORE DELETE
	ON users
	FOR EACH ROW
BEGIN
	
	DELETE FROM socialMedia WHERE accId IN (SELECT accId FROM accids);
	DELETE FROM location WHERE location.userId=OLD.userId;
	DELETE FROM work WHERE work.userId=OLD.userId;
	DELETE FROM eduQual WHERE eduQual.userId=OLD.userId;
	DELETE FROM search WHERE search.userId=OLD.userId;
	DELETE FROM interests WHERE interests.userId=OLD.userId;
END//

#4
DROP TRIGGER IF EXISTS after_delete_accPost//
CREATE TRIGGER after_delete_accPost
	AFTER DELETE ON accPost
	FOR EACH ROW
BEGIN
	DELETE FROM posts WHERE postId=OLD.postId;
END//

#5
DROP TRIGGER IF EXISTS after_delete_accMsg//
CREATE TRIGGER after_delete_accMsg
	AFTER DELETE ON accMsg
	FOR EACH ROW
BEGIN
	DELETE FROM messages WHERE msgId=OLD.msgId;
END//

#6
DROP TRIGGER IF EXISTS after_insert_accFol//
CREATE TRIGGER after_insert_accFol
	AFTER INSERT ON accFol
	FOR EACH ROW
BEGIN
	DECLARE f INT;
	SELECT userId INTO f FROM userAcc WHERE userAcc.accId=NEW.accId; 
	CALL folinterest(f);	
END//


DELIMITER ;
