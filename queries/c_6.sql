select qid, title, body
from Questions
where stid = 1 and title like '%a%'

union

select qid, title, body
from Questions
where stid = 1 and body like '%a%'

union 

select Questions.qid, title, Questions.body
from Questions join Answers
on Questions.qid = Answers.qid
where stid = 1 and Answers.body like '%a%'