select GeneralTopics.gtid, s.stid, s.q_c, s.a_c
from GeneralTopics left join (
	select SubjectTopics.gtid as gtid, SubjectTopics.stid as stid, q_c, a_c
	from SubjectTopics left join (
		select q.stid as stid, q_c, a_c
		from (
			select stid, count(*) as q_c
			from Questions
			group by stid
		) as q left join (
			select stid, count(*) as a_c
			from Questions join Answers
			on Questions.qid = Answers.qid
			group by stid
		) as a 
		on q.stid = a.stid
	) as c
	on SubjectTopics.stid = c.stid
) as s
on GeneralTopics.gtid = s.gtid