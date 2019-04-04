CREATE TABLE headline(
	id SERIAL,
	content TEXT NOT NULL,
	is_active BOOLEAN
);

INSERT INTO headline(content) VALUES ('Selamat Datang di Website JDIH Kementerian BUMN');