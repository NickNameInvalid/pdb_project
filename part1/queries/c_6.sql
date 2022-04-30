-- select qid, title, q_body, sum(weight), q_timestamp from(
-- select qid, q_username as username, title, q_body, post_time as q_timestamp, 0.3 as weight
-- from Questions
-- where stid = 14 and title like '%e%'

-- union all

-- select qid, q_username as username, title, q_body, post_time as q_timestamp, 0.6 as weight
-- from Questions
-- where stid = 14 and q_body like '%e%'

-- union all

-- select qid, q_username as username, title, q_body, post_time as q_timestamp, 0.1 as weight
-- from Questions natural join Answers
-- where stid = 14 and a_body like '%e%'
-- ) as q group by qid, title, q_body, q_timestamp order by sum(weight) desc, q_timestamp desc

-- select qid, q_username as username, title, q_body, post_time from
-- (SELECT qid, q_username, title, q_body, post_time, match title against ('Work hard' in natural language mode) as score from questions
-- union
-- SELECT qid, q_username, title, q_body, post_time, 2 * match q_body against ('Work hard' in natural language mode) as score from questions
-- union
-- select qid, q_username, title, a_body, post_time, 0.5 * match a_body against ('Work hard' in natural language mode) as score from answers natural join questions) as q
-- group by qid, username, title, q_body, post_time having sum(score) > 0 order by sum(score) desc, post_time desc
