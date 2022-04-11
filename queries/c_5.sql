select GeneralTopics.gtid, s.stid, s.question_count, s.answer_count
from GeneralTopics left join (
	select SubjectTopics.gtid, SubjectTopics.stid, question_count, answer_count
	from SubjectTopics left join (
		select q.stid, question_count, answer_count
		from (
			select stid, count(*) as question_count
			from Questions
			group by stid
		) as q left join (
			select stid, count(*) as answer_count
			from Questions natural join Answers
			group by stid
		) as a 
		on q.stid = a.stid
	) as c
	on SubjectTopics.stid = c.stid
) as s
on GeneralTopics.gtid = s.gtid