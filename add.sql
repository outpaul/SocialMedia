INSERT INTO users(firstName,lastName,username,password,gender,dob,bio,contact,email) VALUES ("Hannah","Witton","hannah","hannah","F",'1992-07-08',"Hi! Welcome to my world!","(+750) 431 789","hannahwitton@gmail.com");

CALL addAccount(1,"hannahwitton","hannah","Instagram");

CALL addAccount(1,"hannahwitty","hannah","Twitter");

CALL addAccount(1,"hannah","hannah","Facebook");

INSERT INTO posts(text,timestamp,location,likes,shares,comments) VALUES ("My first tweet!",NOW(),"London",132,0,3);
INSERT INTO accPost VALUES (2,1);
INSERT INTO posts(text,timestamp,media,location,likes,shares,comments) VALUES ("Checkout my Youtube channel!",NOW(),"placeImage.png","London",132,0,3);
INSERT INTO accPost VALUES (2,2);
INSERT INTO posts(text,timestamp,media,location,likes,shares,comments) VALUES ("Watching The Simpsons!",'2016-03-05 21:23:44',"pic.jpeg","London",432,9,18);
INSERT INTO accPost VALUES (2,3);

INSERT INTO users(firstName,lastName,username,password,gender,dob,bio,contact,email) VALUES ("Riyadh","K.","riyadh","riyadh","M",'1993-09-28',"It is me! Riyadh.","(+750) 625 789","riyadhk@gmail.com");

CALL addAccount(2,"riyadh","riyadh","Instagram");

CALL addAccount(2,"riyadhk","riyadh","Facebook");

UPDATE socialMedia SET lastName="Agency" WHERE accId=4;
UPDATE socialMedia SET type="business" WHERE accId=4;
INSERT INTO posts(text,timestamp,location,likes,shares,comments) VALUES ("My new company guys!",NOW(),"London",147,7,23);
INSERT INTO accPost VALUES (5,4);





INSERT INTO accFol VALUES (3,5,NOW());
INSERT INTO accFol VALUES (1,4,NOW());






insert into messages(participantId,content,site,timestamp,msgtag) values(5,"Hi","Facebook",now(),"sent");
insert into messages(participantId,content,site,timestamp,msgtag) values(5,"Hey","Facebook",now(),"received");
insert into messages(participantId,content,site,timestamp,msgtag) values(5,"Whats up?","Facebook",now(),"sent");
 insert into messages(participantId,content,site,timestamp,msgtag) values(5,"Working on my dbms project,you?","Facebook",now(),"received");
insert into messages(participantId,content,site,timestamp,msgtag) values(5,"Oh project! Sounds interesting,can i see it ? *_* ","Facebook",now(),"sent");
insert into messages(participantId,content,site,timestamp,msgtag) values(5,"Ya it is :D ","Facebook",now(),"received");
insert into messages(participantId,content,site,timestamp,msgtag) values(5,"N sure,feel free to drop by my house anytime :) ","Facebook",now(),"received");
insert into messages(participantId,content,site,timestamp,msgtag) values(5,"Oh yay! be there in 5 mins,ttyl!! byeeee !! ","Facebook",now(),"sent");

insert into accMsg(msgId,accId) values (1,3);,(2,3),(3,3),(4,3),(5,3),(6,3),(7,3),(8,3);


insert into messages(participantId,content,site,timestamp,msgtag) values(3,"Hi","Facebook", "2017-11-22 15:37:00","received");
insert into messages(participantId,content,site,timestamp,msgtag) values(3,"Hey","Facebook","2017-11-22 15:37:00","sent");
insert into messages(participantId,content,site,timestamp,msgtag) values(3,"Whats up?","Facebook","2017-11-22 15:37:00","received");
 insert into messages(participantId,content,site,timestamp,msgtag) values(3,"Working on my dbms project,you?","Facebook","2017-11-22 15:37:00","sent");
insert into messages(participantId,content,site,timestamp,msgtag) values(3,"Oh project! Sounds interesting,can i see it ? *_* ","Facebook","2017-11-22 15:37:00","received");
insert into messages(participantId,content,site,timestamp,msgtag) values(3,"Ya it is :D ","Facebook","2017-11-22 15:37:00","sent");
insert into messages(participantId,content,site,timestamp,msgtag) values(3,"N sure,feel free to drop by my house anytime :) ","Facebook","2017-11-22 15:37:00","sent");
insert into messages(participantId,content,site,timestamp,msgtag) values(3,"Oh yay! be there in 5 mins,ttyl!! byeeee !! ","Facebook","2017-11-22 15:37:00","received");

insert into accMsg(msgId,accId) values (9,5);,(10,5),(11,5),(12,5),(13,5),(14,5),(15,5),(16,5);






