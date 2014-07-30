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