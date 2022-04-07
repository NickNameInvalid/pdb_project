use project;

insert into Users (username, email, password, firstname, lastname, phone, city, state, country, profile, karma_points)
values ('user1', 'user1@mail.com', '42aff45bcfef506acda841c4c751a5e82376dc5e6b81d317aeafc4853eb4b768', 'f1', 'l1', '1112223333', 'New York', 'NY', 'USA', 'profile1', 0);
        
insert into Users (username, email, password, firstname, lastname, phone, city, state, country, profile, karma_points)
values ('user2', 'user2@mail.com', '956908ff8c5483d42acc0d332b89b86cf919f387eae8862b46fccc6594713bfb', 'f2', 'l2', '2223334444', 'Boston', 'MA', 'USA', 'profile2', 0);
        
insert into Users (username, email, password, firstname, lastname, phone, city, state, country, profile, karma_points)
values ('user3', 'user3@mail.com', '42aff45bcfef506acda841c4c751a5e82376dc5e6b81d317aeafc4853eb4b768', 'f3', 'l3', '3334445555', 'Los Angles', 'CA', 'USA', 'profile3', 0);
        
insert into Users (username, email, password, firstname, lastname, phone, city, state, country, profile, karma_points)
values ('user4', 'user4@mail.com', 'ed2047dfc9f23f56fe0c3af8996646b64a52b41d0afcba4a671831cf8d54dd69', 'f4', 'l4', '4445556666', 'New York', 'NY', 'USA', 'profile4', 0);
        
insert into Users (username, email, password, firstname, lastname, phone, city, state, country, profile, karma_points)
values ('user5', 'user5@mail.com', '64532608c19ae7a92a1cd9fb4f38dd29671955e0cc72925bef3b1e303a770b23', 'f5', 'l5', '5556667777', 'Boston', 'MA', 'USA', 'profile5', 0);
        
insert into Users (username, email, password, firstname, lastname, phone, city, state, country, profile, karma_points)
values ('user6', 'user6@mail.com', 'be4b60459be9466dcaa973314cec00a3b97c2e481ba51f613cecd3b7cafc170f', 'f6', 'l6', '6667778888', 'Los Angles', 'CA', 'USA', 'profile6', 0);

insert into Questions (q_username, stid, title, body, post_time, status, best_answer) 
values ('user1', 1, 'How to use select in mysql', 'As title stated, how to use it? I am a rookie of DB sytem.', '2021-09-01 15:21:02', 'unsolved', NULL);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user1', 2, 'Good image datasets', 'Can anyone recommend some good datasets for my model?', '2020-01-03 00:05:03', 'resolved', 1);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user2', 3, 'Some BERT familiy members', 'New starter for NLP, heard BERT is awesome, introduce it for me pls!', '2020-08-02 13:05:03', 'resolved', 2);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user2', 4, 'What is a blackhole?', 'As title stated', '2021-02-02 14:02:08', 'resolved', NULL);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user2', 5, 'Can anyone explain what is superconductivity?', 'I am interested in this topic hence I wonder can anyone answer my question?', '2021-03-02 12:02:08', 'resolved', 1);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user1', 6, 'Some materials with nanoscience?', 'Can anyone take some examples for me with materials with nanoscience techniques?', '2019-02-01 19:02:02', 'resolved', NULL);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user3', 7, 'solve x + 1 = 2', 'Please solve the algebra problem for me!', '2021-11-03 05:01:25', 'resolved', 1);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user3', 8, 'sufficient condition', 'What is sufficient condition?', '2022-01-04 02:01:26', 'resolved', NULL);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user3', 9, 'Seven Bridges of Konigsberg', 'What is this?', '2022-01-05 04:02:26', 'unsolved', NULL);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user4', 10, 'Universal Declaration of Human Rights', 'When was it published?', '2022-03-15 04:06:40', 'resolved', 1);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user4', 11, 'suicide', 'Some examples for Assisted suicide?', '2021-03-15 17:16:20', 'resolved', 1);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user4', 12, 'I am terrified', 'I stole some money, will I be sentenced to death penalty?', '2020-01-15 12:16:21', 'unsolved', NULL);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user5', 13, 'great composer', 'I am preparing for my music exam, could you please give me the names of some great composers?', '2020-11-15 12:13:20', 'resolved', 1);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user5', 14, 'how to become good song writter', 'As title stated.', '2020-01-17 12:13:20', 'resolved', 1);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user6', 15, 'movie with great performance', 'I am looking for some movies best in performance', '2019-12-25 19:11:34', 'unsolved', NULL);

insert into Questions (q_username, gtid, stid, title, body, post_time, status, best_answer)
values ('user6', 16, 'Good film music', 'Could you please provide me with some classic music from films', '2022-04-03 12:14:24', 'resolved', NULL);


insert into GeneralTopics (gtname) values ('Computer Science');
insert into GeneralTopics (gtname) values ('Physics');
insert into GeneralTopics (gtname) values ('Math');
insert into GeneralTopics (gtname) values ('Law');
insert into GeneralTopics (gtname) values ('Music');

insert into SubjectTopics (stname, gtid) values ('Database Systems', 1); -- 1
insert into SubjectTopics (stname, gtid) values ('Computer Vision', 1); -- 2
insert into SubjectTopics (stname, gtid) values ('Natural Language Processing', 1); -- 3
insert into SubjectTopics (stname, gtid) values ('Astrophysics', 2); -- 4
insert into SubjectTopics (stname, gtid) values ('Fusion and Plasma Physics', 2); -- 5
insert into SubjectTopics (stname, gtid) values ('Nanoscience and Nanotechnology', 2); -- 6
insert into SubjectTopics (stname, gtid) values ('Algebra', 3); -- 7
insert into SubjectTopics (stname, gtid) values ('Combinatorics', 3); -- 8
insert into SubjectTopics (stname, gtid) values ('Topology and Differential Geometry', 3); -- 9
insert into SubjectTopics (stname, gtid) values ('Civil rights', 4); -- 10
insert into SubjectTopics (stname, gtid) values ('Assisted suicide', 4); -- 11
insert into SubjectTopics (stname, gtid) values ('Capital punishment', 4); -- 12
insert into SubjectTopics (stname, gtid) values ('Composition', 5); -- 13
insert into SubjectTopics (stname, gtid) values ('Songwriting', 5); -- 14
insert into SubjectTopics (stname, gtid) values ('Performance', 5); -- 15
insert into SubjectTopics (stname, gtid) values ('Film Scoring', 5); -- 16



