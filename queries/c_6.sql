select qid, title, q_body from(
select qid, q_username as username, title, q_body, post_time as timestamp, 0.25 as weight
from Questions
where stid = 14 and title like '%e%'

union all

select qid, q_username as username, title, q_body, post_time as timestamp, 0.55 as weight
from Questions
where stid = 14 and q_body like '%e%'

union all

select qid, q_username as username, title, q_body, answer_time as timestamp, 0.2 as weight
from Questions natural join Answers
where stid = 14 and a_body like '%e%'
) as q group by qid, title, q_body, timestamp order by sum(weight), timestamp desc