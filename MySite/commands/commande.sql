les differentes tables ici ont été créées dns la base de données "ztwen"


CREATE TABLE users(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR (255) NOT NULL,
    email VARCHAR (255) NOT NULL,
    password VARCHAR (255) NOT NULL
)

CREATE TABLE users(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR (255) NOT NULL,
    email VARCHAR (255) NOT NULL,
    password VARCHAR (255) NOT NULL,
    subscribe_date DATETIME NOT NULL
)

CREATE TABLE blocked(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    address VARCHAR (255) NOT NULL
)

CREATE TABLE warning(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    tries INT UNSIGNED
)



CREATE TABLE f_categories(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR (255) NOT NULL
)

CREATE TABLE f_sub_categories(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_category INT UNSIGNED NOT NULL,
    sub_category VARCHAR (255) NOT NULL
)


CREATE TABLE f_topics(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_category INT UNSIGNED NOT NULL,
    id_sub_category INT UNSIGNED NOT NULL,
    id_user INT UNSIGNED NOT NULL,
    content TEXT (300) NOT NULL,
    created_at DATETIME NOT NULL,
    notif INT,
    resolved INT,
    best_answer INT,
    views INT,
    edited DATETIME
)

CREATE TABLE f_topics_answers(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_topic INT UNSIGNED NOT NULL,
    answers TEXT (500) NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    answer_date DATETIME NOT NULL,
    liked INT,
    disliked INT,
    is_best INT UNSIGNED
)


