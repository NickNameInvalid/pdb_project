select qid, title, q_body, sum(weight), timestamp from(
select qid, q_username as username, title, q_body, post_time as timestamp, 0.3 as weight
from Questions
where stid = 14 and title like '%e%'

union all

select qid, q_username as username, title, q_body, post_time as timestamp, 0.6 as weight
from Questions
where stid = 14 and q_body like '%e%'

union all

select qid, q_username as username, title, q_body, answer_time as timestamp, 0.1 as weight
from Questions natural join Answers
where stid = 14 and a_body like '%e%'
) as q group by qid, title, q_body, timestamp order by sum(weight) desc, timestamp desc