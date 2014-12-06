SELECT tea_id, name, lname, fac_id, email, pic
FROM Teachers
WHERE tea_id IN
(SELECT t.tea_id
FROM Teachers t
LEFT JOIN Teacher_Course_Detail tcd on (t.tea_id = tcd.tea_id)
WHERE tcd.tea_id IS null)

-- เลือก Teacher ID ทั้งหมด ยกเว้นใน  Teacher_Course_Detail และ course_id = 1

SELECT t.tea_id, name, lname, fac_id, email, pic
FROM Teachers t
LEFT JOIN
(
  SELECT tea_id FROM Teacher_Course_Detail WHERE course_id = 1
)
tcd on (t.tea_id = tcd.tea_id)
WHERE tcd.tea_id IS null


-- เลือกรายละเอียด


-- เลือกเวลา ระว่างเวลา
SELECT *
FROM Exam_Papers
WHERE starttime <= '2014-10-03 9:15:00' AND endtime >= '2014-10-03 9:15:00'


-- รายงาน ตามวิชา  (บอก ผู้ลงสอบ , เข้าสอบ, เฉลี่ย, min, max)

select c.course_id, subject_id, code, year, name, shortname, c.visible, c.status,
paper_id, getEnrollCount(c.course_id) AS enrollcount,count(stu_id) AS testedcount,
avg(Score) AS average,min(Score) AS minimum,max(Score) AS maximum
from courseslist_view c
left join scoreboard s on c.course_id = s.course_id

group by s.course_id
ORDER BY c.code ASC


