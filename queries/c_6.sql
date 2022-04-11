select qid, title, q_body
from Questions
where title like '%how to%'

union

select qid, title, q_body
from Questions
where q_body like '%how to%'

union 

select Questions.qid, title, Questions.q_body
from Questions natural join Answers
where Answers.a_body like '%how to%'