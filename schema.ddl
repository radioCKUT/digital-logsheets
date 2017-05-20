CREATE TABLE category
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);
CREATE TABLE episode
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    playlist INT(11) NOT NULL,
    program INT(11) NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    prerecord TINYINT(1),
    prerecord_date DATE,
    draft TINYINT(1) NOT NULL,
    comment TEXT,
    programmer VARCHAR(500),
    CONSTRAINT episode_ibfk_2 FOREIGN KEY (program) REFERENCES program (id)
);
CREATE INDEX program ON episode (program);
CREATE TABLE playlist
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT
);
CREATE TABLE playlist_segments
(
    playlist INT(11) NOT NULL,
    segment INT(11) NOT NULL,
    CONSTRAINT playlist_segment_fk FOREIGN KEY (segment) REFERENCES segment (id) ON DELETE CASCADE
);
CREATE INDEX id ON playlist_segments (playlist);
CREATE INDEX segment ON playlist_segments (segment);
CREATE TABLE program
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    genres INT(11),
    active TINYINT(1)
);
CREATE TABLE segment
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    station_id TINYINT(1),
    ad_number INT(11),
    name VARCHAR(255),
    album VARCHAR(255),
    author VARCHAR(255),
    approx_duration_mins INT(11),
    start_time DATETIME,
    category INT(11),
    can_con TINYINT(1),
    new_release TINYINT(1),
    french_vocal_music TINYINT(1),
    CONSTRAINT segment_ibfk_1 FOREIGN KEY (category) REFERENCES category (id)
);
CREATE INDEX category ON segment (category);
