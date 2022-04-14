CREATE DATABASE gradeview;

CREATE TABLE teachers (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    expertise VARCHAR(255),
    PRIMARY KEY(id)
);

CREATE TABLE courses (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    year YEAR NOT NULL,
    teacher_id INT,
    PRIMARY KEY(id),
    FOREIGN KEY (teacher_id) REFERENCES teachers(id)
);

CREATE TABLE students (
    id INT NOT NULL AUTO_INCREMENT,
    faculty_number INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    course_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

CREATE TABLE papers (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  student_id INT,
  is_presented BOOLEAN,
  presentation_time TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (student_id) REFERENCES students(id)
);

CREATE TABLE student_paper_pivot (
    id INT NOT NULL AUTO_INCREMENT,
    student_id INT,
    paper_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (paper_id) REFERENCES papers(id)
);
