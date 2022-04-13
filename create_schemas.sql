use project;

drop table if exists Likes CASCADE;
drop table if exists Answers CASCADE;
drop table if exists Questions CASCADE;
drop table if exists SubjectTopics CASCADE;
drop table if exists UserStatus CASCADE;
drop table if exists Status CASCADE;
drop table if exists Users CASCADE;
drop table if exists GeneralTopics CASCADE;

CREATE TABLE Status (
  statusid INT AUTO_INCREMENT,
  statusname VARCHAR(20) NOT NULL,
  statuskarma INT NOT NULL,
  PRIMARY KEY (statusid)
);

CREATE TABLE Users (
  username VARCHAR(45) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(128) NOT NULL,
  firstname VARCHAR(45) NULL,
  lastname VARCHAR(45) NULL,
  phone VARCHAR(10) NULL,
  city VARCHAR(60) NULL,
  state VARCHAR(2) NULL,
  country VARCHAR(60) NULL,
  profile VARCHAR(512) NULL,
  karma_points INT NOT NULL,
  PRIMARY KEY (username)
);

CREATE TABLE UserStatus (
  username VARCHAR(45) NOT NULL,
  statusid INT NOT NULL default 1,
  PRIMARY KEY (username),
  FOREIGN KEY (username) REFERENCES Users(username),
  FOREIGN KEY (statusid) REFERENCES Status(statusid)
);

CREATE TABLE GeneralTopics (
  gtid INT NOT NULL AUTO_INCREMENT,
  gtname VARCHAR(45) NOT NULL,
  PRIMARY KEY (gtid)
);

CREATE TABLE SubjectTopics (
  stid INT NOT NULL AUTO_INCREMENT,
  stname VARCHAR(50) NOT NULL,
  gtid INT NOT NULL,
  PRIMARY KEY (stid),
  FOREIGN KEY (gtid) REFERENCES GeneralTopics(gtid)
);

CREATE TABLE Questions (
  qid INT NOT NULL AUTO_INCREMENT,
  q_username VARCHAR(45) NOT NULL,
  stid INT NOT NULL,
  title VARCHAR(45) NOT NULL,
  q_body VARCHAR(512) NULL,
  post_time DATETIME NOT NULL,
  status VARCHAR(15) NOT NULL,
  PRIMARY KEY (qid),
  FOREIGN KEY (q_username) REFERENCES Users(username),
  FOREIGN KEY (stid) REFERENCES SubjectTopics(stid)
);

CREATE TABLE Answers (
  aid INT NOT NULL AUTO_INCREMENT,
  qid INT NOT NULL,
  answer_time DATETIME NOT NULL,
  a_username VARCHAR(45) NOT NULL,
  a_body VARCHAR(100) NOT NULL,
  thumb_ups INT NOT NULL,
  best_answer INT NOT NULL default 0,
  PRIMARY KEY (aid),
  FOREIGN KEY (qid) REFERENCES Questions(qid),
  FOREIGN KEY (a_username) REFERENCES Users (username)
);

CREATE TABLE Likes (
  username VARCHAR(45) NOT NULL,
  aid INT NOT NULL,
  like_status INT NOT NULL default 1,
  PRIMARY KEY (username, aid),
  FOREIGN KEY (username) REFERENCES Users (username),
  FOREIGN KEY (aid) REFERENCES Answers (aid)
);