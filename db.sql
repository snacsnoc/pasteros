/* table creation for postgresql */
CREATE SEQUENCE content_seq START 1;
/* if having permisson errors, use this */
ALTER TABLE content_seq OWNER TO TABLEUSER;

CREATE table content (
id int NOT NULL UNIQUE PRIMARY KEY DEFAULT nextval('content_seq'), 
name  VARCHAR(60) NULL,
content  TEXT NOT NULL,
visible boolean DEFAULT TRUE,
time TIMESTAMP DEFAULT now()
);

