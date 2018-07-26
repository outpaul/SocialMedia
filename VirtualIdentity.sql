DROP DATABASE IF EXISTS VirtualIdentity;

CREATE DATABASE VirtualIdentity;

USE VirtualIdentity;

CREATE TABLE users(
	userId int NOT NULL UNIQUE AUTO_INCREMENT,
	firstName varchar(60) NOT NULL,
	lastName varchar(100),
	username varchar(200) NOT NULL UNIQUE,
	password varchar(32) NOT NULL,
	gender ENUM("M","F") NOT NULL,
	dob date,
	image VARCHAR(100) DEFAULT "placeHolder.jpg",
	bio text,
	contact VARCHAR(20),
	email VARCHAR(200),
	lastonline datetime,
	PRIMARY KEY (userId));

CREATE TABLE interests(
	userId int NOT NULL,
	interests varchar(40),
	FOREIGN KEY (userId) REFERENCES users(userId),
	PRIMARY KEY (userId,interests));

CREATE TABLE eduQual(
	userId int NOT NULL,
	degree varchar(30) NOT NULL,
	field varchar(70) NOT NULL,
	institute varchar(200) NOT NULL,
	FOREIGN KEY (userId) REFERENCES users(userId));

CREATE TABLE work(
	userId INT NOT NULL,
	duration VARCHAR(50),
	post VARCHAR(100),
	company VARCHAR(100),
	FOREIGN KEY (userId) REFERENCES users(userId));

CREATE TABLE location(
	userId int NOT NULL,
	tag ENUM("lived","current"),
	city varchar(20),
	state varchar(40),
	country varchar(50),
	FOREIGN KEY (userId) REFERENCES users(userId));

CREATE TABLE socialMedia(
	accId int NOT NULL UNIQUE AUTO_INCREMENT,
	site varchar(30) NOT NULL,
	firstName varchar(100),
	lastName varchar(200),
	username varchar(200) NOT NULL,
	password varchar(20) NOT NULL,
	mode enum("private","public") DEFAULT "public",
	type enum("personal","business") DEFAULT "personal",
	media VARCHAR(200) DEFAULT "placeImage.png",
	bio text,
	CONSTRAINT acc_unique UNIQUE (site,username),
	PRIMARY KEY (accId));

CREATE TABLE userAcc(
	userId int NOT NULL,
	accId int NOT NULL UNIQUE,
	FOREIGN KEY (accId) REFERENCES socialMedia(accId),
	FOREIGN KEY (userId) REFERENCES users(userId),
	PRIMARY KEY (accId));

CREATE TABLE posts(
	postId int NOT NULL UNIQUE AUTO_INCREMENT,
	text varchar(200),
	media VARCHAR(200),
	timestamp timestamp NOT NULL,
	location varchar(100),
	likes int NOT NULL,
	shares int NOT NULL,
	comments int NOT NULL,
	PRIMARY KEY(postId));

CREATE TABLE accPost(
	accId int NOT NULL,
	postId int NOT NULL UNIQUE,
	FOREIGN KEY (accId) REFERENCES socialMedia(accId),
	FOREIGN KEY (postId) REFERENCES posts(postId),
	PRIMARY KEY (postId));

CREATE TABLE messages(
	msgId int NOT NULL UNIQUE AUTO_INCREMENT,
	participantId int NOT NULL,
	content text NOT NULL,
	site VARCHAR(30) NOT NULL,
	timestamp datetime NOT NULL,
	msgTag ENUM("sent","received") NOT NULL,
	PRIMARY KEY (msgId));

CREATE TABLE accMsg(
	msgId int NOT NULL UNIQUE,	
	accId int NOT NULL,
	FOREIGN KEY (accId) REFERENCES socialMedia(accId),
	FOREIGN KEY (msgId) REFERENCES messages(msgId),
	PRIMARY KEY (msgId));

CREATE TABLE accBlock(
	accId int NOT NULL,
	blockId int NOT NULL,
	timestamp datetime,
	FOREIGN KEY (accId) REFERENCES socialMedia(accId),
	FOREIGN KEY (blockId) REFERENCES socialMedia(accId),
	PRIMARY KEY (accId,blockId));

CREATE TABLE accFol(
	accId int NOT NULL,
	folId int NOT NULL,
	timestamp datetime,
	FOREIGN KEY (folId) REFERENCES socialMedia(accId),
	FOREIGN KEY (accId) REFERENCES socialMedia(accId),
	PRIMARY KEY (accId,folId));

CREATE TABLE search(
	userId int NOT NULL UNIQUE AUTO_INCREMENT,
	content VARCHAR(500) NOT NULL,
	timestamp datetime DEFAULT NOW(),
	PRIMARY KEY (userId,content,timestamp));

