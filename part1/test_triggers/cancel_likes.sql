-- test after insert new likes
update Likes
set like_status = 0
where (username = 'user2' and aid = 1) or (username = 'user1' and aid = 1)