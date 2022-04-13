use project;
drop trigger if exists Likes_after_insert;
drop trigger if exists Likes_after_update;
drop trigger if exists Answers_after_update;
drop trigger if exists Answers_after_insert;
drop trigger if exists User_after_update;

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
	if new.like_status = 0 and old.like_status = 1 then 
		update Answers
		set thumb_ups = thumb_ups - 1
		where new.aid = Answers.aid;
    elseif new.like_status = 1 and old.like_status = 0 then
		update Answers
        set thumb_ups = thumb_ups + 1
        where new.aid = Answers.aid;
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
	if new.best_answer = 1 and old.best_answer = 0 then
		update Users
        set karma_points = karma_points + 20
        where Users.username = new.a_username;
		if exists(select * from Answers where best_answer = 1 and qid = new.qid and aid <> new.aid) then
			update Answers
			set best_answer = 0
            where Answers.qid = new.qid and Answers.aid <> new.aid;
		end if;
	elseif new.best_answer = 0 and old.best_answer = 1 then
		update Users
        set karma_points = karma_points - 20
        where User.username = new.a_username;
	end if;
    
    if new.thumb_ups - old.thumb_ups <> 0 then
		update Users
        set karma_points = karma_points + 10 * (new.thumb_ups - old.thumb_ups)
        where Users.username = new.a_username;
	end if;
end;//

-- for Users
create trigger User_after_update after update on Users for each row
begin
	declare advance_thres INT;
	declare expert_thres INT;
    declare basic_status INT;
	declare acvanced_status INT;
	declare expert_status INT;
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
end;//