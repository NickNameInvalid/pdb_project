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

-- SELECT qid, q_username, title, q_body, post_time, match q_body against ('I wonder anyone can' with query expansion) as score, 0.6 as weight 
-- from questions

-- select qid, title, q_body, sum(weight) as weights, post_time, sum(score) as scores from(
-- SELECT qid, q_username, title, q_body, post_time, match (q_body) against ('can' with query expansion) as score, 0.0 as weight, stid 
-- from questions natural join subjecttopics where stid = 5
-- union
-- SELECT qid, q_username, title, q_body, post_time, match (title) against ('can' with query expansion) as score, 0.0 as weight, stid 
-- from questions natural join subjecttopics where stid = 5
-- union
-- SELECT qid, q_username, title, q_body, post_time, 0.0 as score, 0.6 as weight, stid from questions 
-- natural join subjecttopics where title like '%can%' and stid = 5
-- union
-- SELECT qid, q_username, title, q_body, post_time, 0.0 as score, 0.4 as weight, stid from questions 
-- natural join subjecttopics where q_body like '%can%' and stid = 5
-- ) as q group by qid, title, q_body, post_time having weights > 0 or scores > 0 order by sum(weight) desc, sum(score) desc, post_time desc

-- select qid, q_username, title, q_body, sum(weight), sum(score) from(
-- SELECT qid, q_username, title, q_body, post_time, match (q_body) against ('can' with query expansion) as score, 0.0 as weight, stid from questions
-- union
-- SELECT qid, q_username, title, q_body, post_time, match (title) against ('can' with query expansion) as score, 0.0 as weight, stid from questions
-- union
-- SELECT qid, q_username, title, q_body, post_time, 0.0 as score, 0.6 as weight, stid from questions where title like '%can%'
-- union
-- SELECT qid, q_username, title, q_body, post_time, 0.0 as score, 0.4 as weight, stid from questions where q_body like '%can%'
-- ) as q natural join subjecttopics natural join generaltopics group by qid, q_username, title, q_body, post_time having sum(weight) > 0 or sum(score) > 0 order by sum(weight) desc, sum(score) desc, post_time desc

--     select qid, q_username, concat(gtname, ' / ', stname) as topics , title, q_body, post_time, status from(
--     SELECT qid, q_username, title, q_body, post_time, match (q_body) against ('can I' with query expansion) as score, 0.0 as weight, stid, status from questions
--     union
--     SELECT qid, q_username, title, q_body, post_time, match (title) against ('can I' with query expansion) as score, 0.0 as weight, stid, status from questions
--     union
--     SELECT qid, q_username, title, q_body, post_time, 0.0 as score, 0.6 as weight, stid, status from questions where title like '%can I%'
--     union
--     SELECT qid, q_username, title, q_body, post_time, 0.0 as score, 0.4 as weight, stid, status from questions where q_body like '%can I%'
--     ) as q natural join subjecttopics natural join generaltopics group by qid, q_username, topics, title, q_body, post_time, status having sum(weight) > 0 or sum(score) > 0 order by sum(weight) desc, sum(score) desc, post_time desc


-- select aid, qid, a_username, title, a_body, thumb_ups, answer_time, best_answer, concat(gtname, ' / ', stname) as topics from(
-- select aid, qid, a_username, a_body, thumb_ups, answer_time, best_answer, match (a_body) against ('w' with query expansion) as score, 0.0 as weight, a_visible_status from answers
-- union
-- select aid, qid, a_username, a_body, thumb_ups, answer_time, best_answer, 0.0 as score, 1.0 as weight, a_visible_status from answers where a_body like '%w%'
-- ) as a natural join questions natural join subjecttopics natural join generaltopics where a_visible_status = 1 group by aid, qid, a_username, a_body, thumb_ups, answer_time, best_answer having sum(weight) > 0 or sum(score) > 0 order by sum(weight) desc, sum(score) desc, answer_time desc

-- select aid, qid, concat(gtname, ' / ', stname) as topics, a_username, title, a_body, thumb_ups, answer_time, best_answer from answers natural join questions natural join subjecttopics natural join generaltopics where q_visible_status = 1;

select firstname, lastname, phone, email, city, state, country, profile, karma_points, statusname
        from Users natual join userstatus natural join status
        where username = 'user1';