DROP TABLE IF EXISTS album;
CREATE TABLE album
(
  id          INT(12) PRIMARY KEY AUTO_INCREMENT,
  name        VARCHAR(255),
  artist_name VARCHAR(255),
  pic         VARCHAR(255)
)
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS music;
CREATE TABLE music
(
  id       INT(12) PRIMARY KEY AUTO_INCREMENT,
  name     VARCHAR(255),
  album_id INT(12),
  src      VARCHAR(255)
)
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS user;
CREATE TABLE user
(
  id       INT(12) PRIMARY KEY AUTO_INCREMENT,
  account  VARCHAR(255),
  password VARCHAR(255),
  hash     VARCHAR(255)
)
  DEFAULT CHARSET = utf8;
INSERT INTO user (id, account, password, hash)
VALUES
  (1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'c30807e6587ade285ba7ade9f881b3d7');

