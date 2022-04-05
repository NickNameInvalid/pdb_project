CREATE SCHEMA `project`;

CREATE TABLE `project`.`Users` (
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  `phone` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `state` VARCHAR(45) NULL,
  `county` VARCHAR(45) NULL,
  `profile` VARCHAR(100) NULL,
  `karma_points` INT NOT NULL,
  PRIMARY KEY (`username`));
  
insert into project.Users (username, email, password, firstname, lastname, phone, city, state, county, profile, karma_points)
values ('name1', 'user1@mail.com', '42aff45bcfef506acda841c4c751a5e82376dc5e6b81d317aeafc4853eb4b768', 'f1', 'l1', '1112223333', 
		'New York', 'NY', 'USA', 'profile1', 0);
        
insert into project.Users (username, email, password, firstname, lastname, phone, city, state, county, profile, karma_points)
values ('name2', 'user2@mail.com', '956908ff8c5483d42acc0d332b89b86cf919f387eae8862b46fccc6594713bfb', 'f2', 'l2', '2223334444', 
		'Boston', 'MA', 'USA', 'profile2', 10);
        
insert into project.Users (username, email, password, firstname, lastname, phone, city, state, county, profile, karma_points)
values ('name3', 'user3@mail.com', '42aff45bcfef506acda841c4c751a5e82376dc5e6b81d317aeafc4853eb4b768', 'f3', 'l3', '3334445555', 
		'Los Angles', 'CA', 'USA', 'profile3', 100);

CREATE TABLE `project`.`Topics` (
  `tid` INT NOT NULL AUTO_INCREMENT,
  `tname` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`tid`));
  
insert into project.Topics (tname)
values ('baseball');

insert into project.Topics (tname)
values ('basketball');

insert into project.Topics (tname)
values ('football');

insert into project.Topics (tname)
values ('tennis');

CREATE TABLE `project`.`Questions` (
  `qid` INT NOT NULL AUTO_INCREMENT,
  `q_username` VARCHAR(45) NOT NULL,
  `tid` INT NOT NULL,
  `title` VARCHAR(45) NOT NULL,
  `body` VARCHAR(100) NULL,
  `post_time` DATETIME NOT NULL,
  `q_states` VARCHAR(45) NOT NULL,
  `q_thumb_ups` INT NOT NULL,
  `q_thumb_downs` INT NOT NULL,
  `best_answer` INT NULL, 
  PRIMARY KEY (`qid`),
  INDEX `q_username_idx` (`q_username` ASC) VISIBLE,
  INDEX `tid_idx` (`tid` ASC) VISIBLE,
  CONSTRAINT `q_username`
    FOREIGN KEY (`q_username`)
    REFERENCES `project`.`Users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `tid`
    FOREIGN KEY (`tid`)
    REFERENCES `project`.`Topics` (`tid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
    
insert into project.Questions (q_username, tid, title, body, post_time, q_states, q_thumb_ups, q_thumb_downs, best_answer)
values ('name1', 1, 'How to play baseball', 'as title', '2020-01-01 00:00:00', 'resolved', 100, 4, 2);

insert into project.Questions (q_username, tid, title, body, post_time, q_states, q_thumb_ups, q_thumb_downs, best_answer)
values ('name1', 2, 'How to play basketball', 'as title', '2020-01-02 00:00:00', 'resolved', 47, 1, 1);

insert into project.Questions (q_username, tid, title, body, post_time, q_states, q_thumb_ups, q_thumb_downs)
values ('name2', 3, 'football sucks', 'as title', '2020-01-03 00:00:00', 'not resolved', 3, 100);

insert into project.Questions (q_username, tid, title, body, post_time, q_states, q_thumb_ups, q_thumb_downs)
values ('name1', 1, 'How to play baseball well', 'i can play baseball now, but i am a newbee', '2021-01-01 00:00:00', 
        'not resolved', 0, 0);

insert into project.Questions (q_username, tid, title, body, post_time, q_states, q_thumb_ups, q_thumb_downs)
values ('name1', 2, 'How to play basketball well', 'i can play basketball now, but i am a newbee', '2021-01-01 00:00:00', 
        'not resolved', 0, 0);

CREATE TABLE `project`.`Answers` (
  `qid` INT NOT NULL,
  `a_index` INT NOT NULL,
  `answer_time` DATETIME NOT NULL,
  `a_username` VARCHAR(45) NOT NULL,
  `body` VARCHAR(100) NOT NULL,
  `a_thumb_ups` INT NOT NULL,
  `a_thumb_downs` INT NOT NULL,
  PRIMARY KEY (`qid`, `a_index`),
  INDEX `a_username_idx` (`a_username` ASC) VISIBLE,
  CONSTRAINT `qid`
    FOREIGN KEY (`qid`)
    REFERENCES `project`.`Questions` (`qid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `a_username`
    FOREIGN KEY (`a_username`)
    REFERENCES `project`.`Users` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

insert into project.Answers (qid, a_index, answer_time, a_username, body, a_thumb_ups, a_thumb_downs)
values(1, 1, '2020-01-01 10:00:00', 'name3', 'find a baseball coach', 10, 1);

insert into project.Answers (qid, a_index, answer_time, a_username, body, a_thumb_ups, a_thumb_downs)
values(1, 2, '2020-01-01 11:00:00', 'name2', 'watch videos online', 5, 1);

insert into project.Answers (qid, a_index, answer_time, a_username, body, a_thumb_ups, a_thumb_downs)
values(1, 3, '2020-01-01 12:00:00', 'name3', 'or ask you dad', 0, 3);

insert into project.Answers (qid, a_index, answer_time, a_username, body, a_thumb_ups, a_thumb_downs)
values(2, 1, '2020-01-02 10:00:00', 'name3', 'basketball itself will teach you', 10, 5);

insert into project.Answers (qid, a_index, answer_time, a_username, body, a_thumb_ups, a_thumb_downs)
values(2, 2, '2020-01-02 11:00:00', 'name2', 'i like basketball, but basketball donot like me', 0, 0);

insert into project.Answers (qid, a_index, answer_time, a_username, body, a_thumb_ups, a_thumb_downs)
values(3, 1, '2021-01-03 10:00:00', 'name2', 'it sucks, really', 1, 10);

insert into project.Answers (qid, a_index, answer_time, a_username, body, a_thumb_ups, a_thumb_downs)
values(4, 1, '2021-01-01 10:00:00', 'name3', 'again, find a baseball coach', 0, 0);

insert into project.Answers (qid, a_index, answer_time, a_username, body, a_thumb_ups, a_thumb_downs)
values(5, 1, '2021-01-01 10:00:00', 'name3', 'find good teammates and they will lead you', 0, 0);