use project;
drop trigger if exists Likes_after_insert;
drop trigger if exists Likes_after_update;
drop trigger if exists Answers_after_update;
drop trigger if exists Answers_after_insert;
drop trigger if exists User_after_update;
drop trigger if exists User_after_insert;

delimiter //

-- for Likes
create trigger Likes_after_insert after insert on Likes for each row
begin
	update Answers
    set thumb_ups = thumb_ups + 1
    where aid = new.aid;
end;//

create trigger Likes_after_update after update on Likes for each row
begin
	if new.like_status <> old.like_status then
		if new.like_status = 0 and old.like_status = 1 then 
			update Answers
			set thumb_ups = thumb_ups - 1
			where new.aid = Answers.aid;
		elseif new.like_status = 1 and old.like_status = 0 then
			update Answers
			set thumb_ups = thumb_ups + 1
			where new.aid = Answers.aid;
		end if;
	end if;
end;//

-- for Answers
create trigger Answers_after_insert after insert on Answers for each row
begin
	update Users
    set karma_points = karma_points + 10
    where Users.username = new.a_username;
end;//

create trigger Answers_after_update after update on Answers for each row
begin
	if new.best_answer <> old.best_answer then
		if new.best_answer = 1 and old.best_answer = 0 then
			update Users
			set karma_points = karma_points + 20
			where Users.username = new.a_username;
		elseif new.best_answer = 0 and old.best_answer = 1 then
			update Users
			set karma_points = karma_points - 20
			where Users.username = new.a_username;
		end if;
		
		if new.thumb_ups - old.thumb_ups <> 0 then
			update Users
			set karma_points = karma_points + 10 * (new.thumb_ups - old.thumb_ups)
			where Users.username = new.a_username;
		end if;
	end if;
end;//

-- for Users
create trigger User_after_insert after insert on Users for each row
begin
	insert into UserStatus(username) values(new.username);
end;//

create trigger User_after_update after update on Users for each row
begin
	declare advance_thres INT;
	declare expert_thres INT;
	declare basic_status INT;
	declare acvanced_status INT;
	declare expert_status INT;
    if new.karma_points <> old.karma_points then
		select statusid into basic_status from status where statusname = 'basic';
		select statuskarma, statusid into advance_thres, acvanced_status from status where statusname = 'advanced';
		select statuskarma, statusid into expert_thres, expert_status from status where statusname = 'expert';
		if new.karma_points >= expert_thres and old.karma_points < expert_thres then 
			update UserStatus
			set statusid = expert_status
			where UserStatus.username = new.username;
		elseif new.karma_points >= advance_thres and (old.karma_points < advance_thres or old.karma_points >= expert_thres) then
			update UserStatus
			set statusid = acvanced_status
			where UserStatus.username = new.username;
		elseif new.karma_points < advance_thres and old.karma_points >= advance_thres then
			update UserStatus
			set statusid = basic_status
			where UserStatus.username = new.username;
		end if;
	end if;
end;//