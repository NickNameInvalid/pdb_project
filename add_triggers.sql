use project;
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
	if new.karma_points >= 100 and old.karma_points < 100 then 
		update UserStatus
        set statusid = 3
        where UserStatus.username = new.username;
	elseif new.karma_points >= 50 and (old.karma_points < 50 or old.karma_points >= 100) then
		update UserStatus
        set statusid = 2
        where UserStatus.username = new.username;
	elseif new.karma_points < 50 and old.karma_points >= 50 then
		update UserStatus
        set statusid = 1
        where UserStatus.username = new.username;
	end if;
end;//