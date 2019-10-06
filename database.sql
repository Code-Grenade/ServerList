
CREATE TABLE servers(
    id          int(10) NOT NULL AUTO_INCREMENT,
    ip          varchar(32) NOT NULL,
    port        int(10) NOT NULL,
    hostname    varchar(256) NOT NULL,

    PRIMARY KEY (id)
);