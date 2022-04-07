use project;

insert into Users (username, email, password, firstname, lastname, phone, city, state, county, profile, karma_points)
values ('user1', 'user1@mail.com', '42aff45bcfef506acda841c4c751a5e82376dc5e6b81d317aeafc4853eb4b768', 'f1', 'l1', '1112223333', 
		'New York', 'NY', 'USA', 'profile1', 0);
        
insert into Users (username, email, password, firstname, lastname, phone, city, state, county, profile, karma_points)
values ('user2', 'user2@mail.com', '956908ff8c5483d42acc0d332b89b86cf919f387eae8862b46fccc6594713bfb', 'f2', 'l2', '2223334444', 
		'Boston', 'MA', 'USA', 'profile2', 0);
        
insert into Users (username, email, password, firstname, lastname, phone, city, state, county, profile, karma_points)
values ('user3', 'user3@mail.com', '42aff45bcfef506acda841c4c751a5e82376dc5e6b81d317aeafc4853eb4b768', 'f3', 'l3', '3334445555', 
		'Los Angles', 'CA', 'USA', 'profile3', 0);
        
insert into Users (username, email, password, firstname, lastname, phone, city, state, county, profile, karma_points)
values ('user4', 'user4@mail.com', 'ed2047dfc9f23f56fe0c3af8996646b64a52b41d0afcba4a671831cf8d54dd69', 'f4', 'l4', '4445556666', 
		'New York', 'NY', 'USA', 'profile4', 0);
        
insert into Users (username, email, password, firstname, lastname, phone, city, state, county, profile, karma_points)
values ('user5', 'user5@mail.com', '64532608c19ae7a92a1cd9fb4f38dd29671955e0cc72925bef3b1e303a770b23', 'f5', 'l5', '5556667777', 
		'Boston', 'MA', 'USA', 'profile5', 0);
        
insert into Users (username, email, password, firstname, lastname, phone, city, state, county, profile, karma_points)
values ('user6', 'user6@mail.com', 'be4b60459be9466dcaa973314cec00a3b97c2e481ba51f613cecd3b7cafc170f', 'f6', 'l6', '6667778888', 
		'Los Angles', 'CA', 'USA', 'profile6', 0);
        

insert into GeneralTopics (gtname)
values ('Computer Science');

insert into GeneralTopics (gtname)
values ('Physics');

insert into GeneralTopics (gtname)
values ('Math');

insert into GeneralTopics (gtname)
values ('Law');

insert into GeneralTopics (gtname)
values ('Music');


insert into SubjectTopics (stname, gtid)
values ('Database Systems', 1);

insert into SubjectTopics (stname, gtid)
values ('Computer Vision', 1);

insert into SubjectTopics (stname, gtid)
values ('Natural Language Processing', 1);

insert into SubjectTopics (stname, gtid)
values ('Astrophysics', 2);

insert into SubjectTopics (stname, gtid)
values ('Fusion and Plasma Physics', 2);

insert into SubjectTopics (stname, gtid)
values ('Nanoscience and Nanotechnology', 2);

insert into SubjectTopics (stname, gtid)
values ('Algebra', 3);

insert into SubjectTopics (stname, gtid)
values ('Combinatorics', 3);

insert into SubjectTopics (stname, gtid)
values ('Topology and Differential Geometry', 3);

insert into SubjectTopics (stname, gtid)
values ('Civil rights', 4);

insert into SubjectTopics (stname, gtid)
values ('Assisted suicide', 4);

insert into SubjectTopics (stname, gtid)
values ('Capital punishmen', 4);

insert into SubjectTopics (stname, gtid)
values ('Composition', 5);

insert into SubjectTopics (stname, gtid)
values ('Songwriting', 5);

insert into SubjectTopics (stname, gtid)
values ('Performance', 5);

insert into SubjectTopics (stname, gtid)
values ('Film Scoring', 5);

