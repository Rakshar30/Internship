--Table 1: Students:
create table students(
student_id int primary key,
student_name varchar(50),
age int,
city varchar(100)
);

insert into students values(1,'ravi',21,'Bangalore'),(2,'priya',22,'mysore'),(3,'amit',20,'Bangalore'),(4,'sneha',23,'Mangalore'),(5,'rahul',21,'Mysore');

select * from students;

--Table 2:Courses:
create table courses(
course_id int primary key,
course_name varchar(100),
fee int
);

insert into courses values(101,'Web Development',30000),(102,'Data Science',40000),(103,'Cyber Security',35000);

select * from courses;

--Table 3:Enrollments:
create table enrollments(
enroll_id int,
student_id int,
foreign key(student_id) references students(student_id),
course_id int,
foreign key(course_id) references courses(course_id),
marks int
);

insert into enrollments values(1,1,101,85),(2,2,102,90),(3,3,101,75),(4,4,103,88),(5,5,101,70);

select * from enrollments;

--1) Display student name and course name:
select students.student_name, courses.course_name from students join enrollments on students.student_id=enrollments.student_id join courses on enrollments.course_id=courses.course_id;

--2) Display students who live in Bangalore:
select student_name from students where city='Bangalore';

--3) Display students whose age is greater than 21:
select student_name from students where age>21;

--4) Display students who live in Mysore OR Bangalore:
select student_name from students where city='Mysore' OR city="Bangalore";

--5) Display students who live in Bangalore AND age>20:
select student_name from students where city='Bangalore' AND age>20;

--6) Display students whose marks are between 70 and 90:
select students.student_name from students inner join enrollments on students.student_id=enrollments.student_id where enrollments.marks between 70 AND 90;

--7) Display students with their course names and marks:
select students.student_name, courses.course_name, enrollments.marks from students join enrollments on students.student_id=enrollments.student_id join courses on enrollments.course_id=courses.course_id;

--8) Display students ordered by marks in descending order:
select students.student_name, enrollments.marks 
from students 
join enrollments 
on students.student_id=enrollments.student_id 
order by enrollments.marks desc; 

--9) Display students ordered by name alphabetically:
SELECT student_name FROM students ORDER BY student_name ASC;

--10) Find Average marks for each course:
select courses.course_name, AVG(enrollments.marks)
from courses
join enrollments
on courses.course_id = enrollments.course_id
group by courses.course_name;

--11) Find total number of students enrolled in each course:
SELECT courses.course_name, COUNT(enrollments.student_id)
FROM courses
join enrollments
on courses.course_id=enrollments.course_id
GROUP BY courses.course_name;

--12) Display courses having more than 1 student:
Select courses.course_name, COUNT(enrollments.student_id)
From courses
Join enrollments
On courses.course_id = enrollments.course_id
Group by courses.course_name
Having count (enrollments.student_id) > 1;

--13) Display courses where average marks are greater than 80: 
SELECT courses.course_name, AVG(enrollments.marks)
FROM courses
JOIN enrollments
ON courses.course_id = enrollments.course_id
GROUP BY courses.course_name
HAVING AVG(enrollments.marks) > 80;

--14) Display students whose marks are greater than 80: 
SELECT students.student_name, enrollments.marks
FROM students
JOIN enrollments
ON students.student_id = enrollments.student_id
WHERE enrollments.marks > 80;

--15) Display student name,course name and fee: 
SELECT students.student_name, courses.course_name, courses.fee
FROM students
JOIN enrollments
ON students.student_id = enrollments.student_id
JOIN courses
ON enrollments.course_id = courses.course_id;
