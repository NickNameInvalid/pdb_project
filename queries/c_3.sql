select username, sum(score) as karma_point from (
	select users.username, 10 * count(*) as score from users left join answers on answers.a_username = users.username inner join likes on likes.aid = answers.aid group by users.username
	union all
    select username, 20 * count(*) as score from users left join answers on answers.a_username = users.username where best_answer = 1 group by username
    union all
    select username, 10 * count(*) as score from users left join answers on answers.a_username = users.username group by username
) as s group by username
