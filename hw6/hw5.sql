CREATE TABLE user (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(64) NOT NULL,
	hint VARCHAR(64) NOT NULL,
    access INTEGER(1)
);

CREATE TABLE tutor (
	id INT AUTO_INCREMENT PRIMARY KEY,
	u_id INT NOT NULL,
	FOREIGN KEY(u_id) REFERENCES user(id)
);

CREATE TABLE practice (
	id INT AUTO_INCREMENT PRIMARY KEY,
	practiceQuestion VARCHAR(100) NOT NULL,
	questionOption1 VARCHAR(100) NOT NULL,
	questionOption2 VARCHAR(100) NOT NULL,
	questionOption3 VARCHAR(100) NOT NULL
);

CREATE TABLE student (
	id INT AUTO_INCREMENT PRIMARY KEY,
	u_id INT NOT NULL,
	t_id INT NOT NULL,
	p_id INT, /* set when practice is added */
	FOREIGN KEY(u_id) REFERENCES user(id),
	FOREIGN KEY(t_id) REFERENCES tutor(id),/*each student only has one tutor*/
	FOREIGN KEY(p_id) REFERENCES practice(id)/*each student only has one practice question*/
); 

CREATE TABLE sessionHistories (
	id INT AUTO_INCREMENT PRIMARY KEY,
	s_date DATE NOT NULL,
	s_description VARCHAR(100) NOT NULL
);

CREATE TABLE studentSessions (
	student_id INT NOT NULL,
	session_id INT NOT NULL,
	FOREIGN KEY(student_id) REFERENCES student(id),
	FOREIGN KEY(session_id) REFERENCES sessionHistories(id)
);

CREATE TABLE messages ( /* these are only student messages from their side */
	id INT AUTO_INCREMENT PRIMARY KEY,
	m_date DATE NOT NULL,
	m_description VARCHAR(100) NOT NULL, /* include to and from params */
	studentSentMessage BOOL NOT NULL
);

CREATE TABLE studentMessages (
	s_id INT NOT NULL,
	m_id INT NOT NULL,
	FOREIGN KEY(s_id) REFERENCES student(id),
	FOREIGN KEY(m_id) REFERENCES messages(id)
);