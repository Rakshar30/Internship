--1. Creating A Table:
CREATE TABLE students(
  id INT PRIMARY KEY  AUTO_INCREMENT,
  name varchar(50) not null,
  age INT,
  course varchar(50),
  marks INT
);

--2. Inserting Records :
insert into students(name,age,course,marks) values('Ravi',21,'MCA',85);
insert into students(name,age,course,marks) values('Priya',22,'BCA',78);
insert into students(name,age,course,marks) values('Amit',20,'Bsc',90);
insert into students(name,age,course,marks) values('Sneha',21,'MCA',88);
insert into students(name,age,course,marks) values('Rahul',23,'BCA',70);

--3. Displaying All Records :
select * from students;

--4. WHERE Condition :
select * from students WHERE course='MCA';

--5. Operators :
select * from students WHERE age>21;
select * from students WHERE marks>80 AND course='MCA';

--6. ORDERBY :
select * from students ORDER BY marks DESC;

--7. Update Data :
UPDATE students set marks=90 WHERE name='Ravi';
select * from students;
 
--8. Delete Record :
delete from students WHERE name='Rahul';
select * from students;
 
--9. Aggregate Functions :
select count(*) from students;
select avg(marks) from students;
select max(marks) from students;

 


