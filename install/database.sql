CREATE TABLE IF NOT EXISTS tag (
tag_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(128) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS `user` (
uid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(100) NOT NULL, 
email VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(255), 
roles JSON NOT NULL DEFAULT '[]',
registered DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS exercise (
exercise_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
text TEXT NOT NULL,
duration INT, 
points INT
);

CREATE TABLE IF NOT EXISTS `image` (
image_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
imagepath VARCHAR (250) NOT NULL,
description TEXT, 
uid INT NOT NULL,
FOREIGN KEY (uid) REFERENCES user(uid)
);

CREATE TABLE IF NOT EXISTS exercise_tag (
exercise_id INT NOT NULL,
tag_id INT NOT NULL,
PRIMARY KEY (exercise_id, tag_id),
FOREIGN KEY (exercise_id) REFERENCES exercise(exercise_id),
FOREIGN KEY (tag_id) REFERENCES tag(tag_id)
);

CREATE TABLE IF NOT EXISTS done_exercise (
solution_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
exercise_id INT NOT NULL,
done_by INT NOT NULL,
solution TEXT NOT NULL,
checked TINYINT(1) NOT NULL DEFAULT 0,
FOREIGN KEY (exercise_id) REFERENCES exercise(exercise_id),
FOREIGN KEY (done_by) REFERENCES user(uid)
);

CREATE TABLE IF NOT EXISTS comment (
comment_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
uid INT NOT NULL,
solution_id INT NOT NULL,
comment TEXT NOT NULL,
points INT, 
FOREIGN KEY (uid) REFERENCES `user`(uid),
FOREIGN KEY (solution_id) REFERENCES done_exercise(solution_id)
);

CREATE TABLE IF NOT EXISTS image_in_post (
image_id INT NOT NULL,
solution INT,
exercise INT,
comment INT,
PRIMARY KEY (image_id, solution, exercise, comment),
FOREIGN KEY (image_id) REFERENCES `image`(image_id),
FOREIGN KEY (solution) REFERENCES done_exercise(solution_id),
FOREIGN KEY (exercise) REFERENCES exercise(exercise_id),
FOREIGN KEY (comment) REFERENCES comment(comment_id)
);