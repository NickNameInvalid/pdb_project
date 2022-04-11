select Users.username, 
case
  when count(*) < 2 then 'basic'
  when count(*) < 3 then 'advanced'
  else 'expert'
end as status
from Users left join Likes
on Users.username = Likes.username
group by Users.username