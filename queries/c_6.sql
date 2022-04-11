select qid, title, q_body from(
select qid, q_username as username, title, q_body, post_time as timestamp
from Questions
where stid = 14 and title like '%how to%'

union

select qid, q_username as username, title, q_body, post_time as timestamp
from Questions
where stid = 14 and q_body like '%how to%'

union 

select qid, q_username as username, title, q_body, answer_time as timestamp
from Questions natural join Answers
where stid = 14 and a_body like '%how to%'
) as q natural join users order by timestamp, karma_points desc