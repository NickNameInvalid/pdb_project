select qid, title, q_body
from Questions
where stid = 14 and title like '%how to%'

union

select qid, title, q_body
from Questions
where stid = 14 and q_body like '%how to%'

union 

select Questions.qid, title, Questions.q_body
from Questions natural join Answers
where stid = 14 and Answers.a_body like '%how to%'