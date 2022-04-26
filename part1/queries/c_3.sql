DELIMITER //
create procedure Get_Karma()
begin
	declare advance_thres INT;
	declare expert_thres INT;
    select statuskarma into advance_thres from status where statusname = 'advanced';
	select statuskarma into expert_thres from status where statusname = 'expert';
	select username, karma_points,
	case
		when karma_points < advance_thres then 'basic'
		when karma_points < expert_thres then 'advanced'
		else 'expert'
	end as status
from (select username, sum(score) as karma_points from (
	select users.username, 10 * count(*) as score from users left join answers on answers.a_username = users.username inner join likes on likes.aid = answers.aid where likes.like_status = 1 group by users.username
	union all
    select username, 20 * count(aid) as score from users left join answers on answers.a_username = users.username where best_answer = 1 group by username
    union all
    select username, 10 * count(aid) as score from users left join answers on answers.a_username = users.username group by username
) as s group by username) as l;
end //
call Get_Karma();
DROP PROCEDURE Get_Karma;

select username, karma_points,
case
  when karma_points < 50 then 'basic'
  when karma_points < 100 then 'advanced'
  else 'expert'
  end as status
from (select username, sum(score) as karma_points from (
	select users.username, 10 * count(*) as score from users left join answers on answers.a_username = users.username inner join likes on likes.aid = answers.aid where likes.like_status = 1 group by users.username
	union all
    select username, 20 * count(aid) as score from users left join answers on answers.a_username = users.username where best_answer = 1 group by username
    union all
    select username, 10 * count(aid) as score from users left join answers on answers.a_username = users.username group by username
) as s group by username) as l